<?php
// Kết nối đến cơ sở dữ liệu
include __DIR__ . '/model/db.php'; // Đảm bảo bạn đã có tệp db.php với kết nối cơ sở dữ liệu

// Khởi tạo biến
$fullname = $email = $password = "";
$errors = [];

// Xử lý form khi người dùng gửi dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Kiểm tra thông tin
    if (empty($fullname)) {
        $errors[] = "Fullname is required.";

    } else {
        if (empty($email)) {
            $errors[] = "Email is required.";

        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";

        } else {
            if (empty($password)) {
                $errors[] = "Password is required.";

            } elseif (strlen($password) < 6) {
                $errors[] = "Password must be at least 6 characters.";
            }
        }
    }



    // Nếu không có lỗi, thực hiện đăng ký
    if (empty($errors)) {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Lưu thông tin vào cơ sở dữ liệu
        $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Đóng statement
        $stmt->close();
    }
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html dir="ltr" lang="vn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./view/img/chat.png" type="image/x-icon">
    <title>ChitChat - Đăng ký tài khoản</title>
    <link rel="stylesheet" href="./asset/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

<body>
    <?php
    // Hiển thị lỗi nếu có
    if (!empty($errors)) {
        echo '<div style="color: red;">';
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '</div>';
    }
    ?>
    <div id="toast" class="toast">
        <div class="toast-icon">
            <i class="fa-solid fa-circle-question"></i>
            <!-- <i class="fa-solid fa-circle-check"></i> -->
            <!-- <i class="fa-solid fa-circle-exclamation"></i> -->
        </div>
        <div class="toast-info">
            <div class="toast-title">
                Đăng nhập thành công
            </div>
            <div class="toast-content">
                Chuyển trang sau 3s!
            </div>
        </div>
        <div class="cooldown"></div>
    </div>
    <div class="container-register">
        <div class="wrapper">
            <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <img src="./view/img/chat.png" alt="realtime chat logo">
                <div class="box-input">
                    <label for="fullname">
                        Họ và tên
                    </label>
                    <div>
                        <i class="fa-solid fa-user"></i>
                        <input tabindex="1" id="fullname" name="fullname" type="text" placeholder="nguyen van a"
                            required title="Nhập Họ và tên của bạn" value="<?php echo htmlspecialchars($fullname); ?>">
                    </div>
                </div>
                <div class="box-input">
                    <label id="test" for="email">
                        Địa chỉ email
                    </label>
                    <div>
                        <i class="fa-solid fa-envelope"></i>
                        <input tabindex="2" id="email" name="email" type="text" placeholder="example@gmail.com" required
                            title="Nhập địa chỉ email của bạn" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                </div>
                <div class="box-input">
                    <label for="password">
                        Mật khẩu
                    </label>
                    <div>
                        <i class="fa-solid fa-lock"></i>
                        <input tabindex="3" id="password" name="password" type="password" placeholder="mật khẩu"
                            required title="Nhập vào mật khẩu">
                        <i class="fa-solid fa-eye" tabindex="4"></i>
                    </div>
                    <div>
                        <i class="fa-solid fa-lock"></i>
                        <input tabindex="5" id="repeat-password" name="repeat-password" type="password"
                            placeholder="nhập lại mật khẩu" required title="Nhập lại mật khẩu ở trên">
                    </div>
                </div>
                <button tabindex="6" type="submit">
                    Đăng ký
                </button>
                <div class="option">
                    <a tabindex="7" href="./login.html">Đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
    <section></section>
    <script src="./asset/js/actionPassword.js"></script>
    <!-- <script type="module" src="./asset/js/register.js"></script> -->
</body>

</html>