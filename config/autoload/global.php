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
        ],
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
