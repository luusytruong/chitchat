<?php

// include __DIR__ . '/../../model/dbHost.php';
include __DIR__ . '/../../model/db.php';

$session_id = $_POST[ 'session_id' ];
$response = file_get_contents( 'http://localhost/chitchat/controller/getUserId.php?session_id=' . $session_id );
$data = json_decode( $response, true );

header( 'Content-Type: application/json; charset=UTF-8' );
$currentUserId = $data[ 'user_id' ];

function hashId( $id ) {
    return 't' . hash( 'sha256', $id );
}

$sql = 'SELECT id, fullname FROM users ORDER BY id ASC';
$stmt = $pdo->prepare( $sql );

header( 'Content-Type: application/json; charset=UTF-8' );
//create html
$userHtml = [];

if ( $stmt->execute() ) {
    $data = $stmt->fetchAll( PDO::FETCH_ASSOC );

    foreach ( $data as $userData ) {
        if ( ( int )$userData[ 'id' ] !== ( int )$currentUserId ) {

            // concat html
            $userHtml[] = [
                'user'=> "<div id='". hashId( $userData[ 'id' ] ) ."' class='user'><div class='user-img'><img src='./view/img/user.png' alt='user'></div><div class='user-info'><div class='status'></div><div class='user-name'>{$userData['fullname']}</div><div class='latest-msg'>Nhấp để gửi tin nhắn</div></div></div>",
                'conversation'=> "<div class='". hashId( $userData[ 'id' ] ) ." msg-list'> </div>"
            ];
        }
    }
    // send json to client
    echo json_encode( [ $userHtml ] );
} else {
    echo json_encode( [ 'error'=> 'failed to execute query' ] );
}

?>
