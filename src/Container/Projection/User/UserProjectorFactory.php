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

namespace Prooph\ProophessorDo\Container\Projection\User;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use Prooph\ProophessorDo\Projection\User\UserProjector;

class UserProjectorFactory
{
    public function __invoke(ContainerInterface $container): UserProjector
    {
        return new UserProjector(
            $container->get('doctrine.connection.default'),
            $container->get(UserFinder::class)
        );
    }
}
