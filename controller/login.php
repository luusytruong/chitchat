<?php
include __DIR__ . '/../model/db.php';

session_start();

header('Content-Type: application/json; charset=UTF-8');

$email = $password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        echo json_encode(['status' => 'error', 'title' => 'Email không được để trống', 'content' => 'Vui lòng nhập địa chỉ email']);
        exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'title' => 'Email không hợp lệ', 'content' => 'Vui lòng nhập lại email']);
        exit;
    }
    if (empty($password)) {
        echo json_encode(['status' => 'error', 'title' => 'Mật khẩu không được để trống', 'content' => 'Vui lòng nhập mật khẩu']);
        exit;
    } else if (strlen($password) < 6) {
        echo json_encode(['status' => 'error', 'title' => 'Mật khẩu không hợp lệ', 'content' => 'Vui lòng nhập lại mật khẩu']);
        exit;
    }



    $sql = 'SELECT id, password FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $stmt->bindColumn(1, $id);
            $stmt->bindColumn(2, $hash_password);
            $stmt->fetchAll(PDO::FETCH_BOUND);

            if (password_verify($password, $hash_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['email'] = $email;

                echo json_encode([
                    'status' => 'success',
                    'title' => 'Đăng nhập thành công',
                    'content' => 'Bạn sẽ được chuyển trang',
                    'redirect' => 'http://localhost/chitchat',
                    'session_id' => session_id()
                ]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'title' => 'Mật khẩu không đúng', 'content' => 'Vui lòng thử lại']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'title' => 'Email không tồn tại', 'content' => 'Vui lòng thử lại']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'title' => 'Lỗi hệ thống', 'content' => 'Vui lòng thử lại sau']);
    }
}

$conn->close();

?>