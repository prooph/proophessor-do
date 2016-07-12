<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/19/15 - 21:32 PM
 */
namespace Prooph\ProophessorDo\Model\Todo\Exception;

use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoDeadline;
use Prooph\ProophessorDo\Model\Todo\TodoReminder;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;

/**
 * Class TodoNotOpen
 *
 * @package Prooph\ProophessorDo\Model\Todo\Exception
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
final class TodoNotOpen extends \RuntimeException
{
    /**
     * @param TodoStatus $status
     * @param Todo $todo
     * @return TodoNotOpen
     */
    public static function triedStatus(TodoStatus $status, Todo $todo)
    {
        return new self(sprintf(
            'Tried to change status of Todo %s to %s. But Todo is not marked as open!',
            $todo->todoId()->toString(),
            $status->toString()
        ));
    }

    /**
     * @param TodoDeadline $deadline
     * @param TodoStatus $status
     * @return TodoNotOpen
     */
    public static function triedToAddDeadline(TodoDeadline $deadline, TodoStatus $status)
    {
        return new self(sprintf(
            'Tried to deadline %s to a todo with status %s.',
            $deadline->toString(),
            $status->toString()
        ));
    }

    /**
     * @param TodoReminder $reminder
     * @param TodoStatus $status
     * @return TodoNotOpen
     */
    public static function triedToAddReminder(TodoReminder $reminder, TodoStatus $status)
    {
        return new self(sprintf(
            'Tried to add reminder %s to a todo with status %s.',
            $reminder->toString(),
            $status->toString()
        ));
    }

    /**
     * @param TodoReminder $reminder
     * @param TodoStatus $status
     * @return TodoNotOpen
     */
    public static function triedToSendReminder(TodoReminder $reminder, TodoStatus $status)
    {
        return new self(sprintf(
            'Tried to send a reminder %s for a todo with status %s.',
            $reminder->toString(),
            $status->toString()
        ));
    }

    /**
     * @param TodoStatus $status
     * @return TodoNotOpen
     */
    public static function triedToExpire(TodoStatus $status, Todo $todo)
    {
        return new self(sprintf('Tried to expire todo with status %s.', $status->toString()));
    }
}
