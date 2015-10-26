<?php

namespace Prooph\ProophessorDo\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Prooph\EventStore\Snapshot\Adapter\Doctrine\Schema\SnapshotStoreSchema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151022171744 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (class_exists('Prooph\EventStore\Snapshot\Adapter\Doctrine\Schema\SnapshotStoreSchema')) {
            SnapshotStoreSchema::create($schema);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if (class_exists('Prooph\EventStore\Snapshot\Adapter\Doctrine\Schema\SnapshotStoreSchema')) {
            SnapshotStoreSchema::drop($schema);
        }
    }
}
