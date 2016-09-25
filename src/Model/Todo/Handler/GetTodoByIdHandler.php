<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\Todo\Query\GetTodoById;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use React\Promise\Deferred;

/**
 * @author Bruno Galeotti <bgaleotti@gmail.com>
 */
final class GetTodoByIdHandler
{
    private $todoFinder;

    public function __construct(TodoFinder $todoFinder)
    {
        $this->todoFinder = $todoFinder;
    }

    public function __invoke(GetTodoById $query, Deferred $deferred = null)
    {
        $todo = $this->todoFinder->findById($query->todoId());
        if (null === $deferred) {
            return $todo;
        }

        $deferred->resolve($todo);
    }
}
