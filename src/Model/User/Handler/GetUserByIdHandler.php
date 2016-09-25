<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Model\User\Handler;

use Prooph\ProophessorDo\Model\User\Query\GetUserById;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use React\Promise\Deferred;

/**
 * @author Bruno Galeotti <bgaleotti@gmail.com>
 */
final class GetUserByIdHandler
{
    private $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function __invoke(GetUserById $query, Deferred $deferred = null)
    {
        $user = $this->userFinder->findById($query->userId());
        if (null === $deferred) {
            return $user;
        }

        $deferred->resolve($user);
    }
}
