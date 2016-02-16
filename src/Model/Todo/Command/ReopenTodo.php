<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 2/16/16
 */
namespace Prooph\ProophessorDo\Model\Todo\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\ProophessorDo\Model\Todo\TodoId;

/**
 * Class ReopenTodo
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author  Bas Kamer <bas@bushbaby.nl>
 */
final class ReopenTodo extends Command implements PayloadConstructable
{
    use PayloadTrait;

    /**
     *
     * @param TodoId $todoId
     * @return ReopenTodo
     */
    public static function forTodo($todoId)
    {
        return new self([
            'todo_id' => (string) $todoId,
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
