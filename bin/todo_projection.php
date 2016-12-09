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

namespace Prooph\ProophessorDo;

use Prooph\EventStore\EventStore;
use Prooph\EventStore\PDO\MySQLEventStore;
use Prooph\EventStore\PDO\PostgresEventStore;
use Prooph\EventStore\PDO\Projection\MySQLEventStoreReadModelProjection;
use Prooph\EventStore\PDO\Projection\PostgresEventStoreReadModelProjection;
use Prooph\ProophessorDo\Model\Todo\Event\DeadlineWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\ReminderWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasReopened;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasUnmarkedAsExpired;
use Prooph\ProophessorDo\Projection\User\UserReadModel;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$container = require 'config/container.php';

$eventStore = $container->get(EventStore::class);

$pdo = $container->get('pdo.connection');

$readModel = new UserReadModel($container->get('doctrine.connection.default'));

if ($eventStore instanceof MySQLEventStore) {
    $projection = new MySQLEventStoreReadModelProjection(
        $eventStore,
        $pdo,
        'todo',
        $readModel,
        'event_streams',
        'projections',
        2000,
        10,
        100
    );
} elseif ($eventStore instanceof PostgresEventStore) {
    $projection = new PostgresEventStoreReadModelProjection(
        $eventStore,
        $pdo,
        'todo',
        $readModel,
        'event_streams',
        'projections',
        2000,
        10,
        100
    );
} else {
    throw new \RuntimeException('Unknown event store implementation used.');
}

$projection
    ->fromStream('event_stream')
    ->when([
        TodoWasPosted::class => function ($state, TodoWasPosted $event) {
            $this->readModel()->stack('insert', [
                'id' => $event->todoId()->toString(),
                'assignee_id' => $event->assigneeId()->toString(),
                'text' => $event->text(),
                'status' => $event->todoStatus()->toString(),
            ]);
        },
        TodoWasMarkedAsDone::class => function ($state, TodoWasMarkedAsDone $event) {
            $this->readModel()->stack(
                'update',
                [
                    'status' => $event->newStatus()->toString(),
                ],
                [
                    'id' => $event->todoId()->toString(),
                ]
            );
        },
        TodoWasReopened::class => function ($state, TodoWasReopened $event) {
            $this->readModel()->stack(
                'update',
                [
                    'status' => $event->status()->toString(),
                ],
                [
                    'id' => $event->todoId()->toString(),
                ]
            );
        },
        DeadlineWasAddedToTodo::class => function ($state, DeadlineWasAddedToTodo $event) {
            $this->readModel()->stack(
                'update',
                [
                    'deadline' => $event->deadline()->toString(),
                ],
                [
                    'id' => $event->todoId()->toString(),
                ]
            );
        },
        ReminderWasAddedToTodo::class => function ($state, ReminderWasAddedToTodo $event) {
            $this->readModel()->stack(
                'update',
                [
                    'reminder' => $event->reminder()->toString(),
                ],
                [
                    'id' => $event->todoId()->toString(),
                ]
            );
        },
        TodoWasMarkedAsExpired::class => function ($state, TodoWasMarkedAsExpired $event) {
            $this->readModel()->stack(
                'update',
                [
                    'status' => $event->newStatus()->toString(),
                ],
                [
                    'id' => $event->todoId()->toString(),
                ]
            );
        },
        TodoWasUnmarkedAsExpired::class => function ($state, TodoWasUnmarkedAsExpired $event) {
            $this->readModel()->stack(
                'update',
                [
                    'status' => $event->newStatus()->toString(),
                ],
                [
                    'id' => $event->todoId()->toString(),
                ]
            );
        },
    ])
    ->run();
