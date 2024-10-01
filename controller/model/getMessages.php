<?php

include __DIR__ . '/../../model/db.php';
// include __DIR__ . '/../../model/dbHost.php';
include __DIR__ . '/userId.php';
include __DIR__ . '/idHandling.php';

$session_id = $_POST[ 'session_id' ];

$user_id = getUserId($session_id);

// $sql = 'SELECT receiver_id, message FROM messages 
//         WHERE sender_id = :sender_id ORDER BY timestamp ASC';
$sql = 'SELECT sender_id, receiver_id, message FROM messages ORDER BY timestamp ASC';
$stmt = $pdo->prepare($sql);
// $stmt->bindParam(':sender_id', $user_id);

header( 'Content-Type: application/json; charset=UTF-8' );

$response = [];

if ($stmt->execute()) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($data as $data){
        $response[] = [
            'sender_id'=> hashId($data['sender_id']),
            'receiver_id'=> hashId($data['receiver_id']),
            'message'=> $data['message']
        ];
    }
    
} else {
    $response['error'] = 'failed to execute query';
}

echo json_encode($response);

?>