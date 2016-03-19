<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/15/15 - 8:48 PM
 */
namespace ProophTest\ProophessorDo\Model\Todo;

use Prooph\ProophessorDo\Model\Todo\Event\DeadlineWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\ReminderWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\TodoAssigneeWasReminded;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Exception\InvalidReminder;
use Prooph\ProophessorDo\Model\Todo\Exception\TodoNotExpired;
use Prooph\ProophessorDo\Model\Todo\Exception\TodoNotOpen;
use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoDeadline;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoReminder;
use Prooph\ProophessorDo\Model\Todo\TodoReminderStatus;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;
use Prooph\ProophessorDo\Model\User\UserId;
use ProophTest\ProophessorDo\TestCase;

/**
 * Class TodoTest
 *
 * @package ProophTest\ProophessorDo\Model\Todo
 */
final class TodoTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_new_todo_when_posting_a_text()
    {
        $assigneeId = UserId::generate();
        $todoId = TodoId::generate();

        $todo = Todo::post('This is test todo', $assigneeId, $todoId);

        $this->assertInstanceOf(Todo::class, $todo);

        $events = $this->popRecordedEvent($todo);

        $this->assertEquals(1, count($events));

        $this->assertInstanceOf(TodoWasPosted::class, $events[0]);

        $expectedPayload = [
            'text' => 'This is test todo',
            'assignee_id' => $assigneeId->toString(),
            'status' => 'open'
        ];

        $this->assertEquals($expectedPayload, $events[0]->payload());
    }

    /**
     * @test
     */
    public function it_marks_an_open_todo_as_done()
    {
        $todoId = TodoId::generate();
        $todo = Todo::post('This is an unit test todo', UserId::generate(), $todoId);
        $todo->markAsDone();

        $this->assertTrue($todo->status()->isDone());

        $events = $this->popRecordedEvent($todo);

        $this->assertEquals(2, count($events));

        $this->assertInstanceOf(TodoWasMarkedAsDone::class, $events[1]);

        $expectedPayload = [
            'old_status' => 'open',
            'new_status' => 'done'
        ];

        $this->assertEquals($expectedPayload, $events[1]->payload());

        return $todo;
    }

    /**
     * @test
     * @depends it_marks_an_open_todo_as_done
     * @expectedException \Prooph\ProophessorDo\Model\Todo\Exception\TodoNotOpen
     */
    public function it_throws_an_exception_when_marking_a_todo_already_done_as_done(Todo $todo)
    {
        $todo->markAsDone();
    }

    /**
     * @test
     */
    public function it_adds_a_deadline_to_todo()
    {
        $todoId = TodoId::generate();
        $userId = UserId::generate();
        $deadline = TodoDeadline::fromString('2047-12-31 12:00:00');
        $todo = Todo::post('Do something tomorrow', $userId, $todoId);

        $this->assertNull($todo->deadline());

        $todo->addDeadline($userId, $deadline);
        $events = $this->popRecordedEvent($todo);

        $this->assertEquals(2, count($events));

        $this->assertInstanceOf(DeadlineWasAddedToTodo::class, $events[1]);

        $expectedPayload = [
            'todo_id' => $todoId->toString(),
            'user_id' => $userId->toString(),
            'deadline' => $deadline->toString(),
        ];

        $this->assertEquals($expectedPayload, $events[1]->payload());

        return $todo;
    }

    /**
     * @test
     * @param Todo $todo
     * @depends it_adds_a_deadline_to_todo
     * @return Todo
     */
    public function it_can_add_another_deadline_if_desired(Todo $todo)
    {
        $todo->addDeadline(
            $todo->assigneeId(),
            TodoDeadline::fromString('2047-12-11 12:00:00')
        );
        $events = $this->popRecordedEvent($todo);

        $this->assertEquals(1, count($events));
        $this->assertInstanceOf(DeadlineWasAddedToTodo::class, $events[0]);

        return $todo;
    }

    /**
     * @test
     * @expectedException \Prooph\ProophessorDo\Model\Todo\Exception\InvalidDeadline
     * @depends it_adds_a_deadline_to_todo
     */
    public function it_throws_an_exception_if_deadline_is_in_the_past(Todo $todo)
    {
        $todo->addDeadline(
            $todo->assigneeId(),
            TodoDeadline::fromString('1980-12-11 12:00:00')
        );
    }

    /**
     * @test
     * @expectedException \Prooph\ProophessorDo\Model\Todo\Exception\InvalidDeadline
     * @depends it_adds_a_deadline_to_todo
     */
    public function it_throws_an_exception_if_user_is_not_the_assignee(Todo $todo)
    {
        $todo->addDeadline(
            UserId::generate(),
            TodoDeadline::fromString('2047-12-11 12:00:00')
        );
    }

    /**
     * @test
     * @expectedException \Prooph\ProophessorDo\Model\Todo\Exception\TodoNotOpen
     * @depends it_adds_a_deadline_to_todo
     */
    public function it_throws_an_exception_if_todo_is_closed(Todo $todo)
    {
        $todo->markAsDone();
        $todo->addDeadline(
            $todo->assigneeId(),
            TodoDeadline::fromString('2047-12-11 12:00:00')
        );
    }

    /**
     * @test
     * @return Todo
     */
    public function it_adds_a_reminder_to_todo()
    {
        $todoId = TodoId::generate();
        $userId = UserId::generate();
        $reminder = TodoReminder::fromString('2047-12-31 12:00:00', TodoReminderStatus::OPEN);
        $todo = Todo::post('Do something tomorrow', $userId, $todoId);
        $this->popRecordedEvent($todo);

        $this->assertNull($todo->reminder());

        $todo->addReminder($userId, $reminder);
        $events = $this->popRecordedEvent($todo);

        $this->assertCount(1, $events);

        $this->assertInstanceOf(ReminderWasAddedToTodo::class, $events[0]);

        $expectedPayload = [
            'todo_id' => $todoId->toString(),
            'user_id' => $userId->toString(),
            'reminder' => $reminder->toString(),
        ];

        $this->assertEquals($expectedPayload, $events[0]->payload());

        return $todo;
    }

    /**
     * @test
     * @param Todo $todo
     * @depends it_adds_a_reminder_to_todo
     * @return Todo
     */
    public function it_can_add_another_reminder_if_desired(Todo $todo)
    {
        $todo->addReminder(
            $todo->assigneeId(), TodoReminder::fromString('2047-12-11 12:00:00', TodoReminderStatus::OPEN)
        );
        $events = $this->popRecordedEvent($todo);

        $this->assertCount(1, $events);
        $this->assertInstanceOf(ReminderWasAddedToTodo::class, $events[0]);

        return $todo;
    }

    /**
     * @test
     * @param Todo $todo
     * @depends it_adds_a_reminder_to_todo
     */
    public function it_throws_an_exception_if_reminder_is_in_the_past(Todo $todo)
    {
        $this->setExpectedException(InvalidReminder::class);

        $todo->addReminder(
            $todo->assigneeId(), TodoReminder::fromString('1980-12-11 12:00:00', TodoReminderStatus::OPEN)
        );
    }

    /**
     * @test
     * @param Todo $todo
     * @depends it_adds_a_reminder_to_todo
     */
    public function it_throws_an_exception_if_user_who_adds_reminder_is_not_the_assignee(Todo $todo)
    {
        $this->setExpectedException(InvalidReminder::class);

        $todo->addReminder(
            UserId::generate(), TodoReminder::fromString('2047-12-11 12:00:00', TodoReminderStatus::OPEN)
        );
    }

    /**
     * @test
     * @param Todo $todo
     * @depends it_adds_a_reminder_to_todo
     */
    public function it_throws_an_exception_if_todo_is_closed_while_setting_a_reminder(Todo $todo)
    {
        $todo->markAsDone();

        $this->setExpectedException(TodoNotOpen::class);

        $todo->addReminder(
            $todo->assigneeId(), TodoReminder::fromString('2047-12-11 12:00:00', TodoReminderStatus::OPEN)
        );
    }

    /**
     * @test
     */
    public function it_can_remind_the_assignee()
    {
        $todo = $this->todoWithReminderInThePast();
        $todo->remindAssignee(TodoReminder::fromString('2000-12-11 12:00:00', TodoReminderStatus::OPEN));

        $events = $this->popRecordedEvent($todo);

        $this->assertCount(1, $events);
        $this->assertInstanceOf(TodoAssigneeWasReminded::class, $events[0]);

        return $todo;
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_todo_is_closed_while_reminding_the_assignee()
    {
        $todo = $this->todoWithReminderInThePast();

        $todo->markAsDone();

        $this->setExpectedException(TodoNotOpen::class);

        $todo->remindAssignee(TodoReminder::fromString('2000-12-11 12:00:00', TodoReminderStatus::OPEN));
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_assignee_should_be_notified_about_a_reminder_which_is_not_the_current_on()
    {
        $todo = $this->todoWithReminderInThePast();

        $this->setExpectedException(InvalidReminder::class);

        $todo->remindAssignee(TodoReminder::fromString('2046-12-11 12:00:00', TodoReminderStatus::OPEN));
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_assignee_should_be_notified_about_a_reminder_in_the_future()
    {
        $todo = $this->todoWithReminderInThePast();

        $reminder = TodoReminder::fromString('2046-12-11 12:00:00', TodoReminderStatus::OPEN);
        $todo->addReminder($todo->assigneeId(), $reminder);

        $this->setExpectedException(InvalidReminder::class);
        $todo->remindAssignee($reminder);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_assignee_should_be_notified_about_a_closed_reminder()
    {
        $todo = $this->todoWithReminderInThePast();

        $todo->remindAssignee(TodoReminder::fromString('2000-12-11 12:00:00', TodoReminderStatus::OPEN));

        $this->setExpectedException(InvalidReminder::class);
        $todo->remindAssignee(TodoReminder::fromString('2000-12-11 12:00:00', TodoReminderStatus::OPEN));
    }

    /**
     * @return Todo
     */
    private function todoWithReminderInThePast()
    {
        $userId = UserId::generate();
        $todoId = TodoId::generate();
        $reminder = TodoReminder::fromString('2000-12-11 12:00:00', TodoReminderStatus::OPEN);

        $events = [
            TodoWasPosted::byUser($userId, 'test', $todoId, TodoStatus::open()),
            ReminderWasAddedToTodo::byUserToDate($todoId, $userId, $reminder)
        ];

        return $this->reconstituteAggregateFromHistory(Todo::class, $events);
    }

    /**
     * @test
     * @return Todo $todo
     */
    public function it_marks_an_open_todo_as_expired()
    {
        $todoId   = TodoId::generate();
        $userId   = UserId::generate();
        $deadline = TodoDeadline::fromString('yesterday');

        $reflectionMethod = new \ReflectionProperty($deadline, 'createdOn');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->setValue($deadline, new \DateTimeImmutable('2 days ago'));
        $reflectionMethod->setAccessible(false);

        $todo = Todo::post('Do something that will be forgotten', $userId, $todoId);

        $todo->addDeadline($userId, $deadline);
        $todo->markAsExpired();

        $events = $this->popRecordedEvent($todo);

        $this->assertEquals(3, count($events));
        $this->assertInstanceOf(TodoWasMarkedAsExpired::class, $events[2]);

        $expectedPayload = [
            'old_status' => 'open',
            'new_status' => 'expired',
        ];
        $this->assertEquals($expectedPayload, $events[2]->payload());

        return $todo;
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_marking_an_open_todo_before_the_deadline()
    {
        $todoId   = TodoId::generate();
        $userId   = UserId::generate();
        $deadline = TodoDeadline::fromString('2047-12-31 12:00:00');
        $todo     = Todo::post('Do something before the deadline', $userId, $todoId);

        $todo->addDeadline($userId, $deadline);

        $this->setExpectedException(
            TodoNotExpired::class,
            'Tried to mark a non-expired Todo as expired.  Todo will expire after '
            . 'the deadline 2047-12-31T12:00:00+00:00.'
        );

        $todo->markAsExpired();
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_marking_a_completed_todo_as_expired()
    {
        $todoId   = TodoId::generate();
        $userId   = UserId::generate();
        $deadline = TodoDeadline::fromString('2047-12-31 12:00:00');
        $todo     = Todo::post('Do something fun', $userId, $todoId);

        $todo->addDeadline($userId, $deadline);
        $todo->markAsDone();

        $this->setExpectedException(TodoNotOpen::class, 'Tried to expire todo with status done.');

        $todo->markAsExpired();
    }

    /**
     * @test
     * @param Todo $todo
     * @depends it_marks_an_open_todo_as_expired
     */
    public function it_throws_an_exception_when_marking_a_todo_as_expired_when_it_has_already_been_marked_as_expired(Todo $todo)
    {
        $this->setExpectedException(TodoNotOpen::class, 'Tried to expire todo with status expired.');

        $todo->markAsExpired();
    }
}
