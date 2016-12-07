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

namespace Prooph\ProophessorDo\Infrastructure\Repository;

use Prooph\EventStore\Aggregate\AggregateRepository;
use Prooph\ProophessorDo\Model\User\User;
use Prooph\ProophessorDo\Model\User\UserCollection;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class EventStoreUserCollection
 *
 * @package Application\Infrastructure\Repository
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class EventStoreUserCollection extends AggregateRepository implements UserCollection
{
    /**
     * @param User $user
     * @return void
     */
    public function add(User $user)
    {
        $this->addAggregateRoot($user);
    }

    /**
     * @param UserId $userId
     * @return User
     */
    public function get(UserId $userId)
    {
        return $this->getAggregateRoot($userId->toString());
    }
}
