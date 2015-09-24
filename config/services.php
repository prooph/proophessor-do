<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/5/15 - 9:39 PM
 */
/**
 * The services configuration is used to set up a Zend\ServiceManager
 * which is used as Inversion of Controller container in our application
 * Please refer to the official documentation:
 * http://framework.zend.com/manual/current/en/modules/zend.service-manager.html
 */
$servicesConfig = [
    'invokables' => [
        \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class => \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class,
        //Custom view plugins
        \Prooph\Proophessor\App\View\Helper\RiotTag::class              => \Prooph\Proophessor\App\View\Helper\RiotTag::class,
    ],
    'factories' => [
        //Application
        \Zend\Expressive\Application::class           => \Zend\Expressive\Container\ApplicationFactory::class,
        \Prooph\Proophessor\App\Commanding\API::class => \Prooph\Proophessor\Container\App\Commanding\APIFactory::class,
        //Infrastructure
        'doctrine.connection.default' => Prooph\Proophessor\Container\Infrastructure\DoctrineDbalConnectionFactory::class,
        'prooph.event_store'          => \Prooph\EventStore\Container\EventStoreFactory::class,
        //Default factories for the event store adapters, depending on the installed adapter the event store factory
        //will use the configured adapter type to get an adapter instance from the service manager
        //to ease system set up we register both factories here so that the user doesn't need to worry about it
        'Prooph\\EventStore\\Adapter\\MongoDb\\MongoDbEventStoreAdapter'   => 'Prooph\\EventStore\\Adapter\\MongoDb\\Container\\MongoDbEventStoreAdapterFactory',
        'Prooph\\EventStore\\Adapter\\Doctrine\\DoctrineEventStoreAdapter' => 'Prooph\\EventStore\\Adapter\\Doctrine\\Container\\DoctrineEventStoreAdapterFactory',
        //prooph/service-bus set up
        \Prooph\ServiceBus\CommandBus::class => \Prooph\ServiceBus\Container\CommandBusFactory::class,
        \Prooph\ServiceBus\EventBus::class   => \Prooph\ServiceBus\Container\EventBusFactory::class,
        //prooph/event-store-bus-bridge set up
        \Prooph\EventStoreBusBridge\TransactionManager::class => \Prooph\EventStoreBusBridge\Container\TransactionManagerFactory::class,
        \Prooph\EventStoreBusBridge\EventPublisher::class     => \Prooph\EventStoreBusBridge\Container\EventPublisherFactory::class,
        //Routing
        \Zend\Expressive\Router\RouterInterface::class => \Prooph\Proophessor\Container\App\Routing\AuraRouterFactory::class,
        //Action middleware
        \Prooph\Proophessor\App\Action\Home::class             => \Prooph\Proophessor\Container\App\Action\HomeFactory::class,
        \Prooph\Proophessor\App\Action\UserList::class         => \Prooph\Proophessor\Container\App\Action\UserListFactory::class,
        \Prooph\Proophessor\App\Action\UserRegistration::class => \Prooph\Proophessor\Container\App\Action\UserRegistrationFactory::class,
        \Prooph\Proophessor\App\Action\UserTodoList::class     => \Prooph\Proophessor\Container\App\Action\UserTodoListFactory::class,
        \Prooph\Proophessor\App\Action\UserTodoForm::class     => \Prooph\Proophessor\Container\App\Action\UserTodoFormFactory::class,
        //View
        \Zend\Expressive\Template\TemplateInterface::class          => \Zend\Expressive\Container\Template\ZendViewFactory::class,
        \Zend\View\HelperPluginManager::class                       => \Prooph\Proophessor\Container\App\View\ViewHelperPluginManagerFactory::class,
        //Model
        \Prooph\Proophessor\Model\User\Handler\RegisterUserHandler::class => \Prooph\Proophessor\Container\Model\User\RegisterUserHandlerFactory::class,
        \Prooph\Proophessor\Model\User\UserCollection::class      => \Prooph\Proophessor\Container\Infrastructure\Repository\EventStoreUserCollectionFactory::class,
        \Prooph\Proophessor\Model\Todo\Handler\PostTodoHandler::class     => \Prooph\Proophessor\Container\Model\Todo\PostTodoHandlerFactory::class,
        \Prooph\Proophessor\Model\Todo\Handler\MarkTodoAsDoneHandler::class     => \Prooph\Proophessor\Container\Model\Todo\MarkTodoAsDoneHandlerFactory::class,
        \Prooph\Proophessor\Model\Todo\Handler\AddDeadlineToTodoHandler::class => \Prooph\Proophessor\Container\Model\Todo\AddDeadlineToTodoHandlerFactory::class,
        \Prooph\Proophessor\Model\Todo\TodoList::class            => \Prooph\Proophessor\Container\Infrastructure\Repository\EventStoreTodoListFactory::class,
        //Projections
        \Prooph\Proophessor\Projection\User\UserProjector::class => \Prooph\Proophessor\Container\Projection\User\UserProjectorFactory::class,
        \Prooph\Proophessor\Projection\User\UserFinder::class    => \Prooph\Proophessor\Container\Projection\User\UserFinderFactory::class,
        \Prooph\Proophessor\Projection\Todo\TodoProjector::class => \Prooph\Proophessor\Container\Projection\Todo\TodoProjectorFactory::class,
        \Prooph\Proophessor\Projection\Todo\TodoFinder::class    => \Prooph\Proophessor\Container\Projection\Todo\TodoFinderFactory::class,
    ]
];

/**
 * The application config is merged from several files
 * and then registered as a service with the name "config"
 * in the service manager
 *
 * Note: Config merge (recursive array merge) can become an expensive task.
 *       In a production system you should cache the merged config.
 *       We don't cache it in this demo to keep the system set up as simple as possible.
 */
$appConfig = \Zend\Config\Factory::fromFiles([
    __DIR__ . '/prooph.php',
    __DIR__ . '/event_store.local.php',
    __DIR__ . '/dbal_connection.local.php',
    __DIR__ . '/routes.php',
    __DIR__ . '/templates.php',
]);

$servicesConfig['services']['config'] = $appConfig;

$mongoClientFactoryConfigFile = __DIR__ . '/mongo_client.local.php';

if (file_exists($mongoClientFactoryConfigFile)) {
    $mongoClientFactoryConfig = include $mongoClientFactoryConfigFile;
    $servicesConfig['factories']['mongo_client'] = $mongoClientFactoryConfig['mongo_client'];
}

//Finally we return the ready to use service manager
return new \Zend\ServiceManager\ServiceManager(new \Zend\ServiceManager\Config($servicesConfig));
