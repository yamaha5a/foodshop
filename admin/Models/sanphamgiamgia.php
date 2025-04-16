<?php
require_once 'connection.php';

class SanPhamGiamGiaModel {
    public function getAllSanPhamGiamGia($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT spg.*, sp.tensanpham, sp.gia as gia_goc 
                FROM sanphamgiamgia spg 
                JOIN sanpham sp ON spg.id_sanpham = sp.id 
                ORDER BY spg.ngay_giamgia DESC 
                LIMIT ? OFFSET ?";
                
        return pdo_query($sql, (int)$limit, (int)$offset);
    }

    public function getTotalSanPhamGiamGia() {
        $sql = "SELECT COUNT(*) as total FROM sanphamgiamgia";
        $result = pdo_query_one($sql);
        return $result['total'];
    }

    public function getSanPhamGiamGiaById($id) {
        $sql = "SELECT spg.*, sp.tensanpham, sp.gia as gia_goc 
                FROM sanphamgiamgia spg 
                JOIN sanpham sp ON spg.id_sanpham = sp.id 
                WHERE spg.id = ?";
        $result = pdo_query($sql, $id);
        return $result ? $result[0] : null;
    }

    public function addSanPhamGiamGia($id_sanpham, $giagiam, $ngay_giamgia) {
        $sql = "INSERT INTO sanphamgiamgia (id_sanpham, giagiam, ngay_giamgia) VALUES (?, ?, ?)";
        return pdo_execute($sql, $id_sanpham, $giagiam, $ngay_giamgia);
    }

    public function updateSanPhamGiamGia($id, $id_sanpham, $giagiam, $ngay_giamgia) {
        $sql = "UPDATE sanphamgiamgia SET id_sanpham = ?, giagiam = ?, ngay_giamgia = ? WHERE id = ?";
        return pdo_execute($sql, $id_sanpham, $giagiam, $ngay_giamgia, $id);
    }

    public function deleteSanPhamGiamGia($id) {
        $sql = "DELETE FROM sanphamgiamgia WHERE id = ?";
        return pdo_execute($sql, $id);
    }
    
    public function getAllSanPham() {
        $sql = "SELECT id, tensanpham, gia, hinhanh1, mota FROM sanpham ORDER BY tensanpham ASC";
        return pdo_query($sql);
    }
}