<?php

// Kiểm tra xem session_id có được gửi qua POST hay GET
$session_id = $_POST['session_id'] ?? $_GET['session_id'] ?? null;

if ($session_id) {
    session_id($session_id);
    session_start();

    header('Content-Type: application/json; charset=UTF-8');
    $response = [];

    if (isset($_SESSION['user_id'])) {
        $response['user_id'] = $_SESSION['user_id'];
        
    } else {
        $response['error'] = 'Session không hợp lệ hoặc không có user_id.';
    }
} else {
    $response['error'] = 'Không tìm thấy session_id.';
}

echo json_encode($response);

?>
