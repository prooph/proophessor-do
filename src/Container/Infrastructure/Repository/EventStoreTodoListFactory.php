<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 5:27 PM
 */
namespace Prooph\ProophessorDo\Container\Infrastructure\Repository;

use Interop\Container\ContainerInterface;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\Aggregate\AggregateType;
use Prooph\ProophessorDo\Infrastructure\Repository\EventStoreTodoList;
use Prooph\ProophessorDo\Model\Todo\Todo;

/**
 * Class EventStoreTodoListFactory
 *
 * @package Application\Infrastructure\Repository\Factory
 */
final class EventStoreTodoListFactory
{
    /**
     * @param ContainerInterface $container
     * @return EventStoreTodoList
     */
    public function __invoke(ContainerInterface $container)
    {
        return new EventStoreTodoList(
            $container->get('prooph.event_store'),
            AggregateType::fromAggregateRootClass(Todo::class),
            new AggregateTranslator()
        );
    }
}
