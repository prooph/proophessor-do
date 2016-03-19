<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/15/15 - 8:47 PM
 */
namespace ProophTest\ProophessorDo;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\Aggregate\AggregateType;

/**
 * Class TestCase
 *
 * @package ProophTest\ProophessorDo\tests
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AggregateTranslator
     */
    private $aggregateTranslator;

    /**
     * @param AggregateRoot $aggregateRoot
     * @return AggregateChanged[]
     */
    protected function popRecordedEvent(AggregateRoot $aggregateRoot)
    {
        return $this->getAggregateTranslator()->extractPendingStreamEvents($aggregateRoot);
    }

    /**
     * @param string $aggregateRootClass
     * @param array $events
     * @return object
     */
    protected function reconstituteAggregateFromHistory($aggregateRootClass, array $events)
    {
        return $this->getAggregateTranslator()->reconstituteAggregateFromHistory(
            AggregateType::fromAggregateRootClass($aggregateRootClass),
            new \ArrayIterator($events)
        );
    }

    /**
     * @return AggregateTranslator
     */
    private function getAggregateTranslator()
    {
        if (null === $this->aggregateTranslator) {
            $this->aggregateTranslator = new AggregateTranslator();
        }

        return $this->aggregateTranslator;
    }
}
