<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Model\Todo\Handler;

use Prooph\ProophessorDo\Model\Todo\Query\GetTodosByAssigneeId;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use React\Promise\Deferred;

/**
 * @author Bruno Galeotti <bgaleotti@gmail.com>
 */
final class GetTodosByAssigneeIdHandler
{
    private $todoFinder;

    public function __construct(TodoFinder $todoFinder)
    {
        $this->todoFinder = $todoFinder;
    }

    public function __invoke(GetTodosByAssigneeId $query, Deferred $deferred = null)
    {
        $todos = $this->todoFinder->findByAssigneeId($query->userId());
        if (null === $deferred) {
            return $todos;
        }

        $deferred->resolve($todos);
    }
}
