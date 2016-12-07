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

namespace Prooph\ProophessorDo\Model\User\Event;

use Assert\Assertion;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\User\EmailAddress;
use Prooph\ProophessorDo\Model\User\UserId;

/**
 * Class UserWasRegistered
 *
 * @package Prooph\ProophessorDo\Model\User\Event
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class UserWasRegistered extends AggregateChanged
{
    private $userId;

    private $username;

    private $emailAddress;

    /**
     * @param UserId $userId
     * @param string $name
     * @param EmailAddress $emailAddress
     * @return UserWasRegistered
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
        if (null === $this->userId) {
            $this->userId = UserId::fromString($this->aggregateId());
        }

        return $this->userId;
    }

    /**
     * @return string
     */
    public function name()
    {
        if (null === $this->username) {
            $this->username = $this->payload['name'];
        }
        return $this->username;
    }

    /**
     * @return EmailAddress
     */
    public function emailAddress()
    {
        if (null === $this->emailAddress) {
            $this->emailAddress = EmailAddress::fromString($this->payload['email']);
        }
        return $this->emailAddress;
    }
}
