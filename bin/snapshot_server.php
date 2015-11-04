<?php

if (! extension_loaded('zmq')) {
    throw new RuntimeException('Requires `ext-zmq` extension to run server.');
}

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$container = require 'config/services.php';

$context = new ZMQContext;
$socket = new ZMQSocket($context, ZMQ::SOCKET_PULL);
$socket->bind('tcp://127.0.0.1:5555');

echo "ZMQ Snapshot Server Started.\n";

while ($message = $socket->recv()) {
    echo "Message received: " . $message . "\n";
}

