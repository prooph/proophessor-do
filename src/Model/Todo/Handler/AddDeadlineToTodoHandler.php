<?php

namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\Todo\Command\AddDeadlineToTodo;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class AddDeadlineToTodoHandler
 *
 * @package Prooph\ProophessorDo\Model\Todo\Handler
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
class AddDeadlineToTodoHandler
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
     * @throws \Exception
     */
    public function __invoke(AddDeadlineToTodo $command)
    {
        $todo = $this->todoList->get(TodoId::fromString($command->todoId()));

        if ($todo->assigneeId()->toString() !== $command->userId()) {
            throw new \Exception('Only assigned user can change the todo deadline');
        }

        $todo->addDeadline(new \DateTime($command->deadline()));
    }
}
