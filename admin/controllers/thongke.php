<?php
require_once "../models/connection.php";
require_once "../models/ThongKe.php";

// Khởi tạo model thống kê
$thongKeModel = new ThongKe($conn);

$total_users = $thongKeModel->demTongTaiKhoan();

?>
