<?php
require_once 'connection.php';

class SanPham {
    public static function getAllProducts() {
        $db = pdo_get_connection();
        $query = "SELECT * FROM sanpham WHERE trangthai = 'Còn hàng'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
