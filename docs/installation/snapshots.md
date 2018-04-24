# Snapshot Store Installation

Snapshots are an optional feature.

At the moment prooph offers snapshot store implementations for:

 - [PDO](https://github.com/prooph/pdo-snapshot-store) (Mysql/Postgres)
 - [MongoDB](https://github.com/prooph/mongodb-snapshot-store)
 - [ArangoDB](https://github.com/prooph/arangodb-snapshot-store)


### Snapshotter

As a general purpose helper we use the *prooph/snapshotter* which can be installed using

 ```bash
 $ composer require prooph/snapshotter
 ```

### PDO Snapshot Store

*PDO Snapshot Store uses the same PDO connection as for given EventStore*

 - Copy `config/autoload/pdo_snapshot_store.local.php.dist` to `config/autoload/pdo_snapshot_store.local.php` and make your adjustments.
 - Install the needed package:

  ```bash
  $ composer require prooph/pdo-snapshot-store
  ```
  
 - Execute the following script:
 
   for MySQL: `vendor/prooph/pdo-snapshot-store/scripts/mysql_snapshot_table.sql`
   
   for Postgres: `vendor/prooph/pdo-snapshot-store/scripts/postgres_snapshot_table.sql`

### MongoDB Snapshot Store

 - Copy `config/autoload/mongo_snapshot_store.local.php.dist` to `config/autoload/mongo_snapshot_store.local.php` and make your adjustments.
 - Install the needed package:

  ```bash
  $ composer require prooph/mongodb-snapshot-store
  ```

## Snapshot tutorial

Now as you picked and configured you snapshot store, start playing with the new feature.

Please jump to the [Snapshot Tutorial](../tutorials/take_snapshots.md) !
