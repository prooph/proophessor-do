<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 7:04 PM
 */
namespace Prooph\ProophessorDo\App\Action;

use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use Prooph\ProophessorDo\Projection\User\UserFinder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateInterface;

/**
 * Class UserTodoList
 *
 * @package Prooph\ProophessorDo\App\Action
 */
final class UserTodoList
{
    /**
     * @var TemplateInterface
     */
    private $templates;

    /**
     * @var UserFinder
     */
    private $userFinder;

    /**
     * @var TodoFinder
     */
    private $todoFinder;

    /**
     * @param TemplateInterface $templates
     * @param UserFinder $userFinder
     * @param TodoFinder $todoFinder
     */
    public function __construct(TemplateInterface $templates, UserFinder $userFinder, TodoFinder $todoFinder)
    {
        $this->templates = $templates;
        $this->userFinder = $userFinder;
        $this->todoFinder = $todoFinder;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $userId = $request->getAttribute('user_id');

        $user = $this->userFinder->findById($userId);
        $todos = $this->todoFinder->findByAssigneeId($userId);

        return new HtmlResponse(
            $this->templates->render('page::user-todo-list', [
                'user' => $user,
                'todos' => $todos
            ])
        );
    }
}
