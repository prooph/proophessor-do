<?php

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
