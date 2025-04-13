<?php
require_once 'connection.php';

class SanPham
{
    private $conn;

    public function __construct()
    {
        $this->conn = pdo_get_connection();
    }

    public function get8sp()
    {
        $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' ORDER BY id DESC LIMIT 8");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng'");

        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  // Lấy sản phẩm theo phân trang
public function getSanPhamByPage($start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' ORDER BY id DESC LIMIT :start, :limit");
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Đếm tổng số sản phẩm
public function countAllSanPham()
{
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM sanpham WHERE trangthai = 'Còn hàng'");
    $stmt->execute();
    return $stmt->fetchColumn();
}
public function getSanPhamByDanhMuc($idDanhMuc, $start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' AND id_danhmuc = :id_danhmuc ORDER BY id DESC LIMIT :start, :limit");
    $stmt->bindValue(':id_danhmuc', (int)$idDanhMuc, PDO::PARAM_INT);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countSanPhamByDanhMuc($idDanhMuc)
{
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM sanpham WHERE trangthai = 'Còn hàng' AND id_danhmuc = :id_danhmuc");
    $stmt->bindValue(':id_danhmuc', (int)$idDanhMuc, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}



}
