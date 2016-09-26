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

use Prooph\ProophessorDo\Model\Todo\Query\GetTodosByAssigneeId;
use Prooph\ProophessorDo\Model\User\Query\GetUserById;
use Prooph\ServiceBus\QueryBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class UserTodoList
 *
 * @package Prooph\ProophessorDo\App\Action
 */
final class UserTodoList
{
    /**
     * @var TemplateRendererInterface
     */
    private $templates;

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @param TemplateRendererInterface $templates
     * @param QueryBus $queryBus
     */
    public function __construct(TemplateRendererInterface $templates, QueryBus $queryBus)
    {
        $this->templates = $templates;
        $this->queryBus = $queryBus;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $userId = $request->getAttribute('user_id');

        $user = null;
        $this->queryBus->dispatch(new GetUserById($userId))
            ->then(
                function ($result) use (&$user) {
                    $user = $result;
                }
            );
        $todos = null;
        $this->queryBus->dispatch(new GetTodosByAssigneeId($userId))
            ->then(
                function ($result) use (&$todos) {
                    $todos = $result;
                }
            );

        return new HtmlResponse(
            $this->templates->render('page::user-todo-list', [
                'user' => $user,
                'todos' => $todos
            ])
        );
    }
}
