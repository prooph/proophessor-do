<?php

namespace Prooph\ProophessorDo\Container\App\Mail;

use Interop\Config\ConfigurationTrait;
use Interop\Config\ProvidesDefaultOptions;
use Interop\Config\RequiresConfig;
use Interop\Config\RequiresMandatoryOptions;
use Interop\Container\ContainerInterface;
use Prooph\ProophessorDo\App\Mail\SendTodoReminderMailSubscriber;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use Zend\Mail\Transport\InMemory as InMemoryTransport;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;


/**
 * Class RemindTodoAssigneeHandlerFactory
 *
 * @package Prooph\ProophessorDo\Container\Model\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class SendTodoReminderMailSubscriberFactory implements RequiresConfig, RequiresMandatoryOptions, ProvidesDefaultOptions
{
    use ConfigurationTrait;

    /**
     * @inheritdoc
     */
    public function vendorName()
    {
        return 'proophessor-do';
    }

    /**
     * @inheritdoc
     */
    public function packageName()
    {
        return 'mail';
    }

    /**
     * @inheritdoc
     */
    public function mandatoryOptions()
    {
        return ['transport'];
    }

    /**
     * @inheritdoc
     */
    public function defaultOptions()
    {
        return ['transport' => 'in_memory'];
    }

    /**
     * @param ContainerInterface $container
     * @return SendTodoReminderMailSubscriber
     */
    public function __invoke(ContainerInterface $container)
    {
        return new SendTodoReminderMailSubscriber(
            $container->get(UserFinder::class),
            $container->get(TodoFinder::class),
            $this->getTransport($container->get('config'))
        );
    }

    /**
     * @param $config
     * @return SmtpTransport
     */
    private function getTransport($config)
    {
        $config = $this->optionsWithFallback($config);

        switch ($config['transport']) {
            case 'in_memory':
                return new InMemoryTransport();

            case 'smtp':
                $transport = new SmtpTransport();
                $transport->setOptions(new SmtpOptions($config['smtp']));

                return $transport;
        }
        throw new \InvalidArgumentException(
            "Transport of type '{$config['transport']}' not known (use in_memory or smtp)"
        );
    }
}
