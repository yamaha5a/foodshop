<?php
require_once 'connection.php';

class SanPham {
    private $conn;

    public function __construct() {
        $this->conn = connection(); 
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng'");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
