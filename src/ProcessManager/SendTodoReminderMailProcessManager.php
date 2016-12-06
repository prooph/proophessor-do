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

use Prooph\ProophessorDo\Model\Todo\Command\SendTodoReminderMail;
use Prooph\ProophessorDo\Model\Todo\Event\TodoAssigneeWasReminded;
use Prooph\ProophessorDo\Model\Todo\Query\GetTodoById;
use Prooph\ProophessorDo\Model\User\Query\GetUserById;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\QueryBus;
use Zend\Mail;
use Zend\Mail\Transport\TransportInterface;

/**
 * Class SendTodoReminderMailProcessManager
 *
 * @package Prooph\ProophessorDo\App\Mail
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
class SendTodoReminderMailProcessManager
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param TodoAssigneeWasReminded $event
     */
    public function __invoke(TodoAssigneeWasReminded $event)
    {
        $this->commandBus->dispatch(SendTodoReminderMail::with($event->userId(), $event->todoId()));
    }
}
