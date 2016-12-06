<?php

namespace Prooph\ProophessorDo\Model\User\Event;

use Assert\Assertion;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\User\EmailAddress;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class UserWasRegisteredAgain
 *
 * @package Prooph\ProophessorDo\Model\User\Event
 * @author Lucas Courot <lucas@courot.com>
 */
final class UserWasRegisteredAgain extends AggregateChanged
{
    private $userId;

    private $username;

    private $emailAddress;

    /**
     * @param UserId $userId
     * @param string $name
     * @param EmailAddress $emailAddress
     * @return UserWasRegisteredAgain
     */
    public static function withData(UserId $userId, $name, EmailAddress $emailAddress)
    {
        Assertion::string($name);

        $event = self::occur($userId->toString(), [
            'name' => $name,
            'email' => $emailAddress->toString(),
        ]);

        $event->userId = $userId;
        $event->username = $name;
        $event->emailAddress = $emailAddress;

        return $event;
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        if (is_null($this->userId)) {
            $this->userId = UserId::fromString($this->aggregateId());
        }

        return $this->userId;
    }

    /**
     * @return string
     */
    public function name()
    {
        if (is_null($this->username)) {
            $this->username = $this->payload['name'];
        }

        return $this->username;
    }

    /**
     * @return EmailAddress
     */
    public function emailAddress()
    {
        if (is_null($this->emailAddress)) {
            $this->emailAddress = EmailAddress::fromString($this->payload['email']);
        }

        return $this->emailAddress;
    }
}
