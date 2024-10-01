<?php

function addData($sender_id, $data) {
    $addData = [
        'sender_id' => $sender_id,
        'receiver_id' => $data['receiver_id'],
        'group_id' => $data['group_id'],
        'message' => $data['msg']
    ];
    return json_encode($addData);
}

?>