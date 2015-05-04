<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 5/3/15 - 11:27 PM
 */
namespace Application\Controller\Factory;
use Application\Controller\UserRegistrationController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserRegistrationControllerFactory
 *
 * @package Application\Controller\Factory
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserRegistrationControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerLoader
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $controllerLoader)
    {
        return new UserRegistrationController($controllerLoader->getServiceLocator()->get('proophessor.command_bus'));
    }
}