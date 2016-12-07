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
 * Auto-generated Migration: Please modify to your need!
 */
class Version20150924204612 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $todo = $schema->getTable(Table::TODO);
        $todo->addColumn('deadline', 'string', ['default' => null, 'notnull' => false, 'length' => 30]);
    }

    public function down(Schema $schema): void
    {
        $todo = $schema->getTable(Table::TODO);
        $todo->dropColumn('deadline');
    }
}
