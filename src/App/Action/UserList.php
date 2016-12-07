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

use Prooph\ProophessorDo\Model\User\Query\GetAllUsers;
use Prooph\ServiceBus\QueryBus;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class UserList
 *
 * @package Prooph\ProophessorDo\App\Action
 */
final class UserList
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
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $users = [];
        $this->queryBus->dispatch(new GetAllUsers())
            ->then(
                function ($result) use (&$users) {
                    $users = $result;
                }
            );

        return new HtmlResponse(
            $this->templates->render('page::user-list', ['users' => $users])
        );
    }
}
