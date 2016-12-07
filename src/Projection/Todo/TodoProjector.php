<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Projection\Todo;

use Doctrine\DBAL\Connection;
use Prooph\ProophessorDo\Model\Todo\Event\DeadlineWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\ReminderWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasReopened;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasUnmarkedAsExpired;
use Prooph\ProophessorDo\Projection\Table;

class TodoProjector
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function onTodoWasPosted(TodoWasPosted $event): void
    {
        $this->connection->insert(Table::TODO, [
            'id' => $event->todoId()->toString(),
            'assignee_id' => $event->assigneeId()->toString(),
            'text' => $event->text(),
            'status' => $event->todoStatus()->toString(),
        ]);
    }

    public function onTodoWasMarkedAsDone(TodoWasMarkedAsDone $event): void
    {
        $this->connection->update(Table::TODO,
            [
                'status' => $event->newStatus()->toString(),
            ],
            [
                'id' => $event->todoId()->toString(),
            ]
        );
    }

    public function onTodoWasReopened(TodoWasReopened $event): void
    {
        $this->connection->update(Table::TODO,
            [
                'status' => $event->status()->toString(),
            ],
            [
                'id' => $event->todoId()->toString(),
            ]
        );
    }

    public function onDeadlineWasAddedToTodo(DeadlineWasAddedToTodo $event): void
    {
        $this->connection->update(
            Table::TODO,
            [
                'deadline' => $event->deadline()->toString(),
            ],
            [
                'id' => $event->todoId()->toString(),
            ]
        );
    }

    public function onReminderWasAddedToTodo(ReminderWasAddedToTodo $event): void
    {
        $this->connection->update(
            Table::TODO,
            [
                'reminder' => $event->reminder()->toString(),
            ],
            [
                'id' => $event->todoId()->toString(),
            ]
        );
    }

    public function onTodoWasMarkedAsExpired(TodoWasMarkedAsExpired $event): void
    {
        $this->connection->update(Table::TODO,
            [
                'status' => $event->newStatus()->toString(),
            ],
            [
                'id' => $event->todoId()->toString(),
            ]
        );
    }

    public function onTodoWasUnmarkedAsExpired(TodoWasUnmarkedAsExpired $event): void
    {
        $this->connection->update(Table::TODO,
            [
                'status' => $event->newStatus()->toString(),
            ],
            [
                'id' => $event->todoId()->toString(),
            ]
        );
    }
}
