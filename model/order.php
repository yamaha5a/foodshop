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
        $items = pdo_query($sql, $orderId);
        
        // Debug: Log the query and results
        error_log("SQL Query: " . $sql);
        error_log("Order ID: " . $orderId);
        error_log("Items found: " . print_r($items, true));
        
        return $items;
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

            // Debug: Log order creation
            error_log("Created order with ID: " . $orderId);
            error_log("Cart items to save: " . print_r($cartItems, true));

            // Add order items to chitiethoadon table
            foreach ($cartItems as $item) {
                $sql = "INSERT INTO chitiethoadon (id_hoadon, id_sanpham, soluong, gia) 
                        VALUES (?, ?, ?, ?)";
                pdo_execute($sql, $orderId, $item['id_sanpham'], $item['soluong'], $item['gia']);
                
                // Debug: Log each item being saved
                error_log("Saved order item: " . print_r($item, true));
            }

            // Get cart ID
            $sql = "SELECT id FROM giohang WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
            $cart = pdo_query_one($sql, $orderData['id_nguoidung']);

            if ($cart) {
                // Delete cart items
                $sql = "DELETE FROM giohang_chitiet WHERE id_giohang = ?";
                pdo_execute($sql, $cart['id']);

                // Delete cart
                $sql = "DELETE FROM giohang WHERE id = ?";
                pdo_execute($sql, $cart['id']);
            }

            // Commit transaction
            pdo_execute("COMMIT");
            return $orderId;
        } catch (Exception $e) {
            // Rollback transaction on error
            pdo_execute("ROLLBACK");
            error_log("Error creating order: " . $e->getMessage());
            throw $e;
        }
    }
} 