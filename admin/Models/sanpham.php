<?php
require_once 'connection.php'; // Kết nối với cơ sở dữ liệu

class SanPhamModel {
    // Lấy danh sách sản phẩm
    public function layTatCaSanPham() {
        $sql = "SELECT * FROM sanpham";
        return pdo_query($sql);
    }

    // Thêm sản phẩm
    public function themSanPham($tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $trangthai) {
        $sql = "INSERT INTO sanpham (tensanpham, mota, gia, soluong, hinhanh1, hinhanh2, hinhanh3, id_danhmuc, id_loaisanpham, trangthai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $trangthai);
    }

    // Lấy sản phẩm theo ID
    public function laySanPhamTheoID($id) {
        $sql = "SELECT * FROM sanpham WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // Cập nhật sản phẩm
    public function capNhatSanPham($id, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $trangthai) {
        $sql = "UPDATE sanpham SET tensanpham = ?, mota = ?, gia = ?, soluong = ?, hinhanh1 = ?, hinhanh2 = ?, hinhanh3 = ?, id_danhmuc = ?, id_loaisanpham = ?, trangthai = ? WHERE id = ?";
        pdo_execute($sql, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $trangthai, $id);
    }

    // Xóa sản phẩm
    public function xoaSanPham($id) {
        $sql = "DELETE FROM sanpham WHERE id = ?";
        pdo_execute($sql, $id);
    }
}
?>
