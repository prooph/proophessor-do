<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/15/15 - 20:30 PM
 */
namespace Prooph\ProophessorDo\Container\Model\Todo;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Model\Todo\Handler\MarkTodoAsDoneHandler;
use Prooph\ProophessorDo\Model\Todo\TodoList;

/**
 * Class PostTodoHandlerFactory
 *
 * @package Application\Infrastructure\HandlerFactory
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
final class MarkTodoAsDoneHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return MarkTodoAsDoneHandler
     */
    public function __invoke(ContainerInterface $container)
    {
        return new MarkTodoAsDoneHandler(
            $container->get(TodoList::class)
        );
    }
}
