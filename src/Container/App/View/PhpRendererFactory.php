<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 3:13 PM
 */
namespace Prooph\Proophessor\Container\App\View;

use Interop\Container\ContainerInterface;
use Prooph\Proophessor\App\View\ViewHelperPluginManager;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

/**
 * Class PhpRendererFactory
 *
 * @package Prooph\Proophessor\Container\App\View
 */
final class PhpRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @return PhpRenderer
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        $viewHelperPluginManager = $container->get(ViewHelperPluginManager::class);

        // Create the engine instance:
        $renderer = new PhpRenderer();

        // Configure it:
        $resolver = new Resolver\AggregateResolver();

        $resolver->attach(
            new Resolver\TemplateMapResolver($config['templates']),
            100
        );

        $renderer->setResolver($resolver);

        $renderer->setHelperPluginManager($viewHelperPluginManager);

        return $renderer;
    }
}
