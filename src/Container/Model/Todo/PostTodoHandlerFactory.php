<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
