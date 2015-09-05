<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/3/15 - 10:47 PM
 */
namespace Application\Controller;

use Application\Projection\Todo\TodoFinder;
use Application\Projection\User\UserFinder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

final class UserViewController extends AbstractActionController
{
    /**
     * @var UserFinder
     */
    private $userFinder;

    /**
     * @var TodoFinder
     */
    private $todoFinder;

    public function __construct(UserFinder $userFinder, TodoFinder $todoFinder)
    {
        $this->userFinder = $userFinder;
        $this->todoFinder = $todoFinder;
    }

    public function listAction()
    {
        $view = new ViewModel(['users' => $this->userFinder->findAll()]);
        $view->setTemplate('application/user-view/list');
        return $view;
    }

    public function showAction()
    {
        $userId = $this->params('user_id');

        $view = new ViewModel([
            'user' => $this->userFinder->findById($userId),
            'todos' => $this->todoFinder->findByAssigneeId($userId)
        ]);
        $view->setTemplate('application/user-view/show');
        return $view;
    }
}
