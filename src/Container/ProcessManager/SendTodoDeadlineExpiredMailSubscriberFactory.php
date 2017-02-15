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

namespace Prooph\ProophessorDo\Container\ProcessManager;

use Prooph\ProophessorDo\ProcessManager\SendTodoDeadlineExpiredMailProcessManager;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use Psr\Container\ContainerInterface;
use Zend\Mail\Transport\TransportInterface;

class SendTodoDeadlineExpiredMailSubscriberFactory
{
    public function __invoke(ContainerInterface $container): SendTodoDeadlineExpiredMailProcessManager
    {
        return new SendTodoDeadlineExpiredMailProcessManager(
            $container->get(UserFinder::class),
            $container->get(TodoFinder::class),
            $container->get(TransportInterface::class)
        );
    }
}
