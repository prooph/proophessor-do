<?php
namespace Prooph\ProophessorDo\ProcessManager;

use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mail;

/**
 * Class SendTodoDeadlineExpiredMailSubscriber
 *
 * @package Prooph\ProophessorDo\App\Mail
 * @author Michał Żukowski <michal@durooil.com
 */
final class SendTodoDeadlineExpiredMailSubscriber
{
    private $userFinder;
    private $todoFinder;
    private $mailer;

    public function __construct(
        UserFinder $userFinder,
        TodoFinder $todoFinder,
        TransportInterface $mailer
    ) {
        $this->userFinder = $userFinder;
        $this->todoFinder = $todoFinder;
        $this->mailer = $mailer;
    }

    public function __invoke(TodoWasMarkedAsExpired $event)
    {
        $todo = $this->todoFinder->findById($event->todoId()->toString());
        $user = $this->userFinder->findById($todo->assignee_id);

        $message = sprintf(
            'Hi %s! Just a heads up: your todo `%s` has expired on %s.',
            $user->name,
            $todo->text,
            $todo->deadline
        );

        $mail = new Mail\Message();
        $mail->setBody($message);
        $mail->setEncoding('utf-8');
        $mail->setFrom('reminder@getprooph.org', 'Proophessor-do');
        $mail->addTo($user->email, $user->name);
        $mail->setSubject('Proophessor-do Todo expired');

        $this->mailer->send($mail);
    }
}
