<?php

namespace Prooph\ProophessorDo\Container\App\Mail;

use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\App\Mail\SendTodoReminderMailSubscriber;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use Zend\Mail\Transport\TransportInterface;

/**
 * Class RemindTodoAssigneeHandlerFactory
 *
 * @package Prooph\ProophessorDo\Container\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class SendTodoReminderMailSubscriberFactory
{
    /**
     * @param ContainerInterface $container
     * @return SendTodoReminderMailSubscriber
     */
    public function __invoke(ContainerInterface $container)
    {
        return new SendTodoReminderMailSubscriber(
            $container->get(UserFinder::class),
            $container->get(TodoFinder::class),
            $container->get(TransportInterface::class)
        );
    }
}
