<?php
require_once 'connection.php';

class BannerModel {
    private $conn;

    public function __construct() {
        $this->conn = connection();
    }

    public function getAllBanners() {
        $sql = "SELECT hinhanh FROM banner";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
