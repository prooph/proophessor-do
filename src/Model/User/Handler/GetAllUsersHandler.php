<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Model\User\Handler;

use Prooph\ProophessorDo\Model\User\Query\GetAllUsers;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use React\Promise\Deferred;

/**
 * @author Bruno Galeotti <bgaleotti@gmail.com>
 */
final class GetAllUsersHandler
{
    private $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function __invoke(GetAllUsers $query, Deferred $deferred = null)
    {
        $user = $this->userFinder->findAll();
        if (null === $deferred) {
            return $user;
        }

        $deferred->resolve($user);
    }
}
