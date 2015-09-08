<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 6:42 PM
 */
namespace Prooph\Proophessor\Model\User\Handler;

use Prooph\Proophessor\Model\User\Command\RegisterUser;
use Prooph\Proophessor\Model\User\User;
use Prooph\Proophessor\Model\User\UserCollection;

/**
 * Class RegisterUserHandler
 *
 * @package Prooph\Proophessor\Model\User\Handler
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class RegisterUserHandler
{
    /**
     * @var UserCollection
     */
    private $userCollection;

    /**
     * @param UserCollection $userCollection
     */
    public function __construct(UserCollection $userCollection)
    {
        $this->userCollection = $userCollection;
    }

    /**
     * @param RegisterUser $command
     */
    public function __invoke(RegisterUser $command)
    {
        $user = User::registerWithData($command->userId(), $command->name(), $command->emailAddress());

        $this->userCollection->add($user);
    }
}
