<?php
session_start();
require_once __DIR__ . '/../Models/connection.php'; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        header("Location: ../Views/login.php?error=Vui lòng nhập đầy đủ thông tin");
        exit();
    }

    // Truy vấn lấy thông tin người dùng
    $sql = "SELECT * FROM nguoidung WHERE email = ?";
    $user = pdo_query_one($sql, $email);

    if ($user) {
        if ($password == $user['matkhau']) { // Kiểm tra mật khẩu
            $_SESSION['user_id'] = $user['id']; // 🔥 Gán user_id vào session
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['hoten'];

            header("Location: ../index.php"); // Đăng nhập thành công, chuyển về trang admin
            exit();
        }
    }

    header("Location: ../Views/login.php?error=Email hoặc mật khẩu không đúng");
    exit();
}
?>
