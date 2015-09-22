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
namespace Prooph\ProophessorDo\Container\App\View;

use Interop\Container\ContainerInterface;
use Zend\View\HelperPluginManager;

/**
 * Class ViewHelperPluginManagerFactory
 *
 * @package Prooph\ProophessorDo\Container\App\View
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

        $config = $container->has('config')? $container->get('config') : [];

        if (isset($config['templates']['plugins'])) {
            foreach ($config['templates']['plugins'] as $pluginName => $serviceName) {
                $helperPluginManager->setFactory($pluginName, function () use ($container, $serviceName) {
                    return $container->get($serviceName);
                });
            }
        }

        return $helperPluginManager;
    }
}
