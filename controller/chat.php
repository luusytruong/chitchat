<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require __DIR__ . '/../model/db.php';

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $dbConnection;

    public function __construct() {
        $this ->clients = new \SplObjectStorage;
        global $conn;
        $this->dbConnection = $conn;
    }

    public function onOpen( ConnectionInterface $conn ) {
        $this->clients->attach( $conn );
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage( ConnectionInterface $from, $msg ) {
        $data = json_decode( $msg, true );

        //check cookie from clients
        if ( isset( $data[ 'type' ] ) && $data[ 'type' ] === 'init' ) {
            $session_id = $data[ 'session_id' ];
            echo "ssid: {$session_id}\n";

            $Response = file_get_contents( 'http://localhost/chitchat/controller/getUserId.php?session_id=' . $session_id );
            //check response
            if ( $Response === FALSE ) {
                echo 'Failed to fetch user_id\n';
                return;
            }
            $data = json_decode( $Response, true );
            //check data
            if ( json_last_error() !== JSON_ERROR_NONE ) {
                echo 'JSON decode error: ' . json_last_error_msg() . "\n";
                return;
            }
            //check exits user_id
            if ( isset( $data[ 'user_id' ] ) ) {
                $user_id = $data[ 'user_id' ];

                //save user_id
                $this->clients[ $from ] = $user_id;

                echo json_encode( $user_id ) . "\n";

                $sql = 'UPDATE status SET is_online = 1 WHERE user_id = ?';
                $status_stmt = $this->dbConnection->prepare( $sql );
                $status_stmt->bind_param( 'i', $user_id );
                $status_stmt->execute();

                $status_online = json_encode( [ 'type'=>'status', 'user_id'=> $user_id, 'is_online'=> true ] );
                foreach ( $this->clients as $client ) {
                    $client->send( $status_online );
                }

            } else {
                echo 'Not user_id\n';
            }
            return;
        }

        foreach ( $this->clients as $client ) {
            if ( $client !== $from ) {
                $client->send( $msg );
            }
        }
        echo $msg . "\n";
    }

    public function onClose( ConnectionInterface $conn ) {
        // Update status to offline
        if ( isset( $this->clients[ $conn ] ) ) {
            $user_id = $this->clients[ $conn ];
            $sql = 'UPDATE status SET is_online = 0 WHERE user_id = ?';
            $status_stmt = $this->dbConnection->prepare( $sql );
            $status_stmt->bind_param( 'i', $user_id );
            $status_stmt->execute();

            $status_online = json_encode( [ 'type'=>'status', 'user_id'=> $user_id, 'is_online'=> false ] );
            foreach ( $this->clients as $client ) {
                $client->send( $status_online );
            }
        }

        $this->clients->detach( $conn );
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError( ConnectionInterface $conn, \Exception $e ) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

?>