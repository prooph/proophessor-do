<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 7:41 PM
 */
namespace Prooph\ProophessorDo\App\Action;

use Prooph\ProophessorDo\Projection\User\UserFinder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateInterface;

/**
 * Class UserTodoForm
 *
 * @package Prooph\ProophessorDo\App\Action
 */
final class UserTodoForm
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
     * @param TemplateInterface $templates
     * @param UserFinder $userFinder
     */
    public function __construct(TemplateInterface $templates, UserFinder $userFinder)
    {
        $this->templates  = $templates;
        $this->userFinder = $userFinder;
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
            $user = $this->userFinder->findById($userId);

            if ($user) {
                $invalidUser = false;
            }
        }

        return new HtmlResponse(
            $this->templates->render('page::user-todo-form', ['invalidUser' => $invalidUser, 'user' => $user])
        );
    }
}
