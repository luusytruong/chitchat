<?php

function convertTimestamp($timestamp) {
    // Chuyển đổi timestamp thành đối tượng DateTime
    $date = new DateTime($timestamp);
    $now = new DateTime();
    
    // Kiểm tra nếu là ngày hiện tại
    if ($date->format('Y-m-d') == $now->format('Y-m-d')) {
        return 'Hôm nay lúc ' . $date->format('H:i:s');
    }
    
    // Kiểm tra nếu thuộc tuần hiện tại
    $weekStart = (clone $now)->modify('this week');
    $weekEnd = (clone $weekStart)->modify('+6 days');
    
    if ($date >= $weekStart && $date <= $weekEnd) {
        $days = [
            'Monday' => 'Thứ Hai',
            'Tuesday' => 'Thứ Ba',
            'Wednesday' => 'Thứ Tư',
            'Thursday' => 'Thứ Năm',
            'Friday' => 'Thứ Sáu',
            'Saturday' => 'Thứ Bảy',
            'Sunday' => 'Chủ Nhật'
        ];
        
        $dayOfWeek = $days[$date->format('l')];
        return $dayOfWeek . ' lúc ' . $date->format('H:i:s');
    }
    
    // Định dạng ngày thành chữ và giờ vẫn là số
    $formattedDate = $date->format('l, d F Y H:i:s');
    
    // Chuyển đổi ngày sang tiếng Việt
    $days = [
        'Monday' => 'Thứ Hai',
        'Tuesday' => 'Thứ Ba',
        'Wednesday' => 'Thứ Tư',
        'Thursday' => 'Thứ Năm',
        'Friday' => 'Thứ Sáu',
        'Saturday' => 'Thứ Bảy',
        'Sunday' => 'Chủ Nhật'
    ];
    
    $months = [
        'January' => 'Tháng Một',
        'February' => 'Tháng Hai',
        'March' => 'Tháng Ba',
        'April' => 'Tháng Tư',
        'May' => 'Tháng Năm',
        'June' => 'Tháng Sáu',
        'July' => 'Tháng Bảy',
        'August' => 'Tháng Tám',
        'September' => 'Tháng Chín',
        'October' => 'Tháng Mười',
        'November' => 'Tháng Mười Một',
        'December' => 'Tháng Mười Hai'
    ];
    
    // Thay thế ngày và tháng bằng tiếng Việt
    $formattedDate = str_replace(array_keys($days), array_values($days), $formattedDate);
    $formattedDate = str_replace(array_keys($months), array_values($months), $formattedDate);
    
    return $formattedDate;
}

// Ví dụ sử dụng
$timestamp = '2024-10-01 03:28:30';
echo convertTimestamp($timestamp);


?>