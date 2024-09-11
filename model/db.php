<?php
// db_connect.php

$servername = "localhost"; // Địa chỉ máy chủ MySQL
$username = "root";         // Tên người dùng MySQL
$password = "";             // Mật khẩu người dùng MySQL
$dbname = "realtime_chat_db";  // Tên cơ sở dữ liệu

// Kết nối đến MySQL
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    // die("Connection error: " . mysqli_connect_error());
    echo ("<h1>Database not connection!</h1>");
}
?>