<?php

namespace Prooph\Proophessor\Migrations;

use Prooph\Proophessor\Projection\Table;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20150924204612 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $todo = $schema->getTable(Table::TODO);
        $todo->addColumn('deadline', 'datetime', ['default' => null, 'notnull' => false]);
    }

    public function down(Schema $schema)
    {
        $todo = $schema->getTable(Table::TODO);
        $todo->dropColumn('deadline');
    }
}
