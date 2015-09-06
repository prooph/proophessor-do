# Installation

## Step 1 - Install application

`git clone https://github.com/prooph/proophessor-do.git` into the document root of a local web server.
Proophessor-do is based on a Zend Framework 2 Skeleton Application. Follow the [installation guide](https://github.com/zendframework/ZendSkeletonApplication#installation)
that can be found on the appropriate github repository.

## Step 2 - Install event store adapter

prooph offers two database adapters for `prooph/event-store` at the moment.
Pick the one you want to play with and install it via composer.

### Doctrine DBAL Adapter

`composer require prooph/event-store-doctrine-adapter`

### MongoDB Adapter

`composer require prooph/event-store-mongodb-adapter`

## Step 3 - Configure Database

Before you can start you have to configure your database connection.
As this is an example application for a CQRS-driven application we are using two different persistence layers.
One is responsible for persisting the **write model**. This task is taken by prooph/event-store.
And the other one is responsible for persisting the **read model** aka **projections**.

We've prepared a template for you. Just rename the
[config/autoload/local.php.dist](../config/autoload/local.php.dist) to `local.php` and adjust configuration accordingly.
Read on for more details.

### Adapter Configuration

Tell the event store which adapter to use. You'll find a hint in the `local.php.dist` file.

#### Doctrine DBAL Adapter

If you uncomment the doctrine dbal adapter it will use the same **dbal connection** as the read model does.
The required `event_stream` table is automatically created by `doctrine migrations` which you have to execute to create
the projection tables too. Please see projection configuration for details.

#### MongoDB Adapter

If you uncomment the mongo db adapter it will use a `\MongoClient` with default connection settings.
If you need to configure other connection params you can adjust the mongo client set up included in the `local.php.dist` file.

### Projection Configuration
Projections are persisted in SQL tables using doctrine DBAL. The projections are independent from the event store adapter
so you must set up a RDBMS (we suggest MySql) and adjust the `doctrine.connection.orm_default` configuration
which you can find in the `local.php.dist` file.

#### Create An Empty Database
Before you can run the migrations you have to make sure that the database `todo` exists. You can of course use another
name for the database but please align the `doctrine.connection.orm_default` configuration accordingly.

#### Run Doctrine Migrations

To create the needed projection tables (and the event_stream if doctrine es adapter is installed)
you should perform the [migrations](../data/migrations/) by running `./vendor/bin/doctrine-module migrations:migrate`
on *nix or `./vendor/bin/doctrine-module.bat migrations:migrate` on windows from the root directory of the application.

## Step 4 - Open In Browser

Navigate to `http://localhost/proophessor-do/pubic/` or similar depending on how you've installed the application.