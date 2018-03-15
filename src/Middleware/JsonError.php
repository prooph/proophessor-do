<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Prooph\HttpMiddleware\Exception\RuntimeException;
use Prooph\ServiceBus\Exception\MessageDispatchException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Error middleware to handle json requests
 */
final class JsonError implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            $contentType = trim($request->getHeaderLine('Content-Type'));

            if ($e instanceof RuntimeException) {
                $e = $e->getPrevious();

                if ($e instanceof MessageDispatchException) {
                    $e = $e->getPrevious();
                }
            }

            if (0 === mb_strpos($contentType, 'application/json')) {
                $data = 'development' === getenv('PROOPH_ENV')
                    ? ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
                    : ['message' => 'Server Error'];

                return new JsonResponse($data, StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
