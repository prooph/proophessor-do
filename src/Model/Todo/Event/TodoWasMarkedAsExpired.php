<?php

namespace Prooph\ProophessorDo\Model\Todo\Event;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;

/**
 * Class TodoWasMarkedAsExpired
 *
 * @package Prooph\ProophessorDo\Model\Todo\Event
 */
final class TodoWasMarkedAsExpired extends AggregateChanged
{
    private $todoId;

    private $oldStatus;

    private $newStatus;

    /**
     * @param TodoId $todoId
     * @param TodoStatus $oldStatus
     * @param TodoStatus $newStatus
     * @return TodoWasMarkedAsExpired
     */
    public static function fromStatus(TodoId $todoId, TodoStatus $oldStatus, TodoStatus $newStatus)
    {
        $event = self::occur($todoId->toString(), [
            'old_status' => $oldStatus->toString(),
            'new_status' => $newStatus->toString()
        ]);

        $event->todoId    = $todoId;
        $event->oldStatus = $oldStatus;
        $event->newStatus = $newStatus;

        return $event;
    }

    /**
     * @return TodoId
     */
    public function todoId()
    {
        if (is_null($this->todoId)) {
            $this->todoId = TodoId::fromString($this->aggregateId());
        }

        return $this->todoId;
    }

    /**
     * @return TodoStatus
     */
    public function oldStatus()
    {
        if (is_null($this->oldStatus)) {
            $this->oldStatus = TodoStatus::fromString($this->payload['old_status']);
        }

        return $this->oldStatus;
    }

    /**
     * @return TodoStatus
     */
    public function newStatus()
    {
        if (is_null($this->newStatus)) {
            $this->newStatus = TodoStatus::fromString($this->payload['new_status']);
        }

        return $this->newStatus;
    }
}
