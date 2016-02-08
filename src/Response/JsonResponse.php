<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 5/2/15 - 5:27 PM
 */
namespace Prooph\ProophessorDo\Response;

use Prooph\Psr7Middleware\Response\ResponseStrategy;
use React\Promise\Promise;

final class JsonResponse implements ResponseStrategy
{
    public function fromPromise(Promise $promise)
    {
        $json = null;

        $promise->done(function($data) use (&$json) {
            $json = $data;
        });

        return new \Zend\Diactoros\Response\JsonResponse($json);
    }

}
