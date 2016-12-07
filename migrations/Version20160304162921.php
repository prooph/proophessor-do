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
class Version20160304162921 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $todo = $schema->getTable(Table::TODO);
        $todo->addColumn('reminder', 'string', ['default' => null, 'notnull' => false, 'length' => 30]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $todo = $schema->getTable(Table::TODO);
        $todo->dropColumn('reminder');
    }
}
