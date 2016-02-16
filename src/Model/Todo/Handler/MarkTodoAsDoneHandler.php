<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/15/15 - 20:45 PM
 */
namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\Todo\Command\MarkTodoAsDone;
use Prooph\ProophessorDo\Model\Todo\Exception\TodoNotFound;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class MarkTodoAsDoneHandler
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
final class MarkTodoAsDoneHandler
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
     * @param MarkTodoAsDone $command
     */
    public function __invoke(MarkTodoAsDone $command)
    {
        $todo = $this->todoList->get($command->todoId());
        if (! $todo) {
            throw TodoNotFound::withTodoId($command->todoId());
        }

        $todo->markAsDone();
    }
}
