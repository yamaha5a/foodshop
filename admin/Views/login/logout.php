<?php
session_start();
session_unset();
session_destroy();

// Hiển thị thông báo rồi chuyển hướng
echo "<script>
    alert('Bạn đã đăng xuất thành công!');
    window.location.href = '/shopfood/admin/Views/login/login.php';
</script>";
exit();
?>
