<?php
require_once 'connection.php'; // Kết nối với cơ sở dữ liệu

class SanPhamModel {
    
    public function layTatCaSanPham($kyw = '', $iddm = 0, $limit = 5, $offset = 0) {
        $sql = "SELECT sp.*, dm.tendanhmuc 
                FROM sanpham sp 
                JOIN danhmuc dm ON sp.id_danhmuc = dm.id 
                WHERE 1";
    
        $params = [];
    
        if (!empty($kyw)) {
            $sql .= " AND sp.tensanpham LIKE ?";
            $params[] = "%$kyw%";
        }
    
        if ($iddm > 0) {
            $sql .= " AND sp.id_danhmuc = ?";
            $params[] = $iddm;
        }
    
        $sql .= " ORDER BY sp.id DESC LIMIT $limit OFFSET $offset";
    
        return pdo_query($sql, ...$params);
    }
    public function demSanPham($kyw = '', $iddm = 0) {
        $sql = "SELECT COUNT(*) FROM sanpham sp WHERE 1";
        $params = [];
    
        if (!empty($kyw)) {
            $sql .= " AND sp.tensanpham LIKE ?";
            $params[] = "%$kyw%";
        }
    
        if ($iddm > 0) {
            $sql .= " AND sp.id_danhmuc = ?";
            $params[] = $iddm;
        }
    
        return (int) pdo_query_value($sql, ...$params);
    }
    
    
    // Thêm sản phẩm
    public function themSanPham($tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc) {
        $trangthai = ($soluong > 0) ? 'Còn hàng' : 'Hết hàng';
        $sql = "INSERT INTO sanpham (tensanpham, mota, gia, soluong, hinhanh1, hinhanh2, hinhanh3, id_danhmuc, trangthai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $trangthai);
    }

    // Lấy sản phẩm theo ID
    public function laySanPhamTheoID($id) {
        $sql = "SELECT * FROM sanpham WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // Cập nhật sản phẩm
    public function capNhatSanPham($id, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc) {
        $trangthai = ($soluong > 0) ? 'Còn hàng' : 'Hết hàng';

        $sql = "UPDATE sanpham SET tensanpham = ?, mota = ?, gia = ?, soluong = ?, hinhanh1 = ?, hinhanh2 = ?, hinhanh3 = ?, id_danhmuc = ?, trangthai = ? WHERE id = ?";
        pdo_execute($sql, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $trangthai, $id);
    }

    // Xóa sản phẩm
    public function xoaSanPham($id) {
        $sql = "DELETE FROM sanpham WHERE id = ?";
        pdo_execute($sql, $id);
    }
}
?>