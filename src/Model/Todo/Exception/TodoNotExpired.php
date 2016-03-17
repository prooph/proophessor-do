<?php

namespace Prooph\ProophessorDo\Model\Todo\Exception;

use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoDeadline;

/**
 * Class TodoNotExpired
 *
 * @package Prooph\ProophessorDo\Model\Todo\Exception
 */
final class TodoNotExpired extends \RuntimeException
{
    /**
     * @param TodoStatus $status
     * @param Todo       $todo
     * @return TodoNotExpired
     */
    public static function withDeadline(TodoDeadline $deadline, Todo $todo)
    {
        return new self(sprintf(
            'Tried to mark a non-expired Todo as expired.  Todo will expire after the deadline %s.',
            $deadline->toString()
        ));
    }
}
