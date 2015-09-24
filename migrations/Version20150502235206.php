<?php

namespace Prooph\ProophessorDo\Migrations;

use Prooph\ProophessorDo\Projection\Table;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20150502235206 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $user = $schema->createTable(Table::USER);

        $user->addColumn('id', 'string', ['length' => 36]);
        $user->addColumn('name', 'string', ['length' => 50]);
        $user->addColumn('email', 'string', ['length' => 100]);
        $user->addColumn('open_todos', 'integer', ['default' => 0]);
        $user->addColumn('done_todos', 'integer', ['default' => 0]);
        $user->addColumn('expired_todos', 'integer', ['default' => 0]);
        $user->setPrimaryKey(['id']);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable(Table::USER);
    }
}
