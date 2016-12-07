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
