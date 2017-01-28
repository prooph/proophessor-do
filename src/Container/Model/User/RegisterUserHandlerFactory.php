<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Container\Model\User;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Model\User\Handler\RegisterUserHandler;
use Prooph\ProophessorDo\Model\User\Service\ChecksUniqueUsersEmailAddress;
use Prooph\ProophessorDo\Model\User\UserCollection;

class RegisterUserHandlerFactory
{
    public function __invoke(ContainerInterface $container): RegisterUserHandler
    {
        return new RegisterUserHandler(
            $container->get(UserCollection::class),
            $container->get(ChecksUniqueUsersEmailAddress::class)
        );
    }
}
