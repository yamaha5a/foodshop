<?php
require_once 'connection.php';

class OrderModel {
    public function getOrders($userId) {
        $sql = "SELECT hd.*, ptt.tenphuongthuc 
                FROM hoadon hd 
                LEFT JOIN phuongthucthanhtoan ptt ON hd.id_phuongthucthanhtoan = ptt.id 
                WHERE hd.id_nguoidung = ? 
                ORDER BY hd.ngaytao DESC";
        return pdo_query($sql, $userId);
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT cthd.*, sp.tensanpham, sp.hinhanh1 
                FROM chitiethoadon cthd 
                JOIN sanpham sp ON cthd.id_sanpham = sp.id 
                WHERE cthd.id_hoadon = ?";
        return pdo_query($sql, $orderId);
    }

    public function getOrderById($orderId, $userId) {
        $sql = "SELECT hd.*, ptt.tenphuongthuc 
                FROM hoadon hd 
                LEFT JOIN phuongthucthanhtoan ptt ON hd.id_phuongthucthanhtoan = ptt.id 
                WHERE hd.id = ? AND hd.id_nguoidung = ?";
        return pdo_query_one($sql, $orderId, $userId);
    }

    public function createOrder($orderData, $cartItems) {
        // Start transaction
        pdo_execute("START TRANSACTION");

        try {
            // Create order in hoadon table
            $sql = "INSERT INTO hoadon (id_nguoidung, diachigiaohang, tongtien, trangthai, ghichu, id_phuongthucthanhtoan) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            pdo_execute($sql, 
                $orderData['id_nguoidung'],
                $orderData['diachigiaohang'],
                $orderData['tongtien'],
                $orderData['trangthai'],
                $orderData['ghichu'],
                $orderData['id_phuongthucthanhtoan']
            );
            
            $orderId = pdo_last_insert_id();

            // Add order items to chitiethoadon table
            foreach ($cartItems as $item) {
                $sql = "INSERT INTO chitiethoadon (id_hoadon, id_sanpham, soluong, gia) 
                        VALUES (?, ?, ?, ?)";
                pdo_execute($sql, $orderId, $item['id_sanpham'], $item['soluong'], $item['gia']);
            }

            // Update cart status
            $sql = "UPDATE giohang SET trangthai = 'Đã đặt' WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
            pdo_execute($sql, $orderData['id_nguoidung']);

            // Commit transaction
            pdo_execute("COMMIT");
            return $orderId;
        } catch (Exception $e) {
            // Rollback transaction on error
            pdo_execute("ROLLBACK");
            throw $e;
        }
    }
} 