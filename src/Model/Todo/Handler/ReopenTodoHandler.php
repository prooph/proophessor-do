<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 2/16/16
 */
namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\Todo\Command\ReopenTodo;
use Prooph\ProophessorDo\Model\Todo\Exception\TodoNotFound;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class ReopenTodoHandler
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author  Bas Kamer <bas@bushbaby.nl>
 */
final class ReopenTodoHandler
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
     * @param ReopenTodo $command
     */
    public function __invoke(ReopenTodo $command)
    {
        $todo = $this->todoList->get($command->todoId());
        if (! $todo) {
            throw TodoNotFound::withTodoId($command->todoId());
        }

        $todo->reopenTodo();
    }
}
