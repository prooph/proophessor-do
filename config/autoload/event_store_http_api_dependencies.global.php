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

namespace Prooph\ProophessorDo;

use Prooph\Common\Messaging\MessageConverter;
use Prooph\Common\Messaging\NoOpMessageConverter;
use Prooph\EventStore\Http\Middleware\Action;
use Prooph\EventStore\Http\Middleware\Container\Action as Factory;
use Prooph\EventStore\Http\Middleware\ResponsePrototype;
use Prooph\EventStore\Http\Middleware\Transformer;
use Prooph\EventStore\Http\Middleware\UrlHelper;
use Prooph\ProophessorDo\Container\Infrastructure\UrlHelperFactory;
use Prooph\ProophessorDo\Infrastructure\EventStoreHttpApi\JsonTransformer;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'dependencies' => [
        'aliases' => [
            //Default Transformer
            Transformer::class => JsonTransformer::class,
            //Response Prototype
            ResponsePrototype::class => EmptyResponse::class,
            //Default Message Converter
            MessageConverter::class => NoOpMessageConverter::class,
        ],
        'factories' => [
            //Actions
            Action\LoadStream::class => Factory\LoadStreamFactory::class,
            Action\PostStream::class => Factory\PostStreamFactory::class,
            Action\FetchStreamMetadata::class => Factory\FetchStreamMetadataFactory::class,
            Action\UpdateStreamMetadata::class => Factory\UpdateStreamMetadataFactory::class,
            Action\DeleteStream::class => Factory\DeleteStreamFactory::class,
            Action\HasStream::class => Factory\HasStreamFactory::class,
            Action\FetchStreamNames::class => Factory\FetchStreamNamesFactory::class,
            Action\FetchStreamNamesRegex::class => Factory\FetchStreamNamesRegexFactory::class,
            Action\FetchCategoryNames::class => Factory\FetchCategoryNamesFactory::class,
            Action\FetchCategoryNamesRegex::class => Factory\FetchCategoryNamesRegexFactory::class,
            Action\FetchProjectionNames::class => Factory\FetchProjectionNamesFactory::class,
            Action\FetchProjectionNamesRegex::class => Factory\FetchProjectionNamesRegexFactory::class,
            Action\DeleteProjection::class => Factory\DeleteProjectionFactory::class,
            Action\ResetProjection::class => Factory\ResetProjectionFactory::class,
            Action\StopProjection::class => Factory\StopProjectionFactory::class,
            Action\FetchProjectionStatus::class => Factory\FetchProjectionStatusFactory::class,
            Action\FetchProjectionState::class => Factory\FetchProjectionStateFactory::class,
            Action\FetchProjectionStreamPositions::class => Factory\FetchProjectionStreamPositionsFactory::class,
            //Transformer
            JsonTransformer::class => InvokableFactory::class,
            //Response Prototype
            EmptyResponse::class => InvokableFactory::class,
            //Message Converter
            NoOpMessageConverter::class => InvokableFactory::class,
            //Url Helper
            UrlHelper::class => UrlHelperFactory::class,
        ],
    ],
];
