<?php

namespace Prooph\ProophessorDo\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Prooph\EventStore\Adapter\Doctrine\Schema\EventStoreSchema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20150429205328 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        if (class_exists('Prooph\EventStore\Adapter\Doctrine\Schema\EventStoreSchema')) {
            EventStoreSchema::createSingleStream($schema, 'event_stream', true);
        }
    }

    public function down(Schema $schema)
    {
        if (class_exists('Prooph\EventStore\Adapter\Doctrine\Schema\EventStoreSchema')) {
            EventStoreSchema::dropStream($schema);
        }
    }
}
