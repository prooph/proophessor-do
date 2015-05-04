<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 5/3/15 - 10:53 PM
 */
namespace Application\Controller\Factory;

use Application\Controller\UserViewController;
use Application\Projection\Todo\TodoFinder;
use Application\Projection\User\UserFinder;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserViewControllerFactory
 *
 * @package Application\Controller\Factory
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserViewControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerLoader
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $controllerLoader)
    {
        return new UserViewController(
            $controllerLoader->getServiceLocator()->get(UserFinder::class),
            $controllerLoader->getServiceLocator()->get(TodoFinder::class)
        );
    }
}