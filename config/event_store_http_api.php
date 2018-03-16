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

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Prooph\EventStore\Http\Middleware\Action;

/**
 * Expressive routed middleware
 */

/** @var \Zend\Expressive\Application $app */

// event store routes
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get(
        '/event-store/stream/{streamname}{/start,direction,count}',
        Action\LoadStream::class,
        'EventStore::load'
    )
        ->setOptions([
            'tokens' => [
                'streamname' => '[^/]+',
                'start' => 'head|[0-9]+',
                'direction' => 'forward|backward',
                'count' => '[0-9]+',
            ],
            'values' => [
                'start' => 1,
                'direction' => 'forward',
                'count' => 10,
            ],
        ]
    );
    $app->post(
        '/event-store/stream/{streamname}',
        [
            \Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware::class,
            Action\PostStream::class,
        ],
        'EventStore::appendTo'
    );

    $app->get(
        '/event-store/streammetadata/{streamname}',
        Action\FetchStreamMetadata::class,
        'EventStore::fetchStreamMetadata'
    );

    $app->post(
        '/event-store/streammetadata/{streamname}',
        [
            \Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware::class,
            Action\UpdateStreamMetadata::class,
        ],
        'EventStore::updateStreamMetadata'
    );

    $app->post(
        '/event-store/delete/{streamname}',
        Action\DeleteStream::class,
        'EventStore::delete'
    );

    $app->get(
        '/event-store/has-stream/{streamname}',
        Action\HasStream::class,
        'EventStore::hasStream'
    );

    $app->get(
        '/event-store/streams{/filter}',
        Action\FetchStreamNames::class,
        'EventStore::fetchStreamNames'
    );

    $app->get(
        '/event-store/streams-regex/{filter}',
        Action\FetchStreamNamesRegex::class,
        'EventStore::fetchStreamNamesRegex'
    );

    $app->get(
        '/event-store/categories{/filter}',
        Action\FetchCategoryNames::class,
        'EventStore::fetchCategoryNames'
    );

    $app->get(
        '/event-store/categories-regex/{filter}',
        Action\FetchCategoryNamesRegex::class,
        'EventStore::fetchCategoryNamesRegex'
    );

    // projection manager routes

    $app->get(
        '/event-store/projections{/filter}',
        Action\FetchProjectionNames::class,
        'ProjectionManager::fetchProjectionNames'
    );

    $app->get(
        '/event-store/projections-regex/{filter}',
        Action\FetchProjectionNamesRegex::class,
        'ProjectionManager::fetchProjectionNamesRegex'
    );

    $app->post(
        '/event-store/projection/delete/{name}/{deleteEmittedEvents}',
        Action\DeleteProjection::class,
        'ProjectionManager::deleteProjection'
    )->setOptions([
        'tokens' => [
            'deleteEmittedEvents' => 'true|false'
        ]
    ]);

    $app->post(
        '/event-store/projection/reset/{name}',
        Action\ResetProjection::class,
        'ProjectionManager::resetProjection'
    );

    $app->post(
        '/event-store/projection/stop/{name}',
        Action\StopProjection::class,
        'ProjectionManager::stopProjection'
    );

    $app->get(
        '/event-store/projection/status/{name}',
        Action\FetchProjectionStatus::class,
        'ProjectionManager::fetchProjectionStatus'
    );

    $app->get(
        '/event-store/projection/state/{name}',
        Action\FetchProjectionState::class,
        'ProjectionManager::fetchProjectionState'
    );

    $app->get(
        '/event-store/projection/stream-positions/{name}',
        Action\FetchProjectionStreamPositions::class,
        'ProjectionManager::fetchProjectionStreamPositions'
    );
};