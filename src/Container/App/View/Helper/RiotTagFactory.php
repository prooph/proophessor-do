<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 1:42 PM
 */
namespace Prooph\Proophessor\Container\App\View\Helper;

use Interop\Container\ContainerInterface;
use Prooph\Proophessor\App\View\Helper\RiotTag;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class RiotTagFactory
 *
 * @package Prooph\Proophessor\Container\App\View\Helper
 */
final class RiotTagFactory
{
    /**
     * @param ContainerInterface $container
     * @return RiotTag
     */
    public function __invoke(ContainerInterface $container)
    {
        $riotTag = new RiotTag();
        $riotTag->setView($container->get(PhpRenderer::class));
        return $riotTag;
    }
}
