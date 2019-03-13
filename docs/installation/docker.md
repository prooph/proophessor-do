# Installation using Docker

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
$ docker pull prooph/php:7.1-fpm && docker pull prooph/composer:7.1 && docker pull prooph/nginx:www
```

Install PHP dependencies via Composer

#### Note for Windows: Replace `$(pwd)` with `%cd%` in all commands

```bash
$ docker run --rm -it --volume $(pwd):/app prooph/composer:7.1 install -o --prefer-dist

# respectively Windows:
$ docker run --rm -it --volume %cd%:/app prooph/composer:7.1 install -o --prefer-dist
```

### Step 3 - Configure

#### 3.1 Email sending (mandatory):

Copy `config/autoload/mail.local.php.dist` to `config/autoload/mail.local.php` and make your adjustments.

#### 3.2 Read model (mandatory):

Copy `config/autoload/doctrine.local.php.dist` to `config/autoload/doctrine.local.php` and use following config for the default docker set up:

```php
return [
    // Doctrine DBAL connection settings - for read model
    'doctrine' => [
        'connection' => [
            'default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'host' => 'mysql', // <- Name of the mysql docker container
                'port' => '3306',
                'user' => 'dev', // <- User configured in docker-compose.yml via MYSQL_USER
                'password' => 'dev', // <- Pwd configured in docker-compose.yml via MYSQL_PASSWORD
                'dbname' => 'todo', // <- Db name configured in docker-compose.yml via MYSQL_DATABASE
                'charset' => 'utf8',
                'driverOptions' => [
                    1002 => "SET NAMES 'UTF8'"
                ],
            ],
        ],
    ],
];
```

#### 3.3 Event Store

Copy `config/autoload/mysql_event_store.local.php.dist` to `config/autoload/mysql_event_store.local.php` and adjust the `pdo_connection` config.
For the default docker set up you can use the same parameters as above:

```php
return [
//...
    // prooph settings
    'prooph' => [
    //...
        'pdo_connection' => [
            'default' => [
                'schema' => 'mysql', // <- Name of the mysql docker container
                'host' => 'mysql',
                'port' => '3306',
                'user' => 'dev', // <- User configured in docker-compose.yml via MYSQL_USER
                'password' => 'dev', // <- Pwd configured in docker-compose.yml via MYSQL_PASSWORD
                'dbname' => 'todo', // <- Db name configured in docker-compose.yml via MYSQL_DATABASE
                'charset' => 'utf8',
            ],
        ],
```

#### 3.4 Start your Docker Containers

```bash
$ docker-compose up -d
```

#### 3.5 Create the initial event stream with the already started container:

```bash
$ docker exec proophessor-do_php_1 php /var/www/scripts/create_event_streams.php
```

### Step 4 - That's it!
Now open [http://localhost:8080](http://localhost:8080/) and have fun.
