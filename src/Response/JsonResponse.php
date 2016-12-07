<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Response;

use Prooph\Psr7Middleware\Response\ResponseStrategy;
use React\Promise\Promise;

final class JsonResponse implements ResponseStrategy
{
    public function fromPromise(Promise $promise)
    {
        $json = null;

        $promise->done(function ($data) use (&$json) {
            $json = $data;
        });

        return new \Zend\Diactoros\Response\JsonResponse($json);
    }
}
