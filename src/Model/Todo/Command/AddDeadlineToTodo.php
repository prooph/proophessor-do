<?php

namespace Prooph\Proophessor\Model\Todo\Command;

use Prooph\Common\Messaging;

/**
 * Class AddDeadlineToTodo
 *
 * @package Prooph\Proophessor\Model\Todo\Command
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
class AddDeadlineToTodo extends Messaging\Command implements Messaging\PayloadConstructable
{
    use Messaging\PayloadTrait;

    /**
     * @return string
     */
    public function userId()
    {
        return $this->payload['user_id'];
    }

    /**
     * @return string
     */
    public function todoId()
    {
        return $this->payload['todo_id'];
    }

    /**
     * @return string
     */
    public function deadline()
    {
        return $this->payload['deadline'];
    }
}
