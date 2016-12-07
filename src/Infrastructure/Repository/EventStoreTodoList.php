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
