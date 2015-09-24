<?php

namespace Prooph\ProophessorDo\Container\Model\Todo;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Model\Todo\Handler\AddDeadlineToTodoHandler;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class AddDeadlineToTodoHandlerFactory
 *
 * @package Prooph\ProophessorDo\Container\Model\Todo
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
