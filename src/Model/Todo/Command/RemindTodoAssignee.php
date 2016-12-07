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

namespace Prooph\ProophessorDo\Model\Todo\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoReminder;

/**
 * Class RemindTodoAssignee
 *
 * @package Prooph\ProophessorDo\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class RemindTodoAssignee extends Command implements PayloadConstructable
{
    use PayloadTrait;

    /**
     *
     * @param TodoId $todoId
     * @param TodoReminder $todoReminder
     * @return RemindTodoAssignee
     */
    public static function forTodo(TodoId $todoId, TodoReminder $todoReminder)
    {
        return new self([
            'todo_id' => $todoId->toString(),
            'reminder' => $todoReminder->toString(),
            'reminder_status' => $todoReminder->status()->toString()
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
     * @return TodoReminder
     */
    public function reminder()
    {
        return TodoReminder::from($this->payload['reminder'], $this->payload['reminder_status']);
    }
}
