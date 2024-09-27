<?php

session_start();
session_unset();
session_destroy();
$_SESSION = [];

// Xóa cookie chứa session ID
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

header('Content-Type: application/json; charset=UTF-8');

if (isset($_SESSION['user_id']) || isset($_SESSION['email'])){
    echo json_encode(['status'=>'error', 'title'=>'Đăng xuất thất bại', 'content'=>'Có lỗi xảy ra, thử lại sau']);
    exit;
} else {
    echo json_encode(['status'=>'success', 'title'=>'Đăng xuất thành công', 'content'=>'Bạn sẽ được chuyển trang', 'redirect'=>'login.html']);
    exit;
}

?>
