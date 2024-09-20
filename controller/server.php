<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/chat.php';

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

echo "Websocket running in port 8080\n";

$server->run();