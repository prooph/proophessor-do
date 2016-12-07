<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\Container\App\Action;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\App\Action\Home;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class HomeFactory
 *
 * @package Prooph\ProophessorDo\Container\App\Action
 */
final class HomeFactory
{
    /**
     * @param ContainerInterface $container
     * @return Home
     */
    public function __invoke(ContainerInterface $container)
    {
        return new Home($container->get(TemplateRendererInterface::class));
    }
}
