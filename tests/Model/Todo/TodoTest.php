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
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Exception\InvalidReminder;
use Prooph\ProophessorDo\Model\Todo\Exception\TodoNotOpen;
use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoDeadline;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoReminder;
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
        $deadline = TodoDeadline::fromString('2047-12-31 12:00:00', '2047-12-01 12:00:00');
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
        $reminder = TodoReminder::fromString('2047-12-31 12:00:00');
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
        $todo->addReminder($todo->assigneeId(), TodoReminder::fromString('2047-12-11 12:00:00'));
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

        $todo->addReminder($todo->assigneeId(), TodoReminder::fromString('1980-12-11 12:00:00'));
    }

    /**
     * @test
     * @param Todo $todo
     * @depends it_adds_a_reminder_to_todo
     */
    public function it_throws_an_exception_if_user_who_adds_reminder_is_not_the_assignee(Todo $todo)
    {
        $this->setExpectedException(InvalidReminder::class);

        $todo->addReminder(UserId::generate(), TodoReminder::fromString('2047-12-11 12:00:00'));
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

        $todo->addReminder($todo->assigneeId(), TodoReminder::fromString('2047-12-11 12:00:00'));
    }
}
