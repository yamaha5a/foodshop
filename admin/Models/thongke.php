<?php
require_once "connection.php";

class ThongKe {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function demTongTaiKhoan() {
        $sql = "SELECT COUNT(*) AS total_users FROM nguoidung";
        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total_users'];
    }
    
}
?>
