<?php

namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\Todo\Command\MarkTodoAsExpired;
use Prooph\ProophessorDo\Model\Todo\Exception\TodoNotFound;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class MarkTodoAsExpiredHandler
 *
 * @package Prooph\ProophessorDo\Model\Todo
 */
final class MarkTodoAsExpiredHandler
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
     * @param MarkTodoAsExpired $command
     */
    public function __invoke(MarkTodoAsExpired $command)
    {
        $todo = $this->todoList->get($command->todoId());

        if (!$todo) {
            throw TodoNotFound::withTodoId($command->todoId());
        }

        $todo->markAsExpired();
    }
}
