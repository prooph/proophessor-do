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
