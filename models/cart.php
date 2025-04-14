<?php

class Cart {
    public function getCartItems($userId) {
        $sql = "SELECT c.*, s.tensanpham, s.gia, s.hinhanh1 
                FROM giohang c 
                JOIN sanpham s ON c.id_sanpham = s.id 
                WHERE c.id_nguoidung = ?";
        return pdo_query($sql, $userId);
    }
} 