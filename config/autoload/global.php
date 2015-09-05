<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'service_manager' => [
        'invokables' => [
            'Doctrine\\ORM\\Mapping\\UnderscoreNamingStrategy' => 'Doctrine\\ORM\\Mapping\\UnderscoreNamingStrategy',
            \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class => \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class,
        ],
        'factories' => [
            //prooph/event-store set up
            'prooph.event_store' => \Prooph\EventStore\Container\EventStoreFactory::class,
            //Default factories for the event store adapters, depending on the installed adapter the event store factory
            //will use the configured adapter type to get an adapter instance from the service manager
            //to ease system set up we register both factories here so that the user doesn't need to worry about it
            'Prooph\\EventStore\\Adapter\\MongoDb\\MongoDbEventStoreAdapter' => 'Prooph\\EventStore\\Adapter\\MongoDb\\Container\\MongoDbEventStoreAdapterFactory',
            'Prooph\\EventStore\\Adapter\\Doctrine\\DoctrineEventStoreAdapter' => 'Prooph\\EventStore\\Adapter\\Doctrine\\Container\\DoctrineEventStoreAdapterFactory',
            //prooph/service-bus set up
            \Prooph\ServiceBus\CommandBus::class => \Prooph\ServiceBus\Container\CommandBusFactory::class,
            \Prooph\ServiceBus\EventBus::class => \Prooph\ServiceBus\Container\EventBusFactory::class,
            //prooph/event-store-bus-bridge set up
            \Prooph\EventStoreBusBridge\TransactionManager::class => \Prooph\EventStoreBusBridge\Container\TransactionManagerFactory::class,
            \Prooph\EventStoreBusBridge\EventPublisher::class => \Prooph\EventStoreBusBridge\Container\EventPublisherFactory::class,
        ],
    ],
    'prooph' => [
        'event_store' => [
            'plugins' => [
                \Prooph\EventStoreBusBridge\EventPublisher::class,
            ]
        ],
        'service_bus' => [
            'command_bus' => [
                'plugins' => [
                    \Prooph\EventStoreBusBridge\TransactionManager::class,
                ]
            ],
            'event_bus' => [
                'plugins' => [
                    \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class
                ]
            ]
        ]
    ],
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'naming_strategy' => 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy',
                // Generate proxies automatically (turn off for production)
                'generate_proxies'  => false,
                // metadata cache instance to use. The retrieved service name will
                // be `doctrine.cache.$thisSetting`
                'metadata_cache'    => 'filesystem',

                // DQL queries parsing cache instance to use. The retrieved service
                // name will be `doctrine.cache.$thisSetting`
                'query_cache'       => 'filesystem',
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/migrations',
                'name' => 'System Database Migrations',
                'namespace' => 'Application\\Migrations',
                'table' => 'migrations',
            ],
        ],
    ],
];
