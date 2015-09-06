<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/3/15 - 10:48 PM
 */
namespace Prooph\Proophessor\Projection\User;

use Prooph\Proophessor\Projection\Table;
use Doctrine\DBAL\Connection;

/**
 * Class UserFinder
 *
 * @package Prooph\Proophessor\Projection\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserFinder
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    /**
     * @return \stdClass[] containing userData
     */
    public function findAll()
    {
        return $this->connection->fetchAll(sprintf("SELECT * FROM %s", Table::USER));
    }

    /**
     * @param $userId
     * @return null|\stdClass containing userData
     */
    public function findById($userId)
    {
        $stmt = $this->connection->prepare(sprintf("SELECT * FROM %s where id = :user_id", Table::USER));
        $stmt->bindValue('user_id', $userId);
        $stmt->execute();
        return $stmt->fetch();
    }
}
