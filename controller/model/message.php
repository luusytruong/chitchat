<?php

include __DIR__ . '/../../model/db.php';
include __DIR__ . '/verifyId.php';

function saveMessage($pdo, $data, $user_id){

    if (isset($data['type']) && $data['type'] === 'message') {
        
        $sql = 'SELECT id FROM users ORDER BY id ASC';
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute()){
            $userId = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($userId as $userId){
                if (verifyId($userId['id'], $data['receiver_id'])) {
                    $receiver_id = $userId['id'];
                    
                    $sql = 'INSERT INTO messages (sender_id, receiver_id, group_id, message)
                            VALUES (:sender_id, :receiver_id, :group_id, :message)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':sender_id', $user_id);
                    $stmt->bindParam(':receiver_id', $receiver_id);
                    $stmt->bindParam(':group_id', $data['group_id']);
                    $stmt->bindParam(':message', $data['msg']);

                    echo json_encode(['type'=>'success', 'sender_id'=> $user_id, 'receiver_id'=>$receiver_id, 'msg' => $data['msg']]) . "\n";
                    
                    if ($stmt->execute()) {
                        echo "message saved successfully!\n";
                    } else {
                        echo "failed to save message!\n";
                    }

                }
            }
        } else {
            echo "failed to execute query!\n";
        }
        
    } else {
        echo "invalid message type!\n";
    }
}

function getMessages() {
    
}

?>