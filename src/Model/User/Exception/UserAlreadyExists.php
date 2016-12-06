<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
