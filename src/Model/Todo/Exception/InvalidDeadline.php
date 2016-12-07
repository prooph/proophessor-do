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

namespace Prooph\ProophessorDo\Model\Todo\Exception;

use Prooph\ProophessorDo\Model\User\UserId;
use Prooph\ProophessorDo\Model\Todo\TodoDeadline;

/**
 * Class InvalidDeadline
 *
 * @package Prooph\ProophessorDo\Model\Todo\Exception
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
final class InvalidDeadline extends \Exception
{
    /**
     * @param UserId $user
     * @param UserId $assigneeId
     * @return InvalidDeadline
     */
    public static function userIsNotAssignee(UserId $user, UserId $assigneeId)
    {
        return new self(sprintf(
            'User %s tried to add a deadline to the todo owned by %s',
            $user->toString(),
            $assigneeId->toString()
        ));
    }


    public static function deadlineInThePast(TodoDeadline $deadline)
    {
        return new self(sprintf(
            'Provided deadline %s is in the past from %s',
            $deadline->toString(),
            $deadline->createdOn()
        ));
    }
}
