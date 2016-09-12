# Installation
*proophessor-do* offers you three options to install the demo application. We support *Vagrant*, *Docker* and have *manual* 
instructions.

> Docker is the recommended and fastest installation method

At first, please clone this repository by running `git clone https://github.com/prooph/proophessor-do.git` or download 
it manually from GitHub. 

If you use a own local web server, put this project to the document root of the local web 
server and navigate to the proophessor-do directory and follow the *Do it manually* instructions.

## Using Docker
First ensure [Docker](https://docs.docker.com/engine/installation/ubuntulinux/) and [Docker Compose](https://docs.docker.com/compose/install/) 
are installed. It's recommended to use the latest version of Docker and Docker Compose. Docker will download all 
dependencies and starts the containers.

### Step 1 - Get the source code
The application runs as a Docker volume. First download the source to a local directory:
`git clone https://github.com/prooph/proophessor-do.git`

If you are using a Linux distribution running SELinux then set the security context to allow Docker access to the volume:
`chcon -Rt svirt_sandbox_file_t proophessor-do/`

All the Docker commands are run from the source directory, so also do:
`cd proophessor-do/`

### Step 2 - Install dependencies

To ensure you have the latest Docker images for the default application execute:

```bash
$ docker pull prooph/php:5.6-fpm && docker pull prooph/composer:5.6 && docker pull prooph/nginx:www
```

Install PHP dependencies via Composer

```bash
$ docker run --rm -it --volume $(pwd):/app prooph/composer:5.6 install -o --prefer-dist
```

Now start your Docker Container so we can use Docker Compose for the next steps

```bash
$ docker-compose up -d
```

### Step 3 - Install event store adapter

*prooph* offers two database adapters for `prooph/event-store` (at the moment).

The read model uses MySQL so it's important to execute the MySQL setup. This configures also MySQL for the event store.

```bash
$ docker run --rm -it --volume $(pwd):/app prooph/composer:5.6 require prooph/event-store-doctrine-adapter -o --prefer-dist
$ docker-compose run --rm php sh bin/setup_mysql.sh
```

If you want to use MongoDB (only PHP 5.6 supported) for the event store execute also:

```bash
$ docker run --rm -it --volume $(pwd):/app prooph/composer:5.6 require prooph/event-store-mongodb-adapter -o --prefer-dist
$ docker-compose run --rm php sh bin/setup_mongodb.sh
```

### Step 4 - That's it
Now open [http://localhost:8080](http://localhost:8080/) and have fun.

## Using Vagrant
Please install the following software if not already installed:

* [Vagrant >= 1.7.3](http://www.vagrantup.com/downloads.html)
* [Virtualbox >= 5.0](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant docker-compose plugin](https://github.com/leighmcculloch/vagrant-docker-compose) (`vagrant plugin install vagrant-docker-compose`)

```bash
$: vagrant up
```

All dependencies will be downloaded. This may take a while ...

Now open [http://localhost:8080](http://localhost:8080/) and have fun.

## Do it manually
This is the hard way. Please ensure that you not want to use Docker. ;-)

### Step 1 - Get source code

`git clone https://github.com/prooph/proophessor-do.git` into the document root of a local web server.

### Step 2 - Install event store adapter

prooph offers two database adapters for `prooph/event-store` (at the moment).
Pick the one you want to play with and install it via composer.

#### Doctrine DBAL Adapter

`composer require prooph/event-store-doctrine-adapter`

#### MongoDB Adapter

> Only PHP <= 5.6 is currently supported

`composer require prooph/event-store-mongodb-adapter`

### Step 3 - Configure Database

Before you can start you have to configure your database connection.
As this is an example application for a CQRS-driven application we are using two different persistence layers.
One is responsible for persisting the **write model**. This task is taken by prooph/event-store.
And the other one is responsible for persisting the **read model** aka **projections**.

We've prepared a template for you. Just rename the
[config/autoload/dbal_connection.local.php.dist](../config/autoload/dbal_connection.local.php.dist) to `config/autoload/dbal_connection.local.php`
and adjust configuration accordingly. Read on for more details.

#### Adapter Configuration

Tell the event store which adapter to use. To do so rename [config/autoload/event_store.local.php.dist](../config/autoload/event_store.local.php.dist)
to `config/autoload/event_store.local.php` and uncomment the adapter that you have installed in **Step 2**.

##### Doctrine DBAL Adapter

If you uncomment the doctrine dbal adapter it will use the same **dbal connection** as the read model does.
The required `event_stream` table is automatically created by `doctrine migrations` which you have to execute to create
the projection tables too. Please see projection configuration for details.

##### MongoDB Adapter

If you uncomment the mongo db adapter you also need to rename [config/autoload/mongo_client.local.php.dist](../config/autoload/mongo_client.local.php.dist)
to `config/autoload/mongo_client.local.php`.
The MongoDB adapter will use a `\MongoClient` with default connection settings.
But you can adjust the mongo client set up in the config file linked above.

### Projection Configuration
Projections are persisted in SQL tables using Doctrine DBAL. The projections are independent from the event store adapter
so you must set up a RDBMS (we suggest MySql) and adjust the `doctrine.connection.default` configuration
which you can find in the `dbal_connection.local.php.dist` file.

##### Create An Empty Database
Before you can run the migrations you have to make sure that the database `todo` exists. You can of course use another
name for the database but please align the `doctrine.connection.default` configuration accordingly.

##### Run Doctrine Migrations

To create the needed projection tables (and the `event_stream` if the doctrine event store adapter is installed)
you should perform the [migrations](../migrations/) by running `php bin/migrations.php migrations:migrate` from the project root.

*Note: We use a custom migrations script instead of the doctrine version because we're injecting the dbal connection provided by our IoC container.*

### Step 4 - View It

Open a terminal and navigate to the project root. Then start the PHP built-in web server with `php -S 0.0.0.0:8080 -t public`
and open [http://localhost:8080](http://localhost:8080/) in a browser.

*Note: You can also set the environmental variable `PROOPH_ENV` to `development`. That will forward exception messages to the client in case of an error.
When using the built-in web server you can set the variable like so: `PROOPH_ENV=development php -S 0.0.0.0:8080 -t public`*
