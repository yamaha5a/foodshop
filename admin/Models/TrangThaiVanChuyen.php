<?php
require_once __DIR__ . '/connection.php';

class TrangThaiVanChuyen {
    public function layDanhSachDonHang() {
        $sql = "SELECT h.id, h.ngaytao, h.trangthai, h.tongtien, n.ten as ten_nguoidung 
                FROM hoadon h 
                JOIN nguoidung n ON h.id_nguoidung = n.id 
                ORDER BY h.ngaytao DESC";
        return pdo_query($sql);
    }

    public function capNhatTrangThai($id_hoadon, $trangthai_moi) {
        $sql = "UPDATE hoadon SET trangthai = ? WHERE id = ?";
        try {
            pdo_execute($sql, $trangthai_moi, $id_hoadon);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function layChiTietDonHang($id_hoadon) {
        $sql = "SELECT h.*, n.ten as ten_nguoidung, n.sodienthoai, n.diachi 
                FROM hoadon h 
                JOIN nguoidung n ON h.id_nguoidung = n.id 
                WHERE h.id = ?";
        return pdo_query_one($sql, $id_hoadon);
    }
} 