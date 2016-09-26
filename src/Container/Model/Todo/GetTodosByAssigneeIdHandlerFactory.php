<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 8:33 PM
 */
namespace Prooph\ProophessorDo\Container\Model\Todo;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Model\Todo\Handler\GetTodosByAssigneeIdHandler;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;

/**
 * @author Bruno Galeotti <bgaleotti@gmail.com>
 */
final class GetTodosByAssigneeIdHandlerFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return GetTodosByAssigneeIdHandler
     */
    public function __invoke(ContainerInterface $container)
    {
        return new GetTodosByAssigneeIdHandler($container->get(TodoFinder::class));
    }
}
