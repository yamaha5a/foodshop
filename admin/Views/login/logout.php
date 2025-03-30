<?php
session_start();
session_unset();
session_destroy();

// Lưu thông báo vào session trước khi chuyển hướng
session_start();
$_SESSION['logout_message'] = "Bạn đã đăng xuất thành công!";
header("Location: /shopfood/admin/Views/login/login.php");
exit();
?>
