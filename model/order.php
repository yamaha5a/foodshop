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
    $sql = "SELECT cthd.*, sp.tensanpham, sp.hinhanh1, sp.gia 
            FROM chitiethoadon cthd 
            JOIN sanpham sp ON cthd.id_sanpham = sp.id 
            WHERE cthd.id_hoadon = ?";
    
    $items = pdo_query($sql, $orderId);
    
    return $items;
}

    public function getOrderById($orderId, $userId) {
        $sql = "SELECT hd.*, ptt.tenphuongthuc 
                FROM hoadon hd 
                LEFT JOIN phuongthucthanhtoan ptt ON hd.id_phuongthucthanhtoan = ptt.id 
                WHERE hd.id = ? AND hd.id_nguoidung = ?";
        return pdo_query_one($sql, $orderId, $userId);
    }

    public function getPaymentMethods() {
        $sql = "SELECT * FROM phuongthucthanhtoan";
        return pdo_query($sql);
    }

    public function clearCart($userId) {
        try {
            // Get cart ID
            $sql = "SELECT id FROM giohang WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
            $cart = pdo_query_one($sql, $userId);
            
            if (!$cart) {
                return true; // No cart exists
            }
    
            $cartId = $cart['id'];
    
            // Delete cart items
            $sql = "DELETE FROM giohang_chitiet WHERE id_giohang = ?";
            pdo_execute($sql, $cartId);
    
            // Delete cart
            $sql = "DELETE FROM giohang WHERE id = ?";
            pdo_execute($sql, $cartId);
    
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    

    public function createOrder($orderData, $cartItems) {
        try {
            // Start transaction
            pdo_execute("START TRANSACTION");
    
            // Insert into hoadon table
            $sql = "INSERT INTO hoadon (id_nguoidung, diachigiaohang, tongtien, trangthai, ghichu, id_phuongthucthanhtoan) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $result = pdo_execute($sql, 
                $orderData['id_nguoidung'],
                $orderData['diachigiaohang'],
                $orderData['tongtien'],
                $orderData['trangthai'],
                $orderData['ghichu'],
                $orderData['id_phuongthucthanhtoan']
            );
            
            $orderId = pdo_last_insert_id();
    
            // Insert order items into chitiethoadon table
            $itemsInserted = 0;
            foreach ($cartItems as $item) {
                $id_topping = isset($item['id_topping']) ? $item['id_topping'] : null;
    
                $sql = "INSERT INTO chitiethoadon (id_hoadon, id_sanpham, soluong, gia, id_topping) 
                        VALUES (?, ?, ?, ?, ?)";
                $result = pdo_execute($sql, 
                    $orderId,
                    $item['id_sanpham'],
                    $item['soluong'],
                    $item['gia'],
                    $id_topping
                );
                
                if ($result) {
                    $itemsInserted++;
                }
            }
    
            // Verify items were inserted
            $sql = "SELECT COUNT(*) as count FROM chitiethoadon WHERE id_hoadon = ?";
            $count = pdo_query_one($sql, $orderId);
    
            // Get cart ID
            $sql = "SELECT id FROM giohang WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
            $cart = pdo_query_one($sql, $orderData['id_nguoidung']);
            
            if ($cart) {
                // Delete cart items
                $sql = "DELETE FROM giohang_chitiet WHERE id_giohang = ?";
                $result = pdo_execute($sql, $cart['id']);
                
                // Delete cart
                $sql = "DELETE FROM giohang WHERE id = ?";
                $result = pdo_execute($sql, $cart['id']);
            }
    
            // Commit transaction
            pdo_execute("COMMIT");
    
            return $orderId;
    
        } catch (Exception $e) {
            // Rollback transaction on error
            pdo_execute("ROLLBACK");
            return false;
        }
    }
    
    /**
     * Cancel an order by updating its status to "Đã hủy"
     * 
     * @param int $orderId The ID of the order to cancel
     * @param int $userId The ID of the user who owns the order
     * @return bool True if the order was successfully cancelled, false otherwise
     */
    public function cancelOrder($orderId, $userId) {
        try {
            // Start transaction
            pdo_execute("START TRANSACTION");
            
            // Check if the order exists and belongs to the user
            $sql = "SELECT id, trangthai FROM hoadon WHERE id = ? AND id_nguoidung = ?";
            $order = pdo_query_one($sql, $orderId, $userId);
            
            if (!$order) {
                pdo_execute("ROLLBACK");
                return false;
            }
            
            // Check if the order can be cancelled (only orders in "Chờ xác nhận" status can be cancelled)
            if ($order['trangthai'] !== 'Chờ xác nhận') {
                pdo_execute("ROLLBACK");
                return false;
            }
            
            // Update the order status to "Đã hủy"
            $sql = "UPDATE hoadon SET trangthai = 'Đã hủy' WHERE id = ? AND id_nguoidung = ?";
            $result = pdo_execute($sql, $orderId, $userId);
            
            // Commit transaction
            pdo_execute("COMMIT");
            
            return $result;
        } catch (Exception $e) {
            // Rollback transaction on error
            pdo_execute("ROLLBACK");
            return false;
        }
    }
} 