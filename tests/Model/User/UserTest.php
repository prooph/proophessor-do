<?php

namespace ProophTest\ProophessorDo\Model\Todo;

use Prooph\ProophessorDo\Model\User\EmailAddress;
use Prooph\ProophessorDo\Model\User\Event\UserWasRegistered;
use Prooph\ProophessorDo\Model\User\Event\UserWasRegisteredAgain;
use Prooph\ProophessorDo\Model\User\User;
use Prooph\ProophessorDo\Model\User\UserId;
use ProophTest\ProophessorDo\TestCase;

/**
 * Class UserTest
 *
 * @package ProophTest\ProophessorDo\Model\User
 * @author Lucas Courot <lucas@courot.com>
 */
final class UserTest extends TestCase
{
    /**
     * @test
     * @return User $user
     */
    public function it_registers_a_new_user()
    {
        $userId = UserId::generate();
        $name = 'John Doe';
        $emailAddress = EmailAddress::fromString('john.doe@example.com');

        $user = User::registerWithData($userId, $name, $emailAddress);

        $this->assertInstanceOf(User::class, $user);

        $events = $this->popRecordedEvent($user);

        $this->assertEquals(1, count($events));
        $this->assertInstanceOf(UserWasRegistered::class, $events[0]);

        $expectedPayload = [
            'name' => $name,
            'email' => $emailAddress->toString()
        ];

        $this->assertEquals($expectedPayload, $events[0]->payload());

        return $user;
    }

    /**
     * @test
     */
    public function it_registers_a_new_user_again()
    {
        $userId = UserId::generate();
        $name = 'John Doe';
        $emailAddress = EmailAddress::fromString('john.doe@example.com');

        $events = [
            UserWasRegistered::withData($userId, $name, $emailAddress)
        ];

        /** @var $user User */
        $user = $this->reconstituteAggregateFromHistory(User::class, $events);

        $user->registerAgain($name);

        $events = $this->popRecordedEvent($user);

        $this->assertEquals(1, count($events));
        $this->assertInstanceOf(UserWasRegisteredAgain::class, $events[0]);

        $expectedPayload = [
            'name' => $name,
            'email' => $emailAddress->toString()
        ];

        $this->assertEquals($expectedPayload, $events[0]->payload());
    }

    /**
     * @test
     * @expectedException \Prooph\ProophessorDo\Model\User\Exception\InvalidName
     */
    public function it_throws_an_exception_if_user_registers_with_invalid_name()
    {
        $name = '';

        User::registerWithData(UserId::generate(), $name, EmailAddress::fromString('john.doe@example.com'));
    }

    /**
     * @test
     * @param User $user
     * @expectedException \Prooph\ProophessorDo\Model\User\Exception\InvalidName
     * @depends it_registers_a_new_user
     */
    public function it_throws_an_exception_if_user_registers_again_with_invalid_name(User $user)
    {
        $name = '';

        $user->registerAgain($name);
    }
}
