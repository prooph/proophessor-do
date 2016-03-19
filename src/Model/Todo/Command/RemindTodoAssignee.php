<?php
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
        return TodoReminder::fromString($this->payload['reminder'], $this->payload['reminder_status']);
    }
}
