<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prooph\ProophessorDo\Model\Todo\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\ProophessorDo\Model\Todo\TodoId;

final class NotifyUserOfExpiredTodo extends Command implements PayloadConstructable
{
    use PayloadTrait;

    /**
     * @param TodoId $todoId
     * @return NotifyUserOfExpiredTodo
     */
    public static function with(TodoId $todoId)
    {
        return new self([
            'todo_id' => $todoId->toString(),
        ]);
    }

    /**
     * @return TodoId
     */
    public function todoId()
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    /**
     * @param array $payload
     */
    protected function setPayload(array $payload)
    {
        Assertion::keyExists($payload, 'todo_id');
        Assertion::uuid($payload['todo_id']);

        $this->payload = $payload;
    }
}
