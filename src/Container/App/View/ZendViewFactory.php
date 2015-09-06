<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 9/6/15 - 12:19 PM
 */
namespace Prooph\Proophessor\Container\App\View;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\ZendView;
use Zend\View\Renderer\PhpRenderer;


/**
 * Class ZendViewFactory
 *
 * @package Prooph\Proophessor\Container\App\View
 */
final class ZendViewFactory 
{
    /**
     * @param ContainerInterface $container
     * @return ZendView
     */
    public function __invoke(ContainerInterface $container)
    {
        return new ZendView($container->get(PhpRenderer::class), 'app::layout');
    }
}
 