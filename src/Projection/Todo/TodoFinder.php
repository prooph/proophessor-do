<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/4/15 - 8:47 PM
 */
namespace Prooph\ProophessorDo\Projection\Todo;

use Prooph\ProophessorDo\Projection\Table;
use Doctrine\DBAL\Connection;

/**
 * Class TodoFinder
 *
 * @package Prooph\ProophessorDo\Projection\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoFinder
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return \stdClass[] of todoData
     */
    public function findAll()
    {
        return $this->connection->fetchAll(sprintf("SELECT * FROM %s", Table::TODO));
    }

    /**
     * @param string $assigneeId
     * @return \stdClass[] of todoData
     */
    public function findByAssigneeId($assigneeId)
    {
        return $this->connection->fetchAll(
            sprintf("SELECT * FROM %s WHERE assignee_id = :assignee_id", Table::TODO),
            ['assignee_id' => $assigneeId]
        );
    }

    /**
     * @param string $todoId
     * @return \stdClass of todoData
     */
    public function findById($todoId)
    {
        $stmt = $this->connection->prepare(sprintf("SELECT * FROM %s where id = :todo_id", Table::TODO));
        $stmt->bindValue('todo_id', $todoId);
        $stmt->execute();
        return $stmt->fetch();
    }
}
