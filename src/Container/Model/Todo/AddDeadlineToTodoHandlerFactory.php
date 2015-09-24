<?php

namespace Prooph\Proophessor\Container\Model\Todo;

use Interop\Container\ContainerInterface;
use Prooph\Proophessor\Model\Todo\Handler\AddDeadlineToTodoHandler;
use Prooph\Proophessor\Model\Todo\TodoList;

/**
 * Class AddDeadlineToTodoHandlerFactory
 *
 * @package Prooph\Proophessor\Container\Model\Todo
 * @author Wojtek Gancarczyk <wojtek@aferalabs.com>
 */
class AddDeadlineToTodoHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return AddDeadlineToTodoHandler
     */
    public function __invoke(ContainerInterface $container)
    {
        return new AddDeadlineToTodoHandler($container->get(TodoList::class));
    }
}
