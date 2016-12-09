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
use Prooph\ProophessorDo\Model\Todo\Event\ReminderWasAddedToTodo;
use Prooph\ProophessorDo\Model\Todo\Event\TodoAssigneeWasReminded;
use Prooph\ProophessorDo\Projection\Todo\TodoReminderReadModel;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$container = require 'config/container.php';

$eventStore = $container->get(EventStore::class);

$pdo = $container->get('pdo.connection');

$readModel = new TodoReminderReadModel($container->get('doctrine.connection.default'));

if ($eventStore instanceof MySQLEventStore) {
    $projection = new MySQLEventStoreReadModelProjection(
        $eventStore,
        $pdo,
        'todo_reminder',
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
        'todo_reminder',
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
        ReminderWasAddedToTodo::class => function ($state, ReminderWasAddedToTodo $event) {
            $this->readModel()->stack('delete', [
                'todo_id' => $event->todoId()->toString(),
            ]);

            $reminder = $event->reminder();

            $this->readModel()->stack('insert', [
                'todo_id' => $event->todoId()->toString(),
                'reminder' => $reminder->toString(),
                'status' => $reminder->status()->toString(),
            ]);
        },
        TodoAssigneeWasReminded::class => function ($state, TodoAssigneeWasReminded $event) {
            $this->readModel()->stack(
                'update',
                [
                    'status' => $event->reminder()->status()->toString(),
                ],
                [
                    'todo_id' => $event->todoId()->toString(),
                ]
            );
        },
    ])
    ->run();
