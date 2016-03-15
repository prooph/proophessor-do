<?php
namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\Todo\Command\RemindTodoAssignee;
use Prooph\ProophessorDo\Model\Todo\Exception\TodoNotFound;
use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoList;
use Prooph\ProophessorDo\Model\Todo\TodoReminder;

/**
 * Class RemindTodoAssigneeHandler
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class RemindTodoAssigneeHandler
{
    /**
     * @var TodoList
     */
    private $todoList;

    /**
     * @param TodoList $todoList
     */
    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    /**
     * @param RemindTodoAssignee $command
     */
    public function __invoke(RemindTodoAssignee $command)
    {
        $todo = $this->todoList->get($command->todoId());
        if (!$todo) {
            throw TodoNotFound::withTodoId($command->todoId());
        }

        $reminder = $todo->reminder();

        if ($this->reminderShouldBeProcessed($todo, $reminder)) {
            $todo->remindAssignee($reminder);
        }
    }

    /**
     * @param Todo $todo
     * @param TodoReminder $reminder
     * @return bool
     */
    private function reminderShouldBeProcessed(Todo $todo, TodoReminder $reminder)
    {
        // drop command, wrong reminder
        if (!$todo->reminder()->equals($reminder)) {
            return false;
        }

        // drop command, reminder is closed
        if (!$reminder->isOpen()) {
            return false;
        }

        // drop command, reminder is in future
        if ($reminder->isInTheFuture()) {
            return false;
        }

        return true;
    }
}
