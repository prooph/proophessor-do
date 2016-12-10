# Installation
*proophessor-do* offers you three options to install the demo application. We support *Vagrant*, *Docker* and have *manual* 
instructions.

> Docker is the recommended and fastest installation method

At first, please clone this repository by running `git clone https://github.com/prooph/proophessor-do.git` or download 
it manually from GitHub. 

If you use a own local web server, put this project to the document root of the local web 
server and navigate to the proophessor-do directory and follow the *Do it manually* instructions.

## Using Docker (ATTENTION - Docker installation manual is out of date !!!)
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

### Step 3 - Install event store implementation

The read model uses MySQL so it's important to execute the MySQL setup. This configures also MySQL for the event store.

```bash
$ docker run --rm -it --volume $(pwd):/app prooph/composer:5.6 require prooph/event-store-doctrine-adapter -o --prefer-dist
$ docker-compose run --rm php sh bin/setup_mysql.sh
```

### Step 4 - That's it
Now open [http://localhost:8080](http://localhost:8080/) and have fun.

## Using Vagrant (ATTENTION - Vagrant installation manual is out of date !!!)
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

### Step 2 - Configure Database

Before you can start you have to configure your database connection.
As this is an example application for a CQRS-driven application we are using two different persistence layers.
One is responsible for persisting the **write model**. This task is taken by prooph/event-store.
And the other one is responsible for persisting the **read model** aka **projections**.

### Step 3 - Configuration

For email sending (mandatory):

Copy `config/autoload/mail.local.php.dist` to `config/autoload/mail.local.php` and make your adjustments.

For read model (mandatory):

Copy `config/autoload/doctrine.local.php.dist` to `config/autoload/doctrine.local.php` and make your adjustments.

For MySQL Event Store (mandatory: choose MySQL or Postgres):

Copy `config/autoload/mysql_event_store.local.php.dist` to `config/autoload/mysql_event_store.local.php` and make your adjustments.

For Postgres Event Store (mandatory: choose MySQL or Postgres):

Copy `config/autoload/postgres_event_store.local.php.dist` to `config/autoload/postgres_event_store.local.php` and make your adjustments.

For PDO Snapshot Store (optional - it uses the same PDO connection as for given EventStore)

Copy `config/autoload/pdo_snapshot_store.local.php.dist` to `config/autoload/pdo_snapshot_store.local.php` and make your adjustments.

For MongoDB Snapshot Store (optional)

Copy `config/autoload/mongo_snapshot_store.local.php.dist` to `config/autoload/mongo_snapshot_store.local.php` and make your adjustments.

##### Create An Empty Database for Read Model

execute `CREATE DATABASE todo;` on your MySQL instance.

##### Create An Empty Database for MySQL Event Store

execute the scripts located at:

`vendor/prooph/pdo-event-store/scripts/mysql_event_streams_table.sql`
`vendor/prooph/pdo-event-store/scripts/mysql_projections_table.sql`

##### Create An Empty Database for Postgres Event Store

execute the scripts located at:

`vendor/prooph/pdo-event-store/scripts/postgres_event_streams_table.sql`
`vendor/prooph/pdo-event-store/scripts/postgres_projections_table.sql`

##### Create empty stream

execute:

`php scripts/create_event_stream.php`

##### Start projections

`php bin/todo_projection.php`

`php bin/todo_reminder_projection.php`

`php bin/user_projection.php`

##### Start snapshotters (optional)

`php bin/todo_snapshotter.php`

`php bin/user_snapshotter.php`

### Step 4 - View It

Open a terminal and navigate to the project root. Then start the PHP built-in web server with `php -S 0.0.0.0:8080 -t public`
and open [http://localhost:8080](http://localhost:8080/) in a browser.

*Note: You can also set the environmental variable `PROOPH_ENV` to `development`. That will forward exception messages to the client in case of an error.
When using the built-in web server you can set the variable like so: `PROOPH_ENV=development php -S 0.0.0.0:8080 -t public`*
