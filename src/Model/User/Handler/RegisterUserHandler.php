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
namespace Prooph\ProophessorDo\Model\User\Handler;

use Prooph\ProophessorDo\Model\User\Command\RegisterUser;
use Prooph\ProophessorDo\Model\User\Service\ChecksUniqueUsersEmailAddress;
use Prooph\ProophessorDo\Model\User\User;
use Prooph\ProophessorDo\Model\User\UserCollection;

/**
 * Class RegisterUserHandler
 *
 * @package Prooph\ProophessorDo\Model\User\Handler
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class RegisterUserHandler
{
    /**
     * @var UserCollection
     */
    private $userCollection;

    /**
     * @var ChecksUniqueUsersEmailAddress
     */
    private $checksUniqueUsersEmailAddress;

    /**
     * @param UserCollection $userCollection
     * @param ChecksUniqueUsersEmailAddress $checksUniqueUsersEmailAddress
     */
    public function __construct(
        UserCollection $userCollection,
        ChecksUniqueUsersEmailAddress $checksUniqueUsersEmailAddress
    )
    {
        $this->userCollection = $userCollection;
        $this->checksUniqueUsersEmailAddress = $checksUniqueUsersEmailAddress;
    }

    /**
     * @param RegisterUser $command
     */
    public function __invoke(RegisterUser $command)
    {
        $user = User::registerWithData(
            $command->userId(),
            $command->name(),
            $command->emailAddress(),
            $this->checksUniqueUsersEmailAddress
        );

        $this->userCollection->add($user);
    }
}
