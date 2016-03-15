<?php

namespace Prooph\ProophessorDo\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Prooph\ProophessorDo\Projection\Table;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160308110616 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $user = $schema->createTable(Table::TODO_REMINDER);

        $user->addColumn('todo_id', 'string', ['length' => 36]);
        $user->addColumn('reminder', 'string', ['length' => 30]);
        $user->addColumn('status', 'string', ['length' => 10]);
        $user->setPrimaryKey(['todo_id']);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable(Table::TODO_REMINDER);
    }
}
