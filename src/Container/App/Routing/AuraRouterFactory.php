<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
