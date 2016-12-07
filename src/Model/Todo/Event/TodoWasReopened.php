<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Model\Todo\Event;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;

final class TodoWasReopened extends AggregateChanged
{
    /**
     * @var TodoId
     */
    private $todoId;

    /**
     * @var TodoStatus
     */
    private $status;

    public static function withStatus(TodoId $todoId, TodoStatus $status): TodoWasReopened
    {
        $event = self::occur($todoId->toString(), [
            'status' => $status->toString()
        ]);

        $event->todoId = $todoId;
        $event->status = $status;

        return $event;
    }

    public function todoId(): TodoId
    {
        if (null === $this->todoId) {
            $this->todoId = TodoId::fromString($this->aggregateId());
        }
        return $this->todoId;
    }

    public function status(): TodoStatus
    {
        if (null === $this->status) {
            $this->status = TodoStatus::getByName($this->payload['status']);
        }
        return $this->status;
    }
}
