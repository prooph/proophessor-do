# Manual installation

This is the hard way. Please ensure that you not want to use Docker. ;-)

### Requirements:
 - PHP >= v7.1
 - MySql >= v5.7.8 (For JSON support)

### Step 1 - Get source code

`git clone https://github.com/prooph/proophessor-do.git` into the document root of a local web server.

### Step 2 - Configure Database

Before you can start you have to configure your database connection.
As this is an example application for a CQRS-driven application we are using two different persistence layers.
One is responsible for persisting the **write model**. This task is taken by prooph/event-store.
And the other one is responsible for persisting the **read model** aka **projections**.

### Step 3 - Configuration

#### 3.1 Email sending (mandatory):

Copy `config/autoload/mail.local.php.dist` to `config/autoload/mail.local.php` and make your adjustments.

#### 3.2 Read model (mandatory):

 - Copy `config/autoload/doctrine.local.php.dist` to `config/autoload/doctrine.local.php` and make your adjustments.
 - Execute `CREATE DATABASE todo;` on your MySQL instance.

#### 3.3 Event Store

 - Copy `config/autoload/mysql_event_store.local.php.dist` to `config/autoload/mysql_event_store.local.php` and make your adjustments.
 - Execute the scripts located at:
   - `vendor/prooph/pdo-event-store/scripts/mysql/01_event_streams_table.sql`
   - `vendor/prooph/pdo-event-store/scripts/mysql/02_projections_table.sql`
 - Create empty stream: Run `php scripts/create_event_stream.php`

#### 3.4 PDO Snapshot Store (optional)
*PDO Snapshot Store uses the same PDO connection as for given EventStore*

Copy `config/autoload/pdo_snapshot_store.local.php.dist` to `config/autoload/pdo_snapshot_store.local.php` and make your adjustments.

### Step 4 - Start projections

`php bin/todo_projection.php`

`php bin/todo_reminder_projection.php`

`php bin/user_projection.php`

##### 4.1 Start snapshotters (only if you decided to use 3.4)

`php bin/todo_snapshotter.php`

`php bin/user_snapshotter.php`

### Step 5 - View It

Open a terminal and navigate to the project root. Then start the PHP built-in web server with `php -S 0.0.0.0:8080 -t public`
and open [http://localhost:8080](http://localhost:8080/) in a browser.

*Note: You can also set the environmental variable `PROOPH_ENV` to `development`. That will forward exception messages to the client in case of an error.
When using the built-in web server you can set the variable like so: `PROOPH_ENV=development php -S 0.0.0.0:8080 -t public`*
