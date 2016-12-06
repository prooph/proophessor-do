<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prooph\ProophessorDo\Container\ProcessManager;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\ProcessManager\SendTodoDeadlineExpiredMailSubscriber;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use Zend\Mail\Transport\TransportInterface;


/**
 * Class SendTodoDeadlineExpiredMailSubscriberFactory
 *
 * @package Prooph\ProophessorDo\Container\Model\Todo
 * @author Michał Żukowski <michal@durooil.com>
 */
final class SendTodoDeadlineExpiredMailSubscriberFactory
{
    /**
     * @param ContainerInterface $container
     * @return SendTodoDeadlineExpiredMailSubscriber
     */
    public function __invoke(ContainerInterface $container)
    {
        return new SendTodoDeadlineExpiredMailSubscriber(
            $container->get(UserFinder::class),
            $container->get(TodoFinder::class),
            $container->get(TransportInterface::class)
        );
    }
}
