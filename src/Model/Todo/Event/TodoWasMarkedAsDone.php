<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/15/15 - 21:20 PM
 */
namespace Prooph\ProophessorDo\Model\Todo\Event;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;

/**
 * Class TodoWasMarkedAsDone
 *
 * @package Prooph\ProophessorDo\Model\Todo\Event
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
final class TodoWasMarkedAsDone extends AggregateChanged
{
    private $todoId;

    private $oldStatus;

    private $newStatus;

    /**
     * @param TodoId $todoId
     * @param TodoStatus $oldStatus
     * @param TodoStatus $newStatus
     * @return TodoWasMarkedAsDone
     */
    public static function fromStatus(TodoId $todoId, TodoStatus $oldStatus, TodoStatus $newStatus)
    {
        $event = self::occur($todoId->toString(), [
            'old_status' => $oldStatus->toString(),
            'new_status' => $newStatus->toString()
        ]);

        $event->todoId = $todoId;
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
