<?php

namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\Todo\Command\AddDeadlineToTodo;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class AddDeadlineToTodoHandler
 *
 * @package Prooph\ProophessorDo\Model\Todo\Handler
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
final class AddDeadlineToTodoHandler
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
     * @param AddDeadlineToTodo $command
     * @return void
     */
    public function __invoke(AddDeadlineToTodo $command)
    {
        $todo = $this->todoList->get($command->todoId());
        $todo->addDeadline($command->userId(), $command->deadline());
    }
}
