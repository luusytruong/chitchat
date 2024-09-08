<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            $client->send($msg);
            // if ($from !== $client) {
            //     $client->send($msg);
            // }
        }
        echo $msg . "\n";
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Kiểm tra và phục vụ file index.html nếu tồn tại
// $checkIndexFile = function ($request, $response) {
//     $file = __DIR__ . '/index.html';
//     if (file_exists($file)) {
//         $response->writeHead(200, ['Content-Type' => 'text/html']);
//         $response->end(file_get_contents($file));
//         return true;
//     }
//     return false;
// };

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

echo "Server is runing in port 8080\n";

$server->run();