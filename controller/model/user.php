<?php

// include __DIR__ . '/../../model/dbHost.php';
include __DIR__ . '/../../model/db.php';
include __DIR__ . '/idHandling.php';
include __DIR__ . '/userId.php';

$session_id = $_POST[ 'session_id' ];
// $response = file_get_contents('http://pwm.io.vn/controller/getUserId.php?session_id=' . $session_id);
// $response = file_get_contents( 'http://localhost/chitchat/controller/getUserId.php?session_id=' . $session_id );
// $data = json_decode( $response, true );

$currentUserId = getUserId($session_id);

// $currentUserId = $data[ 'user_id' ];

// $sql = 'SELECT id, fullname FROM users ORDER BY id ASC';
$sql = 'SELECT u.id, u.fullname, s.is_online FROM users u JOIN status s ON u.id = s.user_id ORDER BY u.id ASC';
$stmt = $pdo->prepare( $sql );

header( 'Content-Type: application/json; charset=UTF-8' );
//create html
$userHtml = [];

if ( $stmt->execute() ) {
    $data = $stmt->fetchAll( PDO::FETCH_ASSOC );

    foreach ( $data as $userData ) {
        $isOline = ((bool)$userData['is_online']) ? 'on' : '';
        $userHtml[] = [
            'user'=> "<div id='". hashId( $userData[ 'id' ] ) ."' class='user'><div class='user-img'><img src='./view/img/user.png' alt='user'></div><div class='user-info {$isOline}'><div class='status'></div><div class='user-name'>{$userData['fullname']}</div><div class='latest-msg'>Nhấp để gửi tin nhắn</div></div></div>",
            'conversation'=> "<div class='". hashId( $userData[ 'id' ] ) ." msg-list'> </div>"
        ];
        if ( ( int )$userData[ 'id' ] !== ( int )$currentUserId ) {

            // concat html
        }
    }
    // send json to client
    echo json_encode($userHtml);
} else {
    echo json_encode( [ 'error'=> 'failed to execute query' ] );
}

?>
