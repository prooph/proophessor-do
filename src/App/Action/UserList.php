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

use Prooph\ProophessorDo\Model\User\Query\GetAllUsers;
use Prooph\ServiceBus\QueryBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class UserList implements RequestHandlerInterface
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

    /**
     * Handle the request and return a response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
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
