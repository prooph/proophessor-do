<?php
namespace Prooph\ProophessorDo\ProcessManager;

use Prooph\ProophessorDo\Model\Todo\Event\TodoAssigneeWasReminded;
use Prooph\ProophessorDo\Model\Todo\Query\GetTodoById;
use Prooph\ProophessorDo\Model\User\Query\GetUserById;
use Prooph\ServiceBus\QueryBus;
use Zend\Mail;
use Zend\Mail\Transport\TransportInterface;

/**
 * Class SendTodoReminderMailSubscriber
 *
 * @package Prooph\ProophessorDo\App\Mail
 * @author Roman Sachse <r.sachse@ipark-media.de>
 */
final class SendTodoReminderMailSubscriber
{
    /**
     * @var QueryBus
     */
    private $queryBus;
    /**
     * @var TransportInterface
     */
    private $mailer;

    /**
     * @param QueryBus $queryBus
     * @param TransportInterface $mailer
     */
    public function __construct(QueryBus $queryBus, TransportInterface $mailer)
    {
        $this->queryBus = $queryBus;
        $this->mailer = $mailer;
    }

    /**
     * @param TodoAssigneeWasReminded $event
     */
    public function __invoke(TodoAssigneeWasReminded $event)
    {
        $user = null;
        $this->queryBus->dispatch(new GetUserById($event->userId()->toString()))
            ->then(
                function ($result) use (&$user) {
                    $user = $result;
                }
            );
        $todo = null;
        $this->queryBus->dispatch(new GetTodoById($event->todoId()->toString()))
            ->then(
                function ($result) use (&$todo) {
                    $todo = $result;
                }
            );

        $mail = new Mail\Message();
        $mail->setBody("Hello {$user->name}. This a reminder for '{$todo->text}'. Don't be lazy!");
        $mail->setFrom('reminder@getprooph.org', 'Proophessor-do');
        $mail->addTo($user->email, $user->name);
        $mail->setSubject('Proophessor-do Todo Reminder');

        $this->mailer->send($mail);
    }
}
