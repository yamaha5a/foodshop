<?php
session_start();
session_unset();
session_destroy();
session_start();
$_SESSION['logout_message'] = "Bạn đã đăng xuất thành công!";
header("Location: /shopfood/admin/Views/login/login.php");
exit();
?>
