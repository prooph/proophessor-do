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

use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventSourcing\Snapshot\SnapshotStore;
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
use Prooph\ProophessorDo\Model\User\UserCollection;
use Prooph\ProophessorDo\Projection\User\UserReadModel;
use Prooph\Snapshotter\SnapshotReadModel;
use Prooph\Snapshotter\StreamSnapshotProjection;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$container = require 'config/container.php';

$eventStore = $container->get(EventStore::class);

$pdo = $container->get('pdo.connection');

$readModel = new SnapshotReadModel(
    $container->get(UserCollection::class),
    new AggregateTranslator(),
    $container->get(SnapshotStore::class)
);

if ($eventStore instanceof MySQLEventStore) {
    $projection = new StreamSnapshotProjection(
        new MySQLEventStoreReadModelProjection(
            $eventStore,
            $pdo,
            'user_snapshotter',
            $readModel,
            'event_streams',
            'projections',
            2000,
            10,
            100
        ),
        'event_streams'
    );
} elseif ($eventStore instanceof PostgresEventStore) {
    $projection = new StreamSnapshotProjection(
        new PostgresEventStoreReadModelProjection(
            $eventStore,
            $pdo,
            'user',
            $readModel,
            'user_snapshotter',
            'projections',
            2000,
            10,
            100
        ),
        'event_streams'
    );
} else {
    throw new \RuntimeException('Unknown event store implementation used.');
}

$projection();
