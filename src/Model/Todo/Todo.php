<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 5:20 PM
 */
namespace Prooph\ProophessorDo\Model\Todo;

use Assert\Assertion;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\ProophessorDo\Model\Todo\Event\DeadlineWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\ReminderWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\TodoAssigneeWasReminded;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasReopened;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasUnmarkedAsExpired;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class Todo
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class Todo extends AggregateRoot
{
    /**
     * @var TodoId
     */
    private $todoId;

    /**
     * @var UserId
     */
    private $assigneeId;

    /**
     * @var string
     */
    private $text;

    /**
     * @var TodoStatus
     */
    private $status;

    /**
     * @var \DateTimeImmutable
     */
    private $deadline;

    /**
     * @var TodoReminder
     */
    private $reminder;

    /**
     * @var bool
     */
    private $reminded = false;

    /**
     * @param string $text
     * @param UserId $assigneeId
     * @param TodoId $todoId
     * @return Todo
     */
    public static function post($text, UserId $assigneeId, TodoId $todoId)
    {
        $self = new self();
        $self->assertText($text);
        $self->recordThat(TodoWasPosted::byUser($assigneeId, $text, $todoId, TodoStatus::open()));

        return $self;
    }

    /**
     * @throws Exception\TodoNotOpen
     */
    public function markAsDone()
    {
        $status = TodoStatus::fromString('done');
        if (!$this->status->isOpen()) {
            throw Exception\TodoNotOpen::triedStatus($status, $this);
        }
        $this->recordThat(TodoWasMarkedAsDone::fromStatus($this->todoId, $this->status, $status));
    }

    /**
     * @param UserId $userId
     * @param TodoDeadline $deadline
     * @return void
     * @throws Exception\InvalidDeadline
     * @throws Exception\TodoNotOpen
     */
    public function addDeadline(UserId $userId, TodoDeadline $deadline)
    {
        if (!$this->assigneeId()->sameValueAs($userId)) {
            throw Exception\InvalidDeadline::userIsNotAssignee($userId, $this->assigneeId());
        }

        if ($deadline->isInThePast()) {
            throw Exception\InvalidDeadline::deadlineInThePast($deadline);
        }

        if ($this->status->isDone()) {
            throw Exception\TodoNotOpen::triedToAddDeadline($deadline, $this->status);
        }

        $this->recordThat(DeadlineWasAddedToTodo::byUserToDate($this->todoId, $this->assigneeId, $deadline));

        if ($this->isMarkedAsExpired()) {
            $this->unmarkAsExpired();
        }
    }

    /**
     * @return null
     * @throws Exception\TodoNotExpired
     * @throws Exception\TodoNotOpen
     */
    public function markAsExpired()
    {
        $status = TodoStatus::fromString(TodoStatus::EXPIRED);

        if (!$this->status->isOpen() || $this->status->isExpired()) {
            throw Exception\TodoNotOpen::triedToExpire($this->status, $this);
        }

        if ($this->deadline->isMet()) {
            throw Exception\TodoNotExpired::withDeadline($this->deadline, $this);
        }

        $this->recordThat(TodoWasMarkedAsExpired::fromStatus($this->todoId, $this->status, $status));
    }

    /**
     * @return null
     * @throws Exception\TodoNotExpired
     */
    public function unmarkAsExpired()
    {
        $status = TodoStatus::fromString(TodoStatus::OPEN);

        if (!$this->isMarkedAsExpired()) {
            throw Exception\TodoNotExpired::withDeadline($this->deadline, $this);
        }

        $this->recordThat(TodoWasUnmarkedAsExpired::fromStatus($this->todoId, $this->status, $status));
    }

    private function isExpired()
    {
        if (!$this->status->isOpen() || $this->status->isExpired()) {
            return false;
        }

        if ($this->deadline->isMet()) {
            return false;
        }

        return true;
    }

    private function isMarkedAsExpired()
    {
        return $this->status->isExpired();
    }

    /**
     * @param UserId $userId
     * @param TodoReminder $reminder
     * @return void
     * @throws Exception\InvalidReminder
     */
    public function addReminder(UserId $userId, TodoReminder $reminder)
    {
        if (!$this->assigneeId()->sameValueAs($userId)) {
            throw Exception\InvalidReminder::userIsNotAssignee($userId, $this->assigneeId());
        }

        if ($reminder->isInThePast()) {
            throw Exception\InvalidReminder::reminderInThePast($reminder);
        }

        if ($this->status->isDone()) {
            throw Exception\TodoNotOpen::triedToAddReminder($reminder, $this->status);
        }

        $this->recordThat(ReminderWasAddedToTodo::byUserToDate($this->todoId, $this->assigneeId, $reminder));
    }

    /**
     * @param TodoReminder $reminder
     * @throws Exception\InvalidReminder
     */
    public function remindAssignee(TodoReminder $reminder)
    {
        if ($this->status->isDone()) {
            throw Exception\TodoNotOpen::triedToAddReminder($reminder, $this->status);
        }

        if (!$this->reminder->equals($reminder)) {
            throw Exception\InvalidReminder::reminderNotCurrent($this->reminder, $reminder);
        }

        if (!$this->reminder->isOpen()) {
            throw Exception\InvalidReminder::alreadyReminded();
        }

        if ($reminder->isInTheFuture()) {
            throw Exception\InvalidReminder::reminderInTheFuture($reminder);
        }

        $this->recordThat(TodoAssigneeWasReminded::forAssignee($this->todoId, $this->assigneeId, $reminder->close()));
    }

    public function reopenTodo()
    {
        if (!$this->status->isDone()) {
            throw Exception\CannotReopenTodo::notMarkedDone($this);
        }

        $this->recordThat(TodoWasReopened::withStatus($this->todoId, TodoStatus::fromString(TodoStatus::OPEN)));
    }

    /**
     * @return \DateTimeImmutable
     */
    public function deadline()
    {
        return $this->deadline;
    }

    /**
     * @return TodoReminder
     */
    public function reminder()
    {
        return $this->reminder;
    }

    /**
     * @return bool
     */
    public function assigneeWasReminded()
    {
        return $this->reminded;
    }

    /**
     * @return TodoId
     */
    public function todoId()
    {
        return $this->todoId;
    }

    /**
     * @return string
     */
    public function text()
    {
        return $this->text;
    }

    /**
     * @return UserId
     */
    public function assigneeId()
    {
        return $this->assigneeId;
    }

    /**
     * @return TodoStatus
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @param TodoWasPosted $event
     */
    protected function whenTodoWasPosted(TodoWasPosted $event)
    {
        $this->todoId = $event->todoId();
        $this->assigneeId = $event->assigneeId();
        $this->text = $event->text();
        $this->status = $event->todoStatus();
    }

    /**
     * @param TodoWasMarkedAsDone $event
     */
    protected function whenTodoWasMarkedAsDone(TodoWasMarkedAsDone $event)
    {
        $this->status = $event->newStatus();
    }

    /**
     * @param TodoWasMarkedAsExpired $event
     */
    protected function whenTodoWasMarkedAsExpired(TodoWasMarkedAsExpired $event)
    {
        $this->status = $event->newStatus();
    }

    /**
     * @param TodoWasUnmarkedAsExpired $event
     */
    protected function whenTodoWasUnmarkedAsExpired(TodoWasUnmarkedAsExpired $event)
    {
        $this->status = $event->newStatus();
    }

    /**
     * @param TodoWasReopened $event
     */
    protected function whenTodoWasReopened(TodoWasReopened $event)
    {
        $this->status = $event->status();
    }

    /**
     * @param DeadlineWasAddedToTodo $event
     * @return void
     */
    protected function whenDeadlineWasAddedToTodo(DeadlineWasAddedToTodo $event)
    {
        $this->deadline = $event->deadline();
    }

    /**
     * @param ReminderWasAddedToTodo $event
     * @return void
     */
    protected function whenReminderWasAddedToTodo(ReminderWasAddedToTodo $event)
    {
        $this->reminder = $event->reminder();
    }

    /**
     * @param TodoAssigneeWasReminded $event
     * @return void
     */
    protected function whenTodoAssigneeWasReminded(TodoAssigneeWasReminded $event)
    {
        $this->reminder = $event->reminder();
    }

    /**
     * @return string representation of the unique identifier of the aggregate root
     */
    protected function aggregateId()
    {
        return $this->todoId->toString();
    }

    /**
     * @param string $text
     * @throws Exception\InvalidText
     */
    private function assertText($text)
    {
        try {
            Assertion::string($text);
            Assertion::minLength($text, 3);
        } catch (\Exception $e) {
            throw Exception\InvalidText::reason($e->getMessage());
        }
    }
}
