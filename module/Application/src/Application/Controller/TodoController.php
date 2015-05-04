<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 5/4/15 - 4:08 PM
 */
namespace Application\Controller;

use Application\Model\Command\PostTodo;
use Application\Projection\User\UserFinder;
use Prooph\ServiceBus\CommandBus;
use Rhumsaa\Uuid\Uuid;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class TodoController
 *
 * @package Application\Controller
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TodoController extends AbstractActionController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var UserFinder
     */
    private $userFinder;

    public function __construct(CommandBus $commandBus, UserFinder $userFinder)
    {
        $this->commandBus = $commandBus;
        $this->userFinder = $userFinder;
    }

    public function postAction()
    {
        $view = $this->getPostViewModel();

        $userId = $this->params('user_id');

        if (! is_string($userId) || empty($userId)) {
            return $view->setVariable('invalidUser', true);
        }

        $user = $this->userFinder->findById($userId);

        if (! $user) {
            return $view->setVariable('invalidUser', true);
        }

        $view->setVariable('user', $user);

        if ($this->getRequest()->isPost()) {
            $todo = $this->params()->fromPost('todo');

            if (! is_string($todo) || strlen($todo) < 3) {
                return $view->setVariable('invalidTodo', true)->setVariable('todo', (string)$todo);
            }

            $todoId = Uuid::uuid4();

            $command = PostTodo::forUser($userId, $todo, $todoId);

            $this->commandBus->dispatch($command);

            //When dispatching a command you get no response from the command bus, except an exception is thrown!
            //The client has to request the data from the read model. However, a Post-Redirect-Get mechanism is
            //recommended anyway.
            return $this->redirect()->toRoute('user_show', ['user_id' => $userId]);
        }

        return $view;
    }

    /**
     * @return ViewModel
     */
    private function getPostViewModel()
    {
        $view = new ViewModel([
            'invalidUser' => false,
            'invalidTodo' => false,
        ]);
        $view->setTemplate('application/todo/post');

        return $view;
    }
} 