<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 12:49 PM
 */
namespace Prooph\Proophessor\Container\App\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;

/**
 * Class ViewHelperPluginManagerFactory
 *
 * @package Prooph\Proophessor\Container\App\View
 */
final class ViewHelperPluginManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @throws \RuntimeException
     * @return HelperPluginManager
     */
    public function __invoke(ContainerInterface $container)
    {
        $helperPluginManager = new HelperPluginManager();

        $helperPluginManager->setRetrieveFromPeeringManagerFirst();

        if (! $container instanceof ServiceManager) {
            throw new \RuntimeException(__CLASS__ . ' can only be used when Zend\ServiceManager\ServiceManager is used as container');
        }

        $helperPluginManager->addPeeringServiceManager($container);

        return $helperPluginManager;
    }
}
