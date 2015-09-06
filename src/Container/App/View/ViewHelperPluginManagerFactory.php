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
use Prooph\Proophessor\App\View\ViewHelperPluginManager;

/**
 * Class ViewHelperPluginManagerFactory
 *
 * @package Prooph\Proophessor\Container\App\View
 */
final class ViewHelperPluginManagerFactory 
{
    /**
     * @param ContainerInterface $container
     * @return ViewHelperPluginManager
     */
    public function __invoke(ContainerInterface $container)
    {
        return new ViewHelperPluginManager($container);
    }
}
 