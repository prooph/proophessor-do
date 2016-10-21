<?php

namespace Prooph\ProophessorDo\Container\Model\User;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\Infrastructure\Service\ChecksUniqueUsersEmailAddressFromReadModel;
use Prooph\ProophessorDo\Projection\User\UserFinder;

/**
 * Class ChecksUniqueUsersEmailAddressFactory
 *
 * @author Lucas Courot <lucas@courot.com>
 */
final class ChecksUniqueUsersEmailAddressFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return ChecksUniqueUsersEmailAddressFromReadModel
     */
    public function __invoke(ContainerInterface $container)
    {
        return new ChecksUniqueUsersEmailAddressFromReadModel(
            $container->get(UserFinder::class)
        );
    }
}
