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
                    sp.gia as gia_goc,
                    tp.tentopping,
                    tp.gia as gia_topping,
                    CASE WHEN spg.giagiam > 0 THEN 1 ELSE 0 END as is_discounted,
                    CASE WHEN spg.giagiam > 0 THEN spg.giagiam ELSE sp.gia END as gia_hien_tai
                FROM giohang_chitiet gc
                JOIN sanpham sp ON gc.id_sanpham = sp.id 
                LEFT JOIN topping tp ON gc.id_topping = tp.id
                LEFT JOIN sanphamgiamgia spg ON sp.id = spg.id_sanpham
                JOIN giohang gh ON gc.id_giohang = gh.id
                WHERE gh.id_nguoidung = ? AND gh.trangthai = 'Chưa đặt'";
        
        $items = pdo_query($sql, $userId);
        
        // Update the 'gia' field to use the current price
        foreach ($items as &$item) {
            $item['gia'] = $item['gia_hien_tai'];
        }
        
        return $items;
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

            // Start transaction
            $conn->beginTransaction();
            error_log("Transaction started");

            // Prepare the SQL statement
            $sql = "INSERT INTO hoadon (id_nguoidung, tongtien, diachigiaohang, trangthai, ghichu, id_phuongthucthanhtoan) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
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
                $data['note'] ?? '',
                $data['payment_method']
            ];
            
            error_log("SQL: " . $sql);
            error_log("Params: " . print_r($params, true));
            
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                error_log("Failed to prepare statement");
                $conn->rollBack();
                throw new Exception("Không thể chuẩn bị câu lệnh SQL");
            }
            
            if ($stmt->execute($params)) {
                $orderId = $conn->lastInsertId();
                error_log("Order created successfully with ID: " . $orderId);
                
                // Create order details and update product quantities
                if (!$this->createOrderDetails($orderId, $data['cart_items'], $conn)) {
                    error_log("Failed to create order details or update product quantities");
                    $conn->rollBack();
                    throw new Exception("Không thể tạo chi tiết đơn hàng hoặc cập nhật số lượng sản phẩm");
                }
                
                // Commit transaction
                $conn->commit();
                error_log("Transaction committed successfully");
                
                return $orderId;
            } else {
                error_log("Failed to execute order creation SQL");
                $conn->rollBack();
                throw new Exception("Không thể tạo đơn hàng");
            }
        } catch (Exception $e) {
            error_log("Error creating order: " . $e->getMessage());
            // Rollback transaction if it was started
            if (isset($conn) && $conn->inTransaction()) {
                $conn->rollBack();
                error_log("Transaction rolled back due to error");
            }
            throw new Exception("Lỗi khi tạo đơn hàng: " . $e->getMessage());
        }
    }

    // Create order details
    public function createOrderDetails($orderId, $cartItems, $conn = null) {
        error_log("Starting createOrderDetails with orderId: " . $orderId);
        error_log("Cart items to process: " . print_r($cartItems, true));

        try {
            // Use provided connection or get a new one
            if ($conn === null) {
                $conn = pdo_get_connection();
                if (!$conn) {
                    error_log("Failed to get database connection");
                    throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
                }
            }

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
                
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    error_log("Failed to prepare statement for order detail");
                    return false;
                }
                
                if (!$stmt->execute($params)) {
                    error_log("Failed to execute SQL for order detail");
                    return false;
                }
                error_log("Successfully inserted order detail");
                
                // Update product quantity in the database
                $updateSql = "UPDATE sanpham SET soluong = soluong - ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateSql);
                if (!$updateStmt) {
                    error_log("Failed to prepare statement for updating product quantity");
                    return false;
                }
                
                if (!$updateStmt->execute([$soluong, $id_sanpham])) {
                    error_log("Failed to update product quantity for product ID: " . $id_sanpham);
                    return false;
                }
                error_log("Successfully updated product quantity for product ID: " . $id_sanpham);
                
                // Update product status if quantity becomes 0
                $checkSql = "SELECT soluong FROM sanpham WHERE id = ?";
                $checkStmt = $conn->prepare($checkSql);
                if (!$checkStmt) {
                    error_log("Failed to prepare statement for checking product quantity");
                    return false;
                }
                
                $checkStmt->execute([$id_sanpham]);
                $product = $checkStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($product && $product['soluong'] <= 0) {
                    $statusSql = "UPDATE sanpham SET trangthai = 'Hết hàng' WHERE id = ?";
                    $statusStmt = $conn->prepare($statusSql);
                    if (!$statusStmt) {
                        error_log("Failed to prepare statement for updating product status");
                        return false;
                    }
                    
                    if (!$statusStmt->execute([$id_sanpham])) {
                        error_log("Failed to update product status for product ID: " . $id_sanpham);
                        return false;
                    }
                    error_log("Updated product status to 'Hết hàng' for product ID: " . $id_sanpham);
                }
            }
            return true;
        } catch (Exception $e) {
            error_log("Error in createOrderDetails: " . $e->getMessage());
            return false;
        }
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
