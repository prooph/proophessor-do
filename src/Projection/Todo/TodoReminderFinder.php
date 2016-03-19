<?php
namespace Prooph\ProophessorDo\Projection\Todo;

use Doctrine\DBAL\Connection;
use Prooph\ProophessorDo\Model\Todo\TodoReminderStatus;
use Prooph\ProophessorDo\Projection\Table;

/**
 * Class TodoReminderFinder
 *
 * @package Prooph\ProophessorDo\Projection\Todo
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class TodoReminderFinder
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
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    /**
     * @return \stdClass[] of todoData
     */
    public function findOpen()
    {
        $stmt = $this->connection->prepare(
            sprintf(
                "SELECT * FROM %s where reminder < NOW() AND status = '%s'",
                Table::TODO_REMINDER,
                TodoReminderStatus::OPEN
            )
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
