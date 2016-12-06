<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ProophTest\ProophessorDo\ProcessManager;

use Prooph\ProophessorDo\ProcessManager\SendTodoDeadlineExpiredMailProcessManager;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;
use Prooph\ServiceBus\CommandBus;
use Prophecy\Argument;

class SendTodoDeadlineExpiredMailProcessManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_dispatches_email_to_the_assignee_command()
    {
        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->dispatch(Argument::any())->shouldBeCalled();

        $processManager = new SendTodoDeadlineExpiredMailProcessManager($commandBus->reveal());

        $processManager(TodoWasMarkedAsExpired::fromStatus(
            TodoId::generate(),
            TodoStatus::OPEN(),
            TodoStatus::EXPIRED()
        ));
    }
}
