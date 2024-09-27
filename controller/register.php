<?php

// connect to the database
include __DIR__ . '/../model/db.php';

header('Content-Type: application/json; charset=UTF-8');

// create variables
$fullname = $email = $password = $repeat_password = ' ';

// check method from client
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $repeat_password = trim($_POST['repeat_password']);

    // validate input
    if (empty($fullname)) {
        echo json_encode(['status' => 'error', 'title' => 'Bạn chưa nhập họ tên', 'content' => 'Vui lòng nhập họ và tên']);
        exit;
    }

    if (empty($email)) {
        echo json_encode(['status' => 'error', 'title' => 'Bạn chưa nhập email', 'content' => 'Vui lòng nhập email']);
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'title' => 'Email không hợp lệ', 'content' => 'Vui lòng nhập lại email']);
        exit;
    }

    if (empty($password)) {
        echo json_encode(['status' => 'error', 'title' => 'Bạn chưa nhập mật khẩu', 'content' => 'Vui lòng nhập mật khẩu']);
        exit;
    } elseif (strlen($password) < 6) {
        echo json_encode(['status' => 'error', 'title' => 'Mật khẩu quá ngắn', 'content' => 'Vui lòng dùng mật khẩu mạnh hơn']);
        exit;
    }

    if ($password !== $repeat_password) {
        echo json_encode(['status' => 'error', 'title' => 'Mật khẩu không khớp', 'content' => 'Vui lòng xác nhận lại mật khẩu']);
        exit;
    }

    try {

        // check if email already exists
        $sql = 'SELECT email FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'title' => 'Email đã tồn tại', 'content' => 'Vui lòng thử một email khác']);
            exit;
        }

        // start registration
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        // save info to DB
        $sql = 'INSERT INTO users(fullname, email, password) VALUES (:fullname, :email, :password)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash_password);

        if ($stmt->execute()) {
            // get user_id in stmt
            $user_id = $pdo->lastInsertId();

            // create default status for user_id
            $sql = 'INSERT INTO status (user_id) VALUE (:user_id)';
            $status_stmt = $pdo->prepare($sql);
            $status_stmt->bindParam(':user_id', $user_id);
            $status_stmt->execute();

            echo json_encode(['status' => 'success', 'title' => 'Đăng ký thành công', 'content' => 'Bạn sẽ được chuyển trang', 'redirect' => 'login.html']);
            exit;

        } else {
            echo json_encode(['status' => 'error', 'title' => 'Đăng ký thất bại', 'content' => 'Vui lòng thử lại sau']);
            exit;
        }
    } catch (PDOException $e) {
        
        echo json_encode(['status' => 'error', 'title' => 'Lỗi hệ thống', 'content' => $e->getMessage()]);
        exit;
    }

}
?>