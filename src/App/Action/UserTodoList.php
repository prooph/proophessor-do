<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Prooph\ProophessorDo\Model\Todo\Query\GetTodosByAssigneeId;
use Prooph\ProophessorDo\Model\User\Query\GetUserById;
use Prooph\ServiceBus\QueryBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class UserTodoList implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templates;

    /**
     * @var QueryBus
     */
    private $queryBus;

    public function __construct(TemplateRendererInterface $templates, QueryBus $queryBus)
    {
        $this->templates = $templates;
        $this->queryBus = $queryBus;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
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
                'todos' => $todos,
            ])
        );
    }
}
