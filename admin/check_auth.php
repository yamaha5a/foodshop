<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['tenquyen'] !== 'admin') {
    header("Location: /shopfood/admin/Views/login/login.php");
    exit();
}
?> 