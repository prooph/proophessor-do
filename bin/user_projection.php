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
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasReopened;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasUnmarkedAsExpired;
use Prooph\ProophessorDo\Model\User\Event\UserWasRegistered;
use Prooph\ProophessorDo\Projection\User\UserReadModel;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$container = require 'config/container.php';

$eventStore = $container->get(EventStore::class);
/* @var EventStore $eventStore */

$readModel = new UserReadModel($container->get('doctrine.connection.default'));

$projection = $eventStore->createReadModelProjection('user', $readModel);

$projection
    ->fromStream('event_stream')
    ->when([
        UserWasRegistered::class => function ($state, UserWasRegistered $event) {
            $this->readModel()->stack('insert', [
                'id' => $event->userId()->toString(),
                'name' => $event->name(),
                'email' => $event->emailAddress()->toString(),
            ]);
        },
        TodoWasPosted::class => function ($state, TodoWasPosted $event) {
            $this->readModel()->stack('postTodo', $event->assigneeId()->toString());
        },
        TodoWasMarkedAsDone::class => function ($state, TodoWasMarkedAsDone $event) {
            $this->readModel()->stack('markTodoAsDone', $event->assigneeId()->toString());
        },
        TodoWasReopened::class => function ($state, TodoWasReopened $event) {
            $this->readModel()->stack('reopenTodo', $event->assigneeId()->toString());
        },
        TodoWasMarkedAsExpired::class => function ($state, TodoWasMarkedAsExpired $event) {
            $this->readModel()->stack('markTodoAsExpired', $event->assigneeId()->toString());
        },
        TodoWasUnmarkedAsExpired::class => function ($state, TodoWasUnmarkedAsExpired $event) {
            $this->readModel()->stack('unmarkTodoAsExpired', $event->assigneeId()->toString());
        },
    ])
    ->run();
