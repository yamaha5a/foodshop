<?php
require_once 'connection.php';

class danhMuc
{
    private $conn;

    public function __construct()
    {
        $this->conn = pdo_get_connection();
    }
    public function getAllDanhMuc()
    {

        $sql = "SELECT danhmuc.id, danhmuc.tendanhmuc, COUNT(sanpham.id) AS soluong
    FROM danhmuc
    LEFT JOIN sanpham ON sanpham.id_danhmuc = danhmuc.id
    GROUP BY danhmuc.id, danhmuc.tendanhmuc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
