<?php

namespace Prooph\ProophessorDo\Model\Todo\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\ProophessorDo\Model\Todo\TodoId;

/**
 * Class MarkTodoAsExpired
 *
 * @package Prooph\ProophessorDo\Model\Todo
 */
final class MarkTodoAsExpired extends Command implements PayloadConstructable
{
    use PayloadTrait;

    /**
     *
     * @param string $todoId
     * @return MarkTodoAsExpired
     * @throws \Assert\AssertionFailedException
     */
    public static function forTodo($todoId)
    {
        Assertion::string($todoId);
        Assertion::notEmpty($todoId);

        return new self([
            'todo_id' => $todoId,
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
