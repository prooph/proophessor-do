<?php

namespace Prooph\ProophessorDo\Model\Todo\Command;

use Prooph\Common\Messaging;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class AddDeadlineToTodo
 *
 * @package Prooph\ProophessorDo\Model\Todo\Command
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
class AddDeadlineToTodo extends Messaging\Command implements Messaging\PayloadConstructable
{
    use Messaging\PayloadTrait;

    /**
     * @return UserId
     */
    public function userId()
    {
        return UserId::fromString($this->payload['user_id']);
    }

    /**
     * @return TodoId
     */
    public function todoId()
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    /**
     * @return \DateTimeImmutable
     */
    public function deadline()
    {
        return new \DateTimeImmutable($this->payload['deadline']);
    }
}
