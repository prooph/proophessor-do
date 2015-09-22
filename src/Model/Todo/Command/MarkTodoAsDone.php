<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/15/15 - 21:10 PM
 */
namespace Prooph\ProophessorDo\Model\Todo\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\ProophessorDo\Model\Todo\TodoId;

/**
 * Class MarkTodoAsDone
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
final class MarkTodoAsDone extends Command implements PayloadConstructable
{
    use PayloadTrait;
    /**
     *
     * @param type $todoId
     * @return MarkTodoAsDone
     */
    public static function forTodo($todoId)
    {
        return new self([
            'todo_id' => (string)$todoId,
        ]);
    }

    /**
     * @return TodoId
     */
    public function todoId()
    {
        return TodoId::fromString($this->payload['todo_id']);
    }
}
