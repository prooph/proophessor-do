<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 5:44 PM
 */
namespace Prooph\ProophessorDo\Projection\Todo;

use Doctrine\DBAL\Connection;
use Prooph\ProophessorDo\Model\Todo\Event\ReminderWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\TodoAssigneeWasReminded;
use Prooph\ProophessorDo\Projection\Table;

/**
 * Class TodoReminderProjector
 *
 * @package Prooph\ProophessorDo\Projection\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class TodoReminderProjector
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param ReminderWasAddedToTodo $event
     * @return void
     */
    public function onReminderWasAddedToTodo(ReminderWasAddedToTodo $event)
    {
        // remove other reminder for todo first
        $this->connection->delete(
            Table::TODO_REMINDER,
            [
                'todo_id' => $event->todoId()->toString(),
            ]
        );

        $reminder = $event->reminder();
        $this->connection->insert(
            Table::TODO_REMINDER,
            [
                'todo_id' => $event->todoId()->toString(),
                'reminder' => $reminder->toString(),
                'status' => $reminder->status()->toString(),
            ]
        );
    }

    /**
     * @param TodoAssigneeWasReminded $event
     * @return void
     */
    public function onTodoAssigneeWasReminded(TodoAssigneeWasReminded $event)
    {
        $this->connection->update(
            Table::TODO_REMINDER,
            [
                'status' => $event->reminder()->status()->toString(),
            ],
            [
                'todo_id' => $event->todoId()->toString(),
            ]
        );
    }
}
