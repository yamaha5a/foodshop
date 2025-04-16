<?php
require_once __DIR__ . '/connection.php';

class OrderDetailModel {
    public function getAllOrders($page = 1, $limit = 10, $search = '') {
        $offset = ($page - 1) * $limit;
        $params = [];
        
        $sql = "SELECT hd.*, nd.ten as ten_nguoidung, ptt.tenphuongthuc 
                FROM hoadon hd 
                JOIN nguoidung nd ON hd.id_nguoidung = nd.id 
                LEFT JOIN phuongthucthanhtoan ptt ON hd.id_phuongthucthanhtoan = ptt.id";
        
        // Add search condition if search term is provided
        if (!empty($search)) {
            $sql .= " WHERE hd.id LIKE ? OR nd.ten LIKE ? OR hd.trangthai LIKE ?";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        $sql .= " ORDER BY hd.ngaytao DESC LIMIT ? OFFSET ?";
        
        // Convert limit and offset to integers
        $params[] = (int)$limit;
        $params[] = (int)$offset;
        
        return pdo_query($sql, ...$params);
    }
    
    public function getTotalOrders($search = '') {
        $params = [];
        
        $sql = "SELECT COUNT(*) as total 
                FROM hoadon hd 
                JOIN nguoidung nd ON hd.id_nguoidung = nd.id 
                LEFT JOIN phuongthucthanhtoan ptt ON hd.id_phuongthucthanhtoan = ptt.id";
        
        // Add search condition if search term is provided
        if (!empty($search)) {
            $sql .= " WHERE hd.id LIKE ? OR nd.ten LIKE ? OR hd.trangthai LIKE ?";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        $result = pdo_query_one($sql, ...$params);
        return $result['total'];
    }

    public function getOrderById($orderId) {
        $sql = "SELECT hd.*, nd.ten as ten_nguoidung, nd.email, nd.sodienthoai, ptt.tenphuongthuc 
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
    
    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE hoadon SET trangthai = ? WHERE id = ?";
        return pdo_execute($sql, $status, $orderId);
    }
    
} 