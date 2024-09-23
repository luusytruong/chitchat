<?php

session_start();

header('Content-Type: application/json; charset=UTF-8');

if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
    echo json_encode(['login'=>'true', 'user_id'=> $_SESSION['user_id']]);
} else {
    echo json_encode(['login'=>'false']);
}

?>