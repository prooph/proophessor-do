<?php

namespace Prooph\Proophessor\Model\Todo\Event;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\Proophessor\Model\Todo\TodoId;
use Prooph\Proophessor\Model\User\UserId;

/**
 * Class DeadlineWasAddedToTodo
 * @package Prooph\Proophessor\Model\Todo\Event
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
class DeadlineWasAddedToTodo extends AggregateChanged
{
    /**
     * @var TodoId
     */
    private $todoId;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var \DateTime
     */
    private $deadline;

    /**
     * @param TodoId $todoId
     * @param UserId $userId
     * @param \DateTime $deadline
     * @return DeadlineWasAddedToTodo
     */
    public static function byUserToDate(TodoId $todoId, UserId $userId, \DateTime $deadline)
    {
        $event = self::occur($todoId->toString(), [
            'todo_id' => $todoId->toString(),
            'user_id' => $userId->toString(),
            'deadline' => $deadline->format('c')
        ]);

        $event->todoId = $todoId;
        $event->userId = $userId;
        $event->deadline = $deadline;

        return $event;
    }

    /**
     * @return UserId
     */
    public function todoId()
    {
        if (!$this->todoId) {
            $this->todoId = TodoId::fromString($this->payload['todo_id']);
        }

        return $this->todoId;
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        if (!$this->userId) {
            $this->userId = UserId::fromString($this->payload['user_id']);
        }

        return $this->userId;
    }

    /**
     * @return \DateTime
     */
    public function deadline()
    {
        if (!$this->deadline) {
            $this->deadline = new \DateTime($this->payload['deadline']);
        }

        return $this->deadline;
    }
}
