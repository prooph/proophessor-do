<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 5/4/15 - 5:44 PM
 */
namespace Application\Projection\Todo;

use Application\Model\Todo\TodoWasPosted;
use Application\Projection\Table;
use Doctrine\DBAL\Connection;

/**
 * Class TodoProjector
 *
 * @package Application\Projection\Todo
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoProjector 
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
     * @param TodoWasPosted $event
     */
    public function onTodoWasPosted(TodoWasPosted $event)
    {
        $this->connection->insert(Table::TODO, [
            'id' => $event->todoId()->toString(),
            'assignee_id' => $event->assigneeId()->toString(),
            'text' => $event->text(),
            'status' => $event->todoStatus()->toString()
        ]);
    }
} 