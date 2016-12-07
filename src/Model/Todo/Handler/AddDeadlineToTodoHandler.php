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
