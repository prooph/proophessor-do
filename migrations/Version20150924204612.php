<?php

namespace Prooph\ProophessorDo\Migrations;

use Prooph\ProophessorDo\Projection\Table;
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
        $todo->addColumn('deadline', 'string', ['default' => null, 'notnull' => false, 'length' => 30]);
    }

    public function down(Schema $schema)
    {
        $todo = $schema->getTable(Table::TODO);
        $todo->dropColumn('deadline');
    }
}
