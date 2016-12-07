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

namespace Prooph\ProophessorDo;

use RuntimeException;
use ZMQ;
use ZMQContext;
use ZMQSocket;

if (! extension_loaded('zmq')) {
    throw new RuntimeException('Requires `ext-zmq` extension to run server.');
}

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$container = require 'config/container.php';

$context = new ZMQContext();
$socket = new ZMQSocket($context, ZMQ::SOCKET_PULL);
$socket->bind('tcp://127.0.0.1:5555');

echo "ZMQ Snapshot Server Started.\n";

$messageFactory = new \Prooph\Common\Messaging\FQCNMessageFactory();

$snapshotter = $container->get(\Prooph\Snapshotter\Snapshotter::class);

while ($messageStr = $socket->recv()) {
    echo 'Message received: ' . $messageStr . "\n";

    $messageArr = json_decode($messageStr, true);

    if ($messageArr['message_name'] !== \Prooph\Snapshotter\TakeSnapshot::class) {
        continue;
    }

    $messageArr['created_at'] = \DateTimeImmutable::createFromFormat(
        'Y-m-d\TH:i:s.u',
        $messageArr['created_at'],
        new \DateTimeZone('UTC')
    );

    $message = $messageFactory->createMessageFromArray($messageArr['message_name'], $messageArr);

    $snapshotter($message);
}
