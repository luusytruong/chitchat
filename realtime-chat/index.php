<?php
// Xác định đường dẫn đến thư mục view
$viewPath = __DIR__ . '/view/index.html';

// Kiểm tra xem file index.html có tồn tại không
if (file_exists($viewPath)) {
    // Đọc nội dung của file index.html
    echo file_get_contents($viewPath);
} else {
    // Nếu không tìm thấy, trả về lỗi 404
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
}