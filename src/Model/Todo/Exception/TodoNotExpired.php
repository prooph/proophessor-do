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
