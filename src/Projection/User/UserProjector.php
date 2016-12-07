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

namespace Prooph\ProophessorDo\Projection\User;

use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasReopened;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasUnmarkedAsExpired;
use Prooph\ProophessorDo\Model\User\Event\UserWasRegistered;
use Prooph\ProophessorDo\Model\User\Exception\UserNotFound;
use Prooph\ProophessorDo\Projection\Table;
use Doctrine\DBAL\Connection;

class UserProjector
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var UserFinder
     */
    private $userFinder;

    public function __construct(Connection $connection, UserFinder $userFinder)
    {
        $this->connection = $connection;
        $this->userFinder = $userFinder;
    }

    public function onUserWasRegistered(UserWasRegistered $event): void
    {
        $this->connection->insert(Table::USER, [
            'id' => $event->userId()->toString(),
            'name' => $event->name(),
            'email' => $event->emailAddress()->toString()
        ]);
    }

    /**
     * @throws UserNotFound
     */
    public function onTodoWasPosted(TodoWasPosted $event): void
    {
        $user = $this->userFinder->findUserOfTodo($event->todoId()->toString());

        if (! $user) {
            throw new UserNotFound(
                sprintf(
                    "Data of the assigned user of the todo %s cannot be found",
                    $event->todoId()->toString()
                )
            );
        }

        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos + 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $event->assigneeId()->toString());

        $stmt->execute();
    }

    /**
     * @throws UserNotFound if data of the the assigned user can not be found
     */
    public function onTodoWasMarkedAsDone(TodoWasMarkedAsDone $event): void
    {
        $user = $this->userFinder->findUserOfTodo($event->todoId()->toString());

        if (! $user) {
            throw new UserNotFound(
                sprintf(
                    "Data of the assigned user of the todo %s cannot be found",
                    $event->todoId()->toString()
                )
            );
        }

        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos - 1, done_todos = done_todos + 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $user->id);

        $stmt->execute();
    }

    /**
     * @throws UserNotFound if data of the the assigned user can not be found
     */
    public function onTodoWasReopened(TodoWasReopened $event): void
    {
        $user = $this->userFinder->findUserOfTodo($event->todoId()->toString());

        if (! $user) {
            throw new UserNotFound(
                sprintf(
                    "Data of the assigned user of the todo %s cannot be found",
                    $event->todoId()->toString()
                )
            );
        }

        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos + 1, done_todos = done_todos - 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $user->id);

        $stmt->execute();
    }

    /**
     * @throws UserNotFound if data of the the assigned user can not be found
     */
    public function onTodoWasMarkedAsExpired(TodoWasMarkedAsExpired $event): void
    {
        $user = $this->userFinder->findUserOfTodo($event->todoId()->toString());

        if (! $user) {
            throw new UserNotFound(
                sprintf(
                    "Data of the assigned user of the todo %s cannot be found",
                    $event->todoId()->toString()
                )
            );
        }

        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos - 1, expired_todos = expired_todos + 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $user->id);

        $stmt->execute();
    }

    /**
     * @throws UserNotFound if data of the the assigned user can not be found
     */
    public function onTodoWasUnmarkedAsExpired(TodoWasUnmarkedAsExpired $event): void
    {
        $user = $this->userFinder->findUserOfTodo($event->todoId()->toString());

        if (! $user) {
            throw new UserNotFound(
                sprintf(
                    "Data of the assigned user of the todo %s cannot be found",
                    $event->todoId()->toString()
                )
            );
        }

        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos + 1, expired_todos = expired_todos - 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $user->id);

        $stmt->execute();
    }
}
