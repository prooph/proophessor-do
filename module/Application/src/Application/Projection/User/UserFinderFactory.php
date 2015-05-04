<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 5/3/15 - 10:52 PM
 */
namespace Application\Projection\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserFinderFactory
 *
 * @package Application\Projection\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserFinderFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UserFinder($serviceLocator->get('doctrine.connection.orm_default'));
    }
}