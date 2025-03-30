<?php
session_start();
require_once "../Models/connection.php";  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kết nối database
    $conn = pdo_get_connection(); // Hàm này cần được định nghĩa trong connection.php

    // Chuẩn bị câu lệnh SQL an toàn
    $sql = "SELECT nguoidung.*, phanquyen.tenquyen FROM nguoidung 
            JOIN phanquyen ON nguoidung.id_phanquyen = phanquyen.id 
            WHERE nguoidung.email = ? LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]); // Bind giá trị email
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra tài khoản tồn tại và kiểm tra mật khẩu hash
    if ($user && password_verify($password, $user['matkhau'])) { 
        // Lưu thông tin vào SESSION
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ten'] = $user['ten'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['hinhanh'] = $user['hinhanh'];
        $_SESSION['tenquyen'] = $user['tenquyen'];

        // Chuyển hướng theo quyền
        if ($user['tenquyen'] === 'admin') {
            header("Location: /shopfood/admin/index.php");
        } else {
            header("Location: /shopfood/user/index.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Email hoặc mật khẩu không đúng!";
        header("Location: /shopfood/admin/Views/login/login.php");
        exit();
    }
}
?>
