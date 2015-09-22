<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 11:33 AM
 */
namespace Prooph\ProophessorDo\Container\App\Routing;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\AuraRouter;

/**
 * Class AuraRouterFactory
 *
 * @package Prooph\ProophessorDo\App\Routing
 */
final class AuraRouterFactory
{
    /**
     * @param ContainerInterface $container
     * @return AuraRouter
     */
    public function __invoke(ContainerInterface $container)
    {
        return new AuraRouter();
    }
}
