<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);
/**
 * Replay all events to regenerate the read model
 */
namespace {
    use Doctrine\DBAL\Connection;
    use Prooph\EventStore\Projection\ProjectionManager;
    use Prooph\ProophessorDo\Projection\Table;
    use Symfony\Component\Stopwatch\Stopwatch;
    chdir(dirname(__DIR__));
    // Setup autoloading
    require __DIR__ . '/../vendor/autoload.php';
    // Retrieve the container
    $container = require __DIR__ . '/../config/container.php';
    /** @var $dbalConnection Connection */
    $dbalConnection = $container->get('doctrine.connection.default');
    //Make sure that the read model tables are empty
    $dbalConnection->exec('TRUNCATE TABLE ' . Table::USER);
    $dbalConnection->exec('TRUNCATE TABLE ' . Table::TODO);
    $dbalConnection->exec('TRUNCATE TABLE ' . Table::TODO_REMINDER);

    $stopWatch = new Stopwatch();
    $stopWatch->start('replay');

    /** @var ProjectionManager $projectionManager */
    $projectionManager = $container->get(ProjectionManager::class);
    $projectionManager->resetProjection('user');
    $projectionManager->resetProjection('todo');
    $projectionManager->resetProjection('todo_reminder');

    $replayWatchEvent = $stopWatch->stop('replay');
    echo 'Replay done in ' . $replayWatchEvent->getDuration() . ' ms';
}
