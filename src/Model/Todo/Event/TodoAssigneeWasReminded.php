<?php

namespace Prooph\ProophessorDo\Model\Todo\Event;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoReminder;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class TodoAssigneeWasReminded
 *
 * @package Prooph\ProophessorDo\Model\Todo\Event
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class TodoAssigneeWasReminded extends AggregateChanged
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
     * @var TodoReminder
     */
    private $reminder;

    /**
     * @param TodoId $todoId
     * @param UserId $userId
     * @param TodoReminder $reminder
     * @return TodoAssigneeWasReminded
     */
    public static function forAssignee(TodoId $todoId, UserId $userId, TodoReminder $reminder)
    {
        $event = self::occur($todoId->toString(), [
            'user_id' => $userId->toString(),
            'reminder' => $reminder->toString(),
            'reminder_status' => $reminder->status()->toString()
        ]);

        $event->userId = $userId;
        $event->reminder = $reminder;

        return $event;
    }

    /**
     * @return TodoId
     */
    public function todoId()
    {
        if (!$this->todoId) {
            $this->todoId = TodoId::fromString($this->aggregateId());
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
     * @return TodoReminder
     */
    public function reminder()
    {
        if (!$this->reminder) {
            $this->reminder = TodoReminder::fromString($this->payload['reminder'], $this->payload['reminder_status']);
        }

        return $this->reminder;
    }
}
