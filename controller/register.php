<?php

// connect to the database
include __DIR__ . '/../model/db.php';

// create variables
$fullname = $email = $password = $repeat_password = ' ';
$errors = [];

// check method from client
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $repeat_password = trim($_POST['repeat_password']);

    // validate input
    if (empty($fullname)) {
        echo json_encode(['status' => 'error', 'title' => 'Bạn chưa nhập họ tên', 'content' => 'Vui lòng nhập họ và tên'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (empty($email)) {
        echo json_encode(['status' => 'error', 'title' => 'Bạn chưa nhập email', 'content' => 'Vui lòng nhập email'], JSON_UNESCAPED_UNICODE);
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'title' => 'Email không hợp lệ', 'content' => 'Vui lòng nhập lại email'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (empty($password)) {
        echo json_encode(['status' => 'error', 'title' => 'Bạn chưa nhập mật khẩu', 'content' => 'Vui lòng nhập mật khẩu'], JSON_UNESCAPED_UNICODE);
        exit;
    } elseif (strlen($password) < 6) {
        echo json_encode(['status' => 'error', 'title' => 'Mật khẩu quá ngắn', 'content' => 'Vui lòng dùng mật khẩu mạnh hơn'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($password !== $repeat_password) {
        echo json_encode(['status' => 'error', 'title' => 'Mật khẩu không khớp', 'content' => 'Vui lòng nhập lại mật khẩu'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // check if email already exists
    $sql = 'SELECT email FROM users WHERE email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'error', 'title' => 'Email đã tồn tại', 'content' => 'Vui lòng thử một email khác'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // start registration
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    
    // save info to DB
    $sql = 'INSERT INTO users(fullname, email, password) VALUES (?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $fullname, $email, $hash_password);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'title' => 'Đăng ký thành công', 'content' => 'Chúc bạn có trải nghiệm vui vẻ'], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['status' => 'error', 'title' => 'Đăng ký thất bại', 'content' => 'Vui lòng thử lại sau'], JSON_UNESCAPED_UNICODE);
    }

    $stmt->close();
}
?>