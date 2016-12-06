<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
