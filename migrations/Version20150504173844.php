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

use Prooph\ProophessorDo\Projection\Table;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20150504173844 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $todo = $schema->createTable(Table::TODO);

        $todo->addColumn('id', 'string', ['length' => 36]);
        $todo->addColumn('assignee_id', 'string', ['length' => 36]);
        $todo->addColumn('text', 'text');
        $todo->addColumn('status', 'string', ['length' => 7]);
        $todo->setPrimaryKey(['id']);
        $todo->addIndex(['assignee_id', 'status']);
        $todo->addIndex(['status']);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable(Table::TODO);
    }
}
