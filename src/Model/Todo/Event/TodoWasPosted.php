<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 5:02 PM
 */
namespace Prooph\ProophessorDo\Model\Todo\Event;

use Prooph\ProophessorDo\Model\User\UserId;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;

/**
 * Class TodoWasPosted
 *
 * @package Prooph\ProophessorDo\Model\Todo\Event
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoWasPosted extends AggregateChanged
{
    private $assigneeId;

    private $todoId;

    private $todoStatus;

    /**
     * @param UserId $assigneeId
     * @param string $text
     * @param TodoId $todoId
     * @param TodoStatus $todoStatus
     * @return TodoWasPosted
     */
    public static function byUser(UserId $assigneeId, $text, TodoId $todoId, TodoStatus $todoStatus)
    {
        $event = self::occur($todoId->toString(), [
            'assignee_id' => $assigneeId->toString(),
            'text' => $text,
            'status' => $todoStatus->toString()
        ]);

        $event->todoId = $todoId;
        $event->assigneeId = $assigneeId;
        $event->todoStatus = $todoStatus;

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
     * @return UserId
     */
    public function assigneeId()
    {
        if (is_null($this->assigneeId)) {
            $this->assigneeId = UserId::fromString($this->payload['assignee_id']);
        }
        return $this->assigneeId;
    }

    /**
     * @return string
     */
    public function text()
    {
        return $this->payload['text'];
    }

    /**
     * @return TodoStatus
     */
    public function todoStatus()
    {
        if (is_null($this->todoStatus)) {
            $this->todoStatus = TodoStatus::fromString($this->payload['status']);
        }
        return $this->todoStatus;
    }
}
