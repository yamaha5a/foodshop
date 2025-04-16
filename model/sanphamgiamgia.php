<?php
require_once 'connection.php';

class SanPhamGiamGia
{
    private $conn;

    public function __construct()
    {
        $this->conn = pdo_get_connection();
    }

    // Lấy tất cả sản phẩm giảm giá
    public function getAll()
    {
        $stmt = $this->conn->prepare("
            SELECT sp.*, spg.giagiam, spg.ngay_giamgia 
            FROM sanphamgiamgia spg
            JOIN sanpham sp ON spg.id_sanpham = sp.id
            WHERE sp.trangthai = 'Còn hàng'
            ORDER BY spg.ngay_giamgia DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm giảm giá theo giới hạn
    public function getSanPhamGiamGiaByLimit($limit)
    {
        $stmt = $this->conn->prepare("
            SELECT sp.*, spg.giagiam, spg.ngay_giamgia 
            FROM sanphamgiamgia spg
            JOIN sanpham sp ON spg.id_sanpham = sp.id
            WHERE sp.trangthai = 'Còn hàng'
            ORDER BY spg.ngay_giamgia DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm giảm giá theo ID
    public function getSanPhamGiamGiaById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT sp.*, spg.giagiam, spg.ngay_giamgia 
            FROM sanphamgiamgia spg
            JOIN sanpham sp ON spg.id_sanpham = sp.id
            WHERE spg.id = :id AND sp.trangthai = 'Còn hàng'
        ");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm giảm giá
    public function addSanPhamGiamGia($id_sanpham, $giagiam, $ngay_giamgia = null)
    {
        if ($ngay_giamgia === null) {
            $ngay_giamgia = date('Y-m-d');
        }
        
        $stmt = $this->conn->prepare("
            INSERT INTO sanphamgiamgia (id_sanpham, giagiam, ngay_giamgia)
            VALUES (:id_sanpham, :giagiam, :ngay_giamgia)
        ");
        $stmt->bindValue(':id_sanpham', (int)$id_sanpham, PDO::PARAM_INT);
        $stmt->bindValue(':giagiam', (float)$giagiam, PDO::PARAM_STR);
        $stmt->bindValue(':ngay_giamgia', $ngay_giamgia, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Cập nhật sản phẩm giảm giá
    public function updateSanPhamGiamGia($id, $giagiam, $ngay_giamgia)
    {
        $stmt = $this->conn->prepare("
            UPDATE sanphamgiamgia
            SET giagiam = :giagiam, ngay_giamgia = :ngay_giamgia
            WHERE id = :id
        ");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->bindValue(':giagiam', (float)$giagiam, PDO::PARAM_STR);
        $stmt->bindValue(':ngay_giamgia', $ngay_giamgia, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Xóa sản phẩm giảm giá
    public function deleteSanPhamGiamGia($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM sanphamgiamgia WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
} 