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
namespace Prooph\Proophessor\Model\Todo\Exception;

use Prooph\Proophessor\Model\Todo\Todo;
use Prooph\Proophessor\Model\Todo\TodoStatus;

/**
 * Class TodoNotOpen
 *
 * @package Prooph\Proophessor\Model\Todo\Exception
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
}
