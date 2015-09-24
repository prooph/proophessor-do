<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 4:52 PM
 */
namespace Prooph\ProophessorDo\Model\User\Exception;

use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class UserNotFound
 *
 * @package Prooph\ProophessorDo\Model\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserNotFound extends \InvalidArgumentException
{
    /**
     * @param UserId $userId
     * @return UserNotFound
     */
    public static function withUserId(UserId $userId)
    {
        return new self(sprintf('User with id %s cannot be found.', $userId->toString()));
    }
}
