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

namespace ProophTest\ProophessorDo\App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use PHPUnit\Framework\TestCase;
use Prooph\ProophessorDo\App\Action\Home;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

final class HomeTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_a_middleware(): void
    {
        /** @var TemplateRendererInterface $templates */
        $templates = $this->prophesize(TemplateRendererInterface::class)->reveal();

        $action = new Home($templates);

        self::assertInstanceOf(MiddlewareInterface::class, $action);
    }

    /**
     * @test
     */
    public function it_renders_the_home_page(): void
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class)->reveal();
        /** @var DelegateInterface $delegate */
        $delegate = $this->prophesize(DelegateInterface::class)->reveal();
        /** @var TemplateRendererInterface|ObjectProphecy $templates */
        $templates = $this->prophesize(TemplateRendererInterface::class);
        $templates->render('page::home')->willReturn('<home />');

        $action = new Home($templates->reveal());
        $response = $action->process($request, $delegate);

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame('<home />', (string) $response->getBody());
    }
}
