<?php

namespace Prooph\ProophessorDo\Model\Todo\Exception;

use Prooph\ProophessorDo\Model\Todo\TodoReminder;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class InvalidReminder
 *
 * @package Prooph\ProophessorDo\Model\Todo\Exception
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class InvalidReminder extends \Exception
{
    /**
     * @param UserId $user
     * @param UserId $assigneeId
     * @return InvalidReminder
     */
    public static function userIsNotAssignee(UserId $user, UserId $assigneeId)
    {
        return new self(sprintf(
            'User %s tried to add a reminder to the todo owned by %s',
            $user->toString(),
            $assigneeId->toString()
        ));
    }


    /**
     * @param TodoReminder $reminder
     * @return InvalidReminder
     */
    public static function reminderInThePast(TodoReminder $reminder)
    {
        return new self(sprintf(
            'Provided reminder %s is in the past',
            $reminder->toString()
        ));
    }

    /**
     * @param TodoReminder $reminder
     * @return InvalidReminder
     */
    public static function reminderInTheFuture(TodoReminder $reminder)
    {
        return new self(sprintf(
            'Provided reminder %s is in the future',
            $reminder->toString()
        ));
    }

    /**
     * @return InvalidReminder
     */
    public static function alreadyReminded()
    {
        return new self('The assignee was already reminded.');
    }

    /**
     * @param TodoReminder $expected
     * @param TodoReminder $actual
     * @return InvalidReminder
     */
    public static function reminderNotCurrent(TodoReminder $expected, TodoReminder $actual)
    {
        return new self(sprintf(
            'Notification for reminder %s can not be send, because %s is the current one.',
            $actual->toString(),
            $expected->toString()
        ));
    }
}
