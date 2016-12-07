<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
