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
    /**
     * @var UserFinder
     */
    private $userFinder;

    /**
     * @var TodoFinder
     */
    private $todoFinder;

    /**
     * @var TransportInterface
     */
    private $mailer;

    /**
     * SendTodoDeadlineExpiredMailSubscriber constructor.
     * @param UserFinder $userFinder
     * @param TodoFinder $todoFinder
     * @param TransportInterface $mailer
     */
    public function __construct(
        UserFinder $userFinder,
        TodoFinder $todoFinder,
        TransportInterface $mailer
    ) {
        $this->userFinder = $userFinder;
        $this->todoFinder = $todoFinder;
        $this->mailer = $mailer;
    }

    /**
     * @param TodoWasMarkedAsExpired $event
     * @return void
     */
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
