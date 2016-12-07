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

namespace Prooph\ProophessorDo\Container\Infrastructure\Repository;

use Prooph\EventStore\Container\Aggregate\AbstractAggregateRepositoryFactory;

/**
 * Class EventStoreUserCollectionFactory
 *
 * @package Application\Infrastructure\Repository\Factory
 */
final class EventStoreUserCollectionFactory extends AbstractAggregateRepositoryFactory
{
    /**
     * Returns the container identifier
     *
     * @return string
     */
    public function containerId()
    {
        return 'user_collection';
    }
}
