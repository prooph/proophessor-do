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

use Prooph\ProophessorDo\Model\User\UserId;
use Assert\Assertion;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;

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
