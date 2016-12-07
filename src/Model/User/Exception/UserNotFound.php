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
 * Class UserNotFound
 *
 * @package Prooph\ProophessorDo\Model\User\Exception
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
