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
use Prooph\ProophessorDo\Model\Todo\TodoStatus;

/**
 * Class TodoNotDone
 *
 * @package Prooph\ProophessorDo\Model\Todo\Exception
 * @author Bas Kamer <bas@bushbaby.nl>
 */
final class TodoNotDone extends \RuntimeException
{
    /**
     * @param TodoStatus $status
     * @param Todo $todo
     * @return TodoNotDone
     */
    public static function triedToReopen(Todo $todo)
    {
        return new self(sprintf(
            'Tried to reopen status of Todo %s. But Todo is not marked as done!',
            $todo->todoId()->toString()
        ));
    }

}
