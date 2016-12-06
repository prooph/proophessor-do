<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Prooph\ProophessorDo\App\Action;

use Prooph\ProophessorDo\Model\User\Query\GetUserById;
use Prooph\ServiceBus\QueryBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class UserTodoForm
 *
 * @package Prooph\ProophessorDo\App\Action
 */
final class UserTodoForm
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
        $this->templates  = $templates;
        $this->queryBus = $queryBus;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return HtmlResponse
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $userId = $request->getAttribute('user_id');

        $invalidUser = true;
        $user = null;

        if ($userId) {
            $user = null;
            $this->queryBus->dispatch(new GetUserById($userId))
                ->then(
                    function ($result) use (&$user) {
                        $user = $result;
                    }
                );

            if ($user) {
                $invalidUser = false;
            }
        }

        return new HtmlResponse(
            $this->templates->render('page::user-todo-form', ['invalidUser' => $invalidUser, 'user' => $user])
        );
    }
}
