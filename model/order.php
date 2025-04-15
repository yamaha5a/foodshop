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
        echo "<div style='background: #e3f2fd; padding: 10px; margin: 10px;'>";
        echo "<h3>Order Items Debug:</h3>";
        
        $sql = "SELECT cthd.*, sp.tensanpham, sp.hinhanh1, sp.gia 
                FROM chitiethoadon cthd 
                JOIN sanpham sp ON cthd.id_sanpham = sp.id 
                WHERE cthd.id_hoadon = ?";
        
        echo "SQL Query: " . $sql . "<br>";
        echo "Order ID: " . $orderId . "<br>";
        
        $items = pdo_query($sql, $orderId);
        
        echo "Found " . count($items) . " items<br>";
        echo "<pre>";
        print_r($items);
        echo "</pre>";
        echo "</div>";
        
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
            error_log("Error clearing cart: " . $e->getMessage());
            return false;
        }
    }

    public function createOrder($orderData, $cartItems) {
        try {
            // Start transaction
            pdo_execute("START TRANSACTION");
            echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px;'>";
            echo "<h3>Debug Information:</h3>";
            echo "1. Starting transaction<br>";

            // Debug order data
            echo "Order Data:<br>";
            echo "<pre>";
            print_r($orderData);
            echo "</pre>";

            // Debug cart items
            echo "Cart Items:<br>";
            echo "<pre>";
            print_r($cartItems);
            echo "</pre>";

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
            
            echo "2. Inserted into hoadon. Result: " . ($result ? 'success' : 'failed') . "<br>";
            
            $orderId = pdo_last_insert_id();
            echo "3. Created order with ID: " . $orderId . "<br>";

            // Insert order items into chitiethoadon table
            $itemsInserted = 0;
            foreach ($cartItems as $item) {
                echo "4. Processing cart item:<br>";
                echo "   - Product ID: " . $item['id_sanpham'] . "<br>";
                echo "   - Quantity: " . $item['soluong'] . "<br>";
                echo "   - Price: " . $item['gia'] . "<br>";
                echo "   - Topping ID: " . ($item['id_topping'] ?? 'null') . "<br>";

                // Kiểm tra xem có topping không
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
                
                echo "   - Insert result: " . ($result ? 'success' : 'failed') . "<br>";
                if ($result) {
                    $itemsInserted++;
                }
            }

            echo "5. Total items inserted: " . $itemsInserted . "<br>";

            // Verify items were inserted
            $sql = "SELECT COUNT(*) as count FROM chitiethoadon WHERE id_hoadon = ?";
            $count = pdo_query_one($sql, $orderId);
            echo "6. Verified items in chitiethoadon: " . $count['count'] . " items<br>";

            // Get cart ID
            $sql = "SELECT id FROM giohang WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
            $cart = pdo_query_one($sql, $orderData['id_nguoidung']);
            echo "7. Found cart with ID: " . ($cart ? $cart['id'] : 'null') . "<br>";
            
            if ($cart) {
                // Delete cart items
                $sql = "DELETE FROM giohang_chitiet WHERE id_giohang = ?";
                $result = pdo_execute($sql, $cart['id']);
                echo "8. Deleted cart items. Result: " . ($result ? 'success' : 'failed') . "<br>";
                
                // Delete cart
                $sql = "DELETE FROM giohang WHERE id = ?";
                $result = pdo_execute($sql, $cart['id']);
                echo "9. Deleted cart. Result: " . ($result ? 'success' : 'failed') . "<br>";
            } else {
                echo "8. No cart found to delete<br>";
            }

            // Commit transaction
            pdo_execute("COMMIT");
            echo "10. Transaction committed successfully<br>";
            echo "</div>";

            return $orderId;

        } catch (Exception $e) {
            // Rollback transaction on error
            pdo_execute("ROLLBACK");
            echo "<div style='background: #ffebee; padding: 10px; margin: 10px;'>";
            echo "<h3>Error Information:</h3>";
            echo "Error in createOrder: " . $e->getMessage() . "<br>";
            echo "Transaction rolled back due to error<br>";
            echo "</div>";
            return false;
        }
    }
} 