<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 12:10 AM
 */
namespace Prooph\ProophessorDo\Model\User;

use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Assert\Assertion;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\ProophessorDo\Model\User\Event\UserWasRegistered;

/**
 * Class User
 *
 * A user manages Todos on his or her TodoList. Each user is identified by her user id, has a name and an email address.
 *
 * @package Prooph\ProophessorDo\Model\User
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class User extends AggregateRoot
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    /**
     * @param UserId $userId
     * @param string $name
     * @param EmailAddress $emailAddress
     * @return User
     */
    public static function registerWithData(UserId $userId, $name, EmailAddress $emailAddress)
    {
        $self = new self();

        $self->assertName($name);

        $self->recordThat(UserWasRegistered::withData($userId, $name, $emailAddress));

        return $self;
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return EmailAddress
     */
    public function emailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $text
     * @param TodoId $todoId
     * @return Todo
     */
    public function postTodo($text, TodoId $todoId)
    {
        return Todo::post($text, $this->userId(), $todoId);
    }

    /**
     * @return string representation of the unique identifier of the aggregate root
     */
    protected function aggregateId()
    {
        return $this->userId->toString();
    }

    /**
     * @param UserWasRegistered $event
     */
    protected function whenUserWasRegistered(UserWasRegistered $event)
    {
        $this->userId = $event->userId();
        $this->name = $event->name();
        $this->emailAddress = $event->emailAddress();
    }

    /**
     * @param string $name
     * @throws Exception\InvalidName
     */
    private function assertName($name)
    {
        try {
            Assertion::string($name);
            Assertion::notEmpty($name);
        } catch (\Exception $e) {
            throw Exception\InvalidName::reason($e->getMessage());
        }
    }
}
