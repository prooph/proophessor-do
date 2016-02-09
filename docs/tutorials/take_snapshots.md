# Take Snapshots Tutorial

This tutorial explains how snapshotting works with prooph components.
You will learn how to take a snapshot manually and see the performance boost by comparing load time of an aggregate with
and without snapshots. Furthermore, you will learn how snapshotting can be automated and finally take snapshots asynchronously
so that your command handling process stays incredibly fast.

## Many Events
First let's see why you never want to live without snapshots again.

We've prepared a script that adds 100 deadline events to an open todo. Please make sure your proophessor-do app
has at least one open todo! Then simply run `php scripts/add_deadlines.php` in a terminal.
The script will print three lines. The first one tells you which open todo was picked.

**Copy the todo uuid and paste it in an empty file. We need it for further actions.**

Now run `php scripts/load_todo_without_snapshot.php <todo_uuid>`. The script will tell you the time needed to load
the todo. As this script does not use a snapshot adapter it will take some time (depending on your system)
to replay all the 100 deadline events added earlier.

## Configure Snapshot Store

Before we actually take snapshots we need to install and configure the feature.

### Install Dependencies
We need one of the [available snapshot adapters](https://github.com/prooph/event-store/blob/master/README.md#available-snapshot-adapters) for prooph/event-store.
For this tutorial we'll use the doctrine snapshot adapter. Feel free to test the other adapters once you are a snapshotting pro.

Install the adapter via composer `composer require prooph/snapshot-doctrine-adapter`.

### Prepare Snapshot Table
The newly installed package ships with a schema tool compatible with doctrine migrations. We can use it to
automatically create a snapshot table that will contain all aggregate snapshots.

Run `php bin/migrations.php migrations:generate` in a terminal. You'll find a new migration step in the `migrations` folder.
Add the snapshot schema tool so that the `up` and `down` methods look like this:

```php
/**
 * @param Schema $schema
 */
public function up(Schema $schema)
{
    \Prooph\EventStore\Snapshot\Adapter\Doctrine\Schema\SnapshotStoreSchema::create($schema);
}

/**
 * @param Schema $schema
 */
public function down(Schema $schema)
{
    \Prooph\EventStore\Snapshot\Adapter\Doctrine\Schema\SnapshotStoreSchema::drop($schema);
}
```

Save the file and run `php bin/migrations.php migrations:migrate`.
You should find a new table in your proophessor-do schema called `snapshot`.

*Note: the schema tool takes an optional second parameter to use a custom snapshot table name. This is useful when you want to have dedicated snapshot tables for different aggregate types.*

### Configuring Snapshot Store

Loosely coupled components (like the prooph components) are great but wiring them together is a bit of work for the user.
Don't worry, we do it step by step and it will only take a minute. Promised :)

The only file we need to touch is `config/autoload/prooph.global.php`.

First add the following config to tell the snapshot store which adapter to use:

```php
return [
    'prooph' => [
        'event_store' => [
            //...
        ],
        //Add the following section
        'snapshot_store' => [
            'adapter' => [
                'type' => \Prooph\EventStore\Snapshot\Adapter\Doctrine\DoctrineSnapshotAdapter::class,
                'options' => [
                    'connection_alias' => 'doctrine.connection.default',
                    'snapshot_table_map' => [
                        \Prooph\ProophessorDo\Model\Todo\Todo::class => 'snapshot',
                    ]
                ]
            ]
        ],
        //...
    ]
];
```

*Note: The snapshot store and the doctrine adapter are pre configured services in proophessor-do so their factories are already registered in the DI container.*

Second step is to tell the TodoList (repository for todos) that it should use the snapshot store.
Therefor we add a new config key to the repository configuration. Search for `todo_list` in `config/autoload/prooph.global.php` and
add the following line:

```php
return [
    'prooph' => [
        'event_store' => [
            //...
            'todo_list' => [
                'repository_class' => \Prooph\ProophessorDo\Infrastructure\Repository\EventStoreTodoList::class,
                'aggregate_type' => \Prooph\ProophessorDo\Model\Todo\Todo::class,
                'aggregate_translator' => \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class,
       /* --> */'snapshot_store' => \Prooph\EventStore\Snapshot\SnapshotStore::class,
            ],
        ],
        //...
    ],
];
```

That's it for now. We are ready to ...

## Take A Snapshot

You have the todo uuid at hand? Great! Run `php scripts/take_todo_snapshot.php <todo_uuid>` with it.
You should see `Snapshot was taken!` printed in the terminal. If you don't trust the script have a look at the snapshot table.
Congratulations! You've taken your first snapshot with prooph.

*Curious how fast the todo will load now?*

Run `php scripts/load_todo_with_snapshot.php <todo_uuid>`. Awesome, isn't it?

## Automate Snapshotting

We've seen how easy it is to improve performance with aggregate snapshots. But how can snapshotting be automated?
The answer is: with [prooph/snapshotter](https://github.com/prooph/snapshotter).

Let's add it to our dependencies with `composer require prooph/snapshotter`.

The package ships with two tools. The first one is an event store plugin that acts as a listener on all recorded domain
events and the second one is the actual snapshotter service.
To enable the plugins they must be available as a services in the DI container.

Add new `factories` entries in `config/autoload/prooph_dependencies.global.php`:

```php
return [
    //...
    'factories' => [
        //...
        \Prooph\Snapshotter\SnapshotPlugin::class => \Prooph\Snapshotter\Container\SnapshotPluginFactory::class,
        \Prooph\Snapshotter\Snapshotter::class => \Prooph\Snapshotter\Container\SnapshotterFactory::class,
    ],
    //...
];

//...
```

The event store plugin needs to be added to the plugin list. The list can be found in `config/autoload/prooph.global.php`.

```php
return [
    'prooph' => [
        'event_store' => [
            'plugins' => [
                \Prooph\EventStoreBusBridge\EventPublisher::class,
                \Prooph\EventStoreBusBridge\TransactionManager::class,
      /* --> */ \Prooph\Snapshotter\SnapshotPlugin::class,
            ],
            //...
        ],
        //...
    ],
];
```

The `SnapshotPlugin` observes recorded domain events and sends `TakeSnapshot` commands to the `Snapshotter`.
Aggregate snapshots depend on the version of their aggregates. Each time an aggregate records a new domain event the
aggregate version is increased by one and added to the event. The `SnapshotPlugin` compares the version with a
configured interval f.e. *every 5 events a snapshot*.
Add the rule to `config/autoload/prooph.global.php`:

```php
return [
    'prooph' => [
        'event_store' => [
            //...
        ],
        'snapshotter' => [
            'version_step' => 5, //every 5 events a snapshot
            'aggregate_repositories' => [
                \Prooph\ProophessorDo\Model\Todo\Todo::class => \Prooph\ProophessorDo\Model\Todo\TodoList::class,
            ]
        ],
        //...
    ],
];
```

We also told the `Snapshotter` that the `TodoList` is the responsible repository for `Todo` aggregates.

One last step and our app will take snapshots automatically. As already mentioned the `SnapshotPlugin` sends
`TakeSnapshot` commands using the application command bus. The `Snapshotter` on the other hand acts as command handler
for `TakeSnapshot` commands so we simply need to configure a new command route in `config/autoload/prooph.global.php`:

```php
return [
    'prooph' => [
        'event_store' => [
            //...
        ],
        'snapshotter' => [
            //..
        ],
        'service_bus' => [
            'command_bus' => [
                'router' => [
                    'routes' => [
                        //...
                        \Prooph\Snapshotter\TakeSnapshot::class => \Prooph\Snapshotter\Snapshotter::class,
                    ],
                ],
            ],
            //..
        ],
        //..
    ],
];
```

Time to test it. You can use the same scripts again but you no longer need to run `scripts/take_todo_snapshot.php` as this
will be done by the `Snapshotter`.

## Async Snapshotting

You may have noticed that `php scripts/add_deadlines.php` takes more time now to add 100 deadline events. This is because the
added snapshotting feature takes a snapshot every 5 events. It is great that
snapshots improve load time of aggregates but decreased write performance is a drawback. Fortunately, we can improve that thanks
to prooph/service-bus and async message producers.

In this tutorial we will use the [psb-zeromq-producer](https://github.com/prooph/psb-zeromq-producer). Zeromq extension must be installed.
Check [http://zeromq.org/bindings:php](http://zeromq.org/bindings:php) for details.

And of course we need the producer package `composer require prooph/psb-zeromq-producer`.

No new package without a bit configuration ;)

Make zeromq producer available as a service in the DI container (`config/autoload/prooph_dependencies.global.php`):

```php
return [
    //...
    'factories' => [
        //...
        \Prooph\ServiceBus\Message\ZeroMQ\ZeroMQMessageProducer::class => \Prooph\ServiceBus\Message\ZeroMQ\Container\ZeroMQMessageProducerFactory::class,
    ],
    //...
];

//...
```

Configure zeromq binding in `config/autoload/prooph.global.php`:

```php
return [
    'prooph' => [
        'event_store' => [
            //...
        ],
        'snapshotter' => [
            //...
        ],
        'zeromq_producer' => [
            'dsn' => 'tcp://127.0.0.1:5555', // ZMQ Server Address.
            'persistent_id' => 'proophessor-od', // ZMQ Persistent ID to keep connections alive between requests.
            'rpc' => false, // Async mode without expecting a response.
        ],
        //...
    ],
];
```

The trick to take snapshots async is now that we route `TakeSnapshot` commands to the `psb-zeromq-producer` instead
of the snapshotter.

Change command routing in `config/autoload/prooph.global.php`:

```php
return [
    'prooph' => [
        'event_store' => [
            //...
        ],
        'snapshotter' => [
            //..
        ],
        'zeromq_producer' => [
            //...
        ],
        'service_bus' => [
            'command_bus' => [
                'router' => [
                    'routes' => [
                        //...
                        \Prooph\Snapshotter\TakeSnapshot::class => \Prooph\ServiceBus\Message\ZeroMQ\ZeroMQMessageProducer::class,
                    ],
                ],
            ],
            //..
        ],
        //..
    ],
];
```

Zeromq will deliver all `TakeSnapshot` commands to a consumer listening on the same port. We wrote such a consumer.
So you only need to run `php bin/snapshot_server.php` in a terminal and enjoy the show.

Just perform `php scripts/add_deadlines.php` again and keep an eye on the server terminal. Whenever you see a new
`Message received: ...` entry a new snapshot was taken.

This is the end of our snapshotting tutorial. We hope you enjoyed it and learned something new.
Feedback is welcome: [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/prooph/improoph)

your prooph team
