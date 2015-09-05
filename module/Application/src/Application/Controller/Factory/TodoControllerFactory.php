<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 4:09 PM
 */
namespace Application\Controller\Factory;

use Application\Controller\TodoController;
use Application\Projection\User\UserFinder;
use Prooph\ServiceBus\CommandBus;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class TodoControllerFactory
 *
 * @package Application\Controller\Factory
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerLoader
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $controllerLoader)
    {
        return new TodoController(
            $controllerLoader->getServiceLocator()->get(CommandBus::class),
            $controllerLoader->getServiceLocator()->get(UserFinder::class)
        );
    }
}
