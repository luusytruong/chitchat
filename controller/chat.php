<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require __DIR__ . '/../model/db.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct()
 {
        $this ->clients = new \SplObjectStorage;
    }

    public function onOpen( ConnectionInterface $conn ) {
        $this->clients->attach( $conn );
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage( ConnectionInterface $from, $msg ) {

        global $conn;



        foreach ( $this->clients as $client ) {
            if ( $client !== $from ) {
                $client->send( $msg );
            }
        }
        echo $msg . "\n";
    }

    public function onClose( ConnectionInterface $conn ) {
        $this->clients->detach( $conn );
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError( ConnectionInterface $conn, \Exception $e ) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

?>