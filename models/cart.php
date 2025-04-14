<?php

class Cart {
    public function getCartItems($userId) {
        $sql = "SELECT gct.*, sp.tensanpham, sp.gia, sp.hinhanh1 
                FROM giohang_chitiet gct 
                JOIN sanpham sp ON gct.id_sanpham = sp.id 
                JOIN giohang g ON gct.id_giohang = g.id 
                WHERE g.id_nguoidung = ? AND g.trangthai = 'Chưa đặt'";
        return pdo_query($sql, $userId);
    }
} 