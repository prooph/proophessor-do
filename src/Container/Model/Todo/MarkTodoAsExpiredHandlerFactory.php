<?php

namespace Prooph\ProophessorDo\Container\Model\Todo;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Model\Todo\Handler\MarkTodoAsExpiredHandler;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class MarkTodoAsExpiredHandlerFactory
 *
 * @package Prooph\ProophessorDo\Container\Model\Todo
 */
final class MarkTodoAsExpiredHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return MarkTodoAsExpiredHandler
     */
    public function __invoke(ContainerInterface $container)
    {
        $todoList = $container->get(TodoList::class);

        return new MarkTodoAsExpiredHandler($todoList);
    }
}
