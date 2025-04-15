<?php
require_once 'connection.php';

class CheckoutModel {
    // Get cart details for a user
    public function getCartDetails($userId) {
        $sql = "SELECT 
                    gc.id_sanpham,
                    gc.soluong,
                    gc.gia,
                    gc.id_topping,
                    sp.tensanpham,
                    sp.hinhanh1,
                    tp.tentopping,
                    tp.gia as gia_topping
                FROM giohang_chitiet gc
                JOIN sanpham sp ON gc.id_sanpham = sp.id
                LEFT JOIN topping tp ON gc.id_topping = tp.id
                JOIN giohang gh ON gc.id_giohang = gh.id
                WHERE gh.id_nguoidung = ? AND gh.trangthai = 'Chưa đặt'";
        
        return pdo_query($sql, $userId);
    }

    // Get user's shipping addresses
    public function getUserAddresses($userId) {
        $sql = "SELECT * FROM diachinhanhang WHERE id_nguoidung = ? ORDER BY macdinh DESC";
        return pdo_query($sql, $userId);
    }

    // Get payment methods
    public function getPaymentMethods() {
        $sql = "SELECT * FROM phuongthucthanhtoan";
        return pdo_query($sql);
    }

    // Get active promotions
    public function getActivePromotions() {
        $sql = "SELECT * FROM khuyenmai 
                WHERE trangthai = 'Hoạt động' 
                AND ngaybatdau <= CURDATE() 
                AND ngayketthuc >= CURDATE()";
        return pdo_query($sql);
    }

    // Create new order
    public function createOrder($data) {
        error_log("Starting createOrder with data: " . print_r($data, true));
        
        try {
            $conn = pdo_get_connection();
            if (!$conn) {
                error_log("Failed to get database connection");
                throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
            }

            // Prepare the SQL statement
            $sql = "INSERT INTO hoadon (id_nguoidung, tongtien, diachigiaohang, trangthai, ghichu) 
                    VALUES (?, ?, ?, ?, ?)";
            
            // Calculate total from cart items
            $total = 0;
            foreach ($data['cart_items'] as $item) {
                // Convert string values to float
                $gia = floatval($item['gia']);
                $gia_topping = !empty($item['gia_topping']) ? floatval($item['gia_topping']) : 0;
                $soluong = intval($item['soluong']);
                
                $itemTotal = ($gia + $gia_topping) * $soluong;
                $total += $itemTotal;
            }
            
            error_log("Calculated total: " . $total);
            
            // Prepare parameters
            $params = [
                $data['userId'],
                $total,
                $data['address'],
                'Chờ xác nhận',
                $data['note'] ?? ''
            ];
            
            error_log("SQL: " . $sql);
            error_log("Params: " . print_r($params, true));
            
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                error_log("Failed to prepare statement");
                throw new Exception("Không thể chuẩn bị câu lệnh SQL");
            }
            
            if ($stmt->execute($params)) {
                $orderId = $conn->lastInsertId();
                error_log("Order created successfully with ID: " . $orderId);
                return $orderId;
            } else {
                error_log("Failed to execute order creation SQL");
                throw new Exception("Không thể tạo đơn hàng");
            }
        } catch (Exception $e) {
            error_log("Error creating order: " . $e->getMessage());
            throw new Exception("Lỗi khi tạo đơn hàng: " . $e->getMessage());
        }
    }

    // Create order details
    public function createOrderDetails($orderId, $cartItems) {
        error_log("Starting createOrderDetails with orderId: " . $orderId);
        error_log("Cart items to process: " . print_r($cartItems, true));

        $sql = "INSERT INTO chitiethoadon (id_hoadon, id_sanpham, soluong, gia, id_topping) 
                VALUES (?, ?, ?, ?, ?)";
        
        foreach ($cartItems as $item) {
            // Validate required fields
            if (!isset($item['id_sanpham']) || !isset($item['soluong']) || !isset($item['gia'])) {
                error_log("Missing required fields in cart item: " . print_r($item, true));
                continue;
            }

            // Convert values to correct types
            $id_sanpham = (int)$item['id_sanpham'];
            $soluong = (int)$item['soluong'];
            $gia = (float)$item['gia'];
            $id_topping = !empty($item['id_topping']) ? (int)$item['id_topping'] : null;

            $params = [
                $orderId,
                $id_sanpham,
                $soluong,
                $gia,
                $id_topping
            ];
            
            error_log("Attempting to insert order detail with params: " . print_r($params, true));
            
            try {
                if (!pdo_execute($sql, ...$params)) {
                    error_log("Failed to execute SQL for order detail");
                    return false;
                }
                error_log("Successfully inserted order detail");
            } catch (Exception $e) {
                error_log("Error inserting order detail: " . $e->getMessage());
                return false;
            }
        }
        return true;
    }

    // Update cart status to 'Đã đặt'
    public function updateCartStatus($cartId) {
        $sql = "UPDATE giohang SET trangthai = 'Đã đặt' WHERE id = ?";
        return pdo_execute($sql, $cartId);
    }

    // Get cart ID for user
    public function getCartId($userId) {
        $sql = "SELECT id FROM giohang WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
        return pdo_query_one($sql, $userId);
    }
}
