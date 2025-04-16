<?php
require_once 'connection.php';

class KhuyenMaiModel {
    private $conn;

    public function __construct() {
        $this->conn = pdo_get_connection();
    }

    public function getDiscountByCode($code) {
        $stmt = $this->conn->prepare("SELECT * FROM khuyenmai WHERE makm = :code AND trangthai = 'Hoạt động'");
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllDiscounts() {
        $stmt = $this->conn->prepare("SELECT * FROM khuyenmai ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addDiscount($data) {
        $stmt = $this->conn->prepare("INSERT INTO khuyenmai (makm, tenkm, giatrigiam, ngaybatdau, ngayketthuc, trangthai) 
                VALUES (:makm, :tenkm, :giatrigiam, :ngaybatdau, :ngayketthuc, :trangthai)");
        $stmt->bindValue(':makm', $data['makm'], PDO::PARAM_STR);
        $stmt->bindValue(':tenkm', $data['tenkm'], PDO::PARAM_STR);
        $stmt->bindValue(':giatrigiam', $data['giatrigiam'], PDO::PARAM_STR);
        $stmt->bindValue(':ngaybatdau', $data['ngaybatdau'], PDO::PARAM_STR);
        $stmt->bindValue(':ngayketthuc', $data['ngayketthuc'], PDO::PARAM_STR);
        $stmt->bindValue(':trangthai', $data['trangthai'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateDiscount($id, $data) {
        $stmt = $this->conn->prepare("UPDATE khuyenmai 
                SET makm = :makm, 
                    tenkm = :tenkm, 
                    giatrigiam = :giatrigiam, 
                    ngaybatdau = :ngaybatdau, 
                    ngayketthuc = :ngayketthuc, 
                    trangthai = :trangthai 
                WHERE id = :id");
        $stmt->bindValue(':makm', $data['makm'], PDO::PARAM_STR);
        $stmt->bindValue(':tenkm', $data['tenkm'], PDO::PARAM_STR);
        $stmt->bindValue(':giatrigiam', $data['giatrigiam'], PDO::PARAM_STR);
        $stmt->bindValue(':ngaybatdau', $data['ngaybatdau'], PDO::PARAM_STR);
        $stmt->bindValue(':ngayketthuc', $data['ngayketthuc'], PDO::PARAM_STR);
        $stmt->bindValue(':trangthai', $data['trangthai'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteDiscount($id) {
        $stmt = $this->conn->prepare("DELETE FROM khuyenmai WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getActiveDiscounts() {
        $currentDate = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT * FROM khuyenmai 
                WHERE trangthai = 'Hoạt động' 
                AND :currentDate BETWEEN ngaybatdau AND ngayketthuc");
        $stmt->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?> 