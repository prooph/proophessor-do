#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

echo "using adapter: mysql"
touch ./config/autoload/dbal_connection.local.php

cat > config/autoload/dbal_connection.local.php <<EOL
<?php
return [
    'doctrine' => [
        'connection' => [
            'default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'host' => 'mariadb',
                'port' => '3306',
                'user' => 'dev',
                'password' => 'dev',
                'dbname' => 'proophessor',
                'charset' => 'utf8',
                'driverOptions' => [
                    1002 => "SET NAMES 'UTF8'"
                ],
            ],
        ],
    ],
 ];
EOL

cat > config/autoload/event_store.local.php <<EOL
<?php
return [
    'prooph' => [
        'event_store' => [
            'adapter' => [
                'type' => 'Prooph\\EventStore\\Adapter\\Doctrine\\DoctrineEventStoreAdapter',
                'options' => [
                    'connection_alias' => 'doctrine.connection.default',
                ],
            ],
        ]
    ],
 ];
EOL

php bin/migrations.php --no-interaction migrations:migrate
