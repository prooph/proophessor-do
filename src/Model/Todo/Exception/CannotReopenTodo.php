<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Model\Todo\Exception;

use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;

/**
 * Class CannotReopenTodo
 *
 * @package Prooph\ProophessorDo\Model\Todo\Exception
 * @author Bas Kamer <bas@bushbaby.nl>
 */
final class CannotReopenTodo extends \RuntimeException
{
    /**
     * @param TodoStatus $status
     * @param Todo $todo
     * @return CannotReopenTodo
     */
    public static function notMarkedDone(Todo $todo)
    {
        return new self(sprintf(
            'Tried to reopen status of Todo %s. But Todo is not marked as done!',
            $todo->todoId()->toString()
        ));
    }
}
