<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 11:45 AM
 */
namespace Prooph\ProophessorDo\Container\App\Action;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\App\Action\Home;
use Zend\Expressive\Template\TemplateInterface;

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
        return new Home($container->get(TemplateInterface::class));
    }
}
