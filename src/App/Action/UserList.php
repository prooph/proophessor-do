<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 9/6/15 - 1:15 PM
 */
namespace Prooph\ProophessorDo\App\Action;

use Prooph\ProophessorDo\Projection\User\UserFinder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateInterface;

/**
 * Class UserList
 *
 * @package Prooph\ProophessorDo\App\Action
 */
final class UserList
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
        $this->templates = $templates;
        $this->userFinder = $userFinder;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $users = $this->userFinder->findAll();

        return new HtmlResponse(
            $this->templates->render('page::user-list', ['users' => $users])
        );
    }
}
