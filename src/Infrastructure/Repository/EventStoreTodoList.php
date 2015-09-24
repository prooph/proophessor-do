<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 5:27 PM
 */
namespace Prooph\ProophessorDo\Infrastructure\Repository;

use Prooph\EventStore\Aggregate\AggregateRepository;
use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class EventStoreTodoListRepository
 *
 * @package Application\Infrastructure\Repository
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class EventStoreTodoList extends AggregateRepository implements TodoList
{
    /**
     * @param Todo $todo
     * @return void
     */
    public function add(Todo $todo)
    {
        $this->addAggregateRoot($todo);
    }

    /**
     * @param TodoId $todoId
     * @return Todo
     */
    public function get(TodoId $todoId)
    {
        return $this->getAggregateRoot($todoId->toString());
    }
}
