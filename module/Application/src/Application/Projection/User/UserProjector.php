<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 11:44 PM
 */
namespace Application\Projection\User;

use Application\Model\Todo\TodoWasPosted;
use Application\Model\User\UserWasRegistered;
use Application\Projection\Table;
use Doctrine\DBAL\Connection;

/**
 * Class UserProjector
 *
 * @package Application\Projection\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserProjector
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
     * @param UserWasRegistered $event
     */
    public function onUserWasRegistered(UserWasRegistered $event)
    {
        $this->connection->insert(Table::USER, [
            'id' => $event->userId()->toString(),
            'name' => $event->name(),
            'email' => $event->emailAddress()->toString()
        ]);
    }

    /**
     * Increases the open_todos counter of the assignee by one
     *
     * @param TodoWasPosted $event
     */
    public function onTodoWasPosted(TodoWasPosted $event)
    {
        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos + 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $event->assigneeId()->toString());

        $stmt->execute();
    }
}
