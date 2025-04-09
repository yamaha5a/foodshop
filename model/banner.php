<?php
require_once 'connection.php';

class BannerModel {
    private $conn;

    public function __construct() {
        $this->conn = pdo_get_connection();
    }

    public function getAllBanners() {
        $sql = "SELECT hinhanh FROM banner";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
