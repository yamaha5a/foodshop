<?php
require_once 'connection.php';

class SanPham {
    private $conn;

    public function __construct() {
        $this->conn = pdo_get_connection(); 
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' ORDER BY id DESC LIMIT 8");
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
