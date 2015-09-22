<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 6:39 PM
 */
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
