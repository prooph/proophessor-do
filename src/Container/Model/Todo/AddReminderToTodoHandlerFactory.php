<?php

namespace Prooph\ProophessorDo\Container\Model\Todo;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Model\Todo\Handler\AddReminderToTodoHandler;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class AddReminderToTodoHandlerFactory
 *
 * @package Prooph\ProophessorDo\Container\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
class AddReminderToTodoHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return AddReminderToTodoHandler
     */
    public function __invoke(ContainerInterface $container)
    {
        return new AddReminderToTodoHandler($container->get(TodoList::class));
    }
}
