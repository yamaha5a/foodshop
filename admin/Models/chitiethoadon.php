<?php
require_once __DIR__ . '/connection.php';

class OrderDetailModel {
    public function getAllOrders() {
        $sql = "SELECT hd.*, nd.ten as ten_nguoidung, ptt.tenphuongthuc 
                FROM hoadon hd 
                JOIN nguoidung nd ON hd.id_nguoidung = nd.id 
                LEFT JOIN phuongthucthanhtoan ptt ON hd.id_phuongthucthanhtoan = ptt.id 
                ORDER BY hd.ngaytao DESC";
        return pdo_query($sql);
    }

    public function getOrderById($orderId) {
        $sql = "SELECT hd.*, nd.ten as ten_nguoidung, ptt.tenphuongthuc 
                FROM hoadon hd 
                JOIN nguoidung nd ON hd.id_nguoidung = nd.id 
                LEFT JOIN phuongthucthanhtoan ptt ON hd.id_phuongthucthanhtoan = ptt.id 
                WHERE hd.id = ?";
        return pdo_query_one($sql, $orderId);
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT cthd.*, sp.tensanpham, sp.hinhanh1 
                FROM chitiethoadon cthd 
                JOIN sanpham sp ON cthd.id_sanpham = sp.id 
                WHERE cthd.id_hoadon = ?";
        return pdo_query($sql, $orderId);
    }
} 