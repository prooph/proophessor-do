<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prooph\ProophessorDo\ProcessManager;

use Prooph\ProophessorDo\Model\Todo\Command\NotifyUserOfExpiredTodo;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ServiceBus\CommandBus;

/**
 * Class SendTodoDeadlineExpiredMailProcessManager
 *
 * @package Prooph\ProophessorDo\App\Mail
 * @author Michał Żukowski <michal@durooil.com
 */
class SendTodoDeadlineExpiredMailProcessManager
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * SendTodoDeadlineExpiredMailProcessManager constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param TodoWasMarkedAsExpired $event
     * @return void
     */
    public function __invoke(TodoWasMarkedAsExpired $event)
    {
        $this->commandBus->dispatch(NotifyUserOfExpiredTodo::with($event->todoId()));
    }
}
