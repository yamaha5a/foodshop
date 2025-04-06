<?php
session_start();
require_once "../Models/login.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = login($email, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ten'] = $user['ten'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['hinhanh'] = $user['hinhanh'];
        $_SESSION['tenquyen'] = $user['tenquyen'];

        if ($user['tenquyen'] === 'admin') {
            header("Location: /shopfood/admin/index.php");
        } else {
            header("Location: /shopfood/index.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Email hoặc mật khẩu không đúng!";
        header("Location: /shopfood/admin/Views/login/login.php");
        exit();
    }
}
