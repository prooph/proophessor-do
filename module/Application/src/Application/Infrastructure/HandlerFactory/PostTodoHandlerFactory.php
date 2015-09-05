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
namespace Application\Infrastructure\HandlerFactory;

use Application\Model\Todo\PostTodoHandler;
use Application\Model\Todo\TodoList;
use Application\Model\User\UserCollection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class PostTodoHandlerFactory
 *
 * @package Application\Infrastructure\HandlerFactory
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class PostTodoHandlerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PostTodoHandler(
            $serviceLocator->get(UserCollection::class),
            $serviceLocator->get(TodoList::class)
        );
    }
}
