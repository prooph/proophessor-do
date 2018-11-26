<?php

/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);
/**
 * Replay all events to regenerate the read model
 */

namespace Prooph\ProophessorDo;

use Prooph\EventStore\Projection\ProjectionManager;

\chdir(\dirname(__DIR__));
// Setup autoloading
require __DIR__ . '/../vendor/autoload.php';
// Retrieve the container
$container = require __DIR__ . '/../config/container.php';

/** @var ProjectionManager $projectionManager */
$projectionManager = $container->get(ProjectionManager::class);

// Reset projections
$projectionManager->resetProjection('user');
$projectionManager->resetProjection('todo');
$projectionManager->resetProjection('todo_reminder');

echo 'Replay done';
