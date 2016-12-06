<?php

namespace Prooph\ProophessorDo\Model\User\Exception;

use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class UserAlreadyExists
 *
 * @package Prooph\ProophessorDo\Model\User\Exception
 * @author Lucas Courot <lucas@courot.com>
 */
final class UserAlreadyExists extends \InvalidArgumentException
{
    /**
     * @param UserId $userId
     * @return UserAlreadyExists
     */
    public static function withUserId(UserId $userId)
    {
        return new self(sprintf('User with id %s already exists.', $userId->toString()));
    }
}
