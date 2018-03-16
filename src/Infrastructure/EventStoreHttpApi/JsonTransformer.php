<?php
/**
 * This file is part of the prooph/event-store-http-api.
 * (c) 2016-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2016-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Infrastructure\EventStoreHttpApi;

use Prooph\EventStore\Http\Middleware\Transformer;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

final class JsonTransformer implements Transformer
{
    /**
     * @param array $result
     * @return ResponseInterface
     */
    public function createResponse(array $result): ResponseInterface
    {
        return new JsonResponse($result);
    }
}
