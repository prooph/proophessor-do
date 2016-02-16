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
 * Class TodoWasReopened
 *
 * @package Prooph\ProophessorDo\Model\Todo\Event
 * @author Bas Kamer <bas@bushbaby.nl>
 */
final class TodoWasReopened extends AggregateChanged
{
    private $todoId;

    private $status;

    /**
     * @param TodoId $todoId
     * @param TodoStatus $status
     * @return TodoWasMarkedAsDone
     */
    public static function withStatus(TodoId $todoId, TodoStatus $status)
    {
        $event = self::occur($todoId->toString(), [
            'status' => $status->toString()
        ]);

        $event->todoId = $todoId;
        $event->status = $status;

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
    public function status()
    {
        if (is_null($this->status)) {
            $this->status = TodoStatus::fromString($this->payload['status']);
        }
        return $this->status;
    }

}
