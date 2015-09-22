<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 6:10 PM
 */
namespace Prooph\ProophessorDo\Container\Model\Todo;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Model\Todo\Handler\PostTodoHandler;
use Prooph\ProophessorDo\Model\Todo\TodoList;
use Prooph\ProophessorDo\Model\User\UserCollection;

/**
 * Class PostTodoHandlerFactory
 *
 * @package Application\Infrastructure\HandlerFactory
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class PostTodoHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return PostTodoHandler
     */
    public function __invoke(ContainerInterface $container)
    {
        return new PostTodoHandler(
            $container->get(UserCollection::class),
            $container->get(TodoList::class)
        );
    }
}
