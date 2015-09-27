#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

echo "using adapter mongodb"
touch ./config/mongo_client.local.php

php composer.phar require prooph/event-store-mongodb-adapter --update-no-dev -o --prefer-dist

cat > config/mongo_client.local.php << EOL
<?php
return [
        'mongo_client' => function () {
            //Change set up of the mongo client, if you need to configure connection settings
            return new \MongoClient();
        },
    ];
EOL

    cat > config/event_store.local.php << EOL
<?php
return [
    'prooph' => [
        'event_store' => [
            'adapter' => [
                'type' => 'Prooph\\EventStore\\Adapter\\MongoDb\\MongoDbEventStoreAdapter',
                'options' => [
                    'db_name' => 'proophessor',
                    'mongo_connection_alias' => 'mongo_client',
               ],
            ],
        ]
    ],
 ];
EOL

php bin/migrations.php --no-interaction migrations:migrate
