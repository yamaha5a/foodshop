<?php
require_once 'connection.php';

class CartModel {
    public function getCart($userId) {
        $sql = "SELECT * FROM giohang WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
        return pdo_query_one($sql, $userId);
    }
    public function createCart($userId) {
        $sql = "INSERT INTO giohang (id_nguoidung, trangthai) VALUES (?, 'Chưa đặt')";
        return pdo_execute($sql, $userId);
    }
    public function getCartItems($userId) {
        $cart = $this->getCart($userId);
        if (!$cart) {
            return [];
        }
        $sql = "SELECT gct.*, sp.tensanpham, sp.hinhanh1, sp.gia as gia_goc, sp.soluong as soluong_kho, 
                CASE WHEN spg.giagiam > 0 THEN 1 ELSE 0 END as is_discounted,
                CASE WHEN spg.giagiam > 0 THEN spg.giagiam ELSE sp.gia END as gia_hien_tai
                FROM giohang_chitiet gct 
                JOIN sanpham sp ON gct.id_sanpham = sp.id 
                LEFT JOIN sanphamgiamgia spg ON sp.id = spg.id_sanpham
                WHERE gct.id_giohang = ?";
        $items = pdo_query($sql, $cart['id']);
        
        // Update the 'gia' field to use the current price
        foreach ($items as &$item) {
            $item['gia'] = $item['gia_hien_tai'];
        }
        
        return $items;
    }
    public function addToCart($userId, $productId, $quantity = 1) {
        try {
            // Bắt đầu transaction
            pdo_execute("START TRANSACTION");
            
            $cart = $this->getCart($userId);
            if (!$cart) {
                $this->createCart($userId);
                $cart = $this->getCart($userId);
            }
            
            // Lấy thông tin sản phẩm và giá
            $sql = "SELECT sp.gia, sp.soluong, spg.giagiam 
                    FROM sanpham sp 
                    LEFT JOIN sanphamgiamgia spg ON sp.id = spg.id_sanpham 
                    WHERE sp.id = ?";
            $product = pdo_query_one($sql, $productId);
            
            if (!$product) {
                pdo_execute("ROLLBACK");
                throw new Exception("Sản phẩm không tồn tại");
            }
            
            // Xác định giá hiện tại của sản phẩm
            $currentPrice = isset($product['giagiam']) && $product['giagiam'] > 0 ? $product['giagiam'] : $product['gia'];
            
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa với cùng giá
            $sql = "SELECT * FROM giohang_chitiet 
                    WHERE id_giohang = ? AND id_sanpham = ? AND gia = ?";
            $existingItem = pdo_query_one($sql, $cart['id'], $productId, $currentPrice);
            
            if ($existingItem) {
                // Kiểm tra nếu số lượng vượt quá số lượng có sẵn
                $newQuantity = $existingItem['soluong'] + $quantity;
                if ($newQuantity > $product['soluong']) {
                    pdo_execute("ROLLBACK");
                    throw new Exception("Số lượng sản phẩm trong kho không đủ. Số lượng tối đa có thể đặt: " . $product['soluong']);
                }
                
                // Tăng số lượng hiện tại lên quantity
                $sql = "UPDATE giohang_chitiet SET soluong = ? WHERE id = ?";
                $result = pdo_execute($sql, $newQuantity, $existingItem['id']);
                
                if ($result === false) {
                    pdo_execute("ROLLBACK");
                    throw new Exception("Không thể cập nhật số lượng sản phẩm");
                }
            } else {
                // Kiểm tra nếu số lượng vượt quá số lượng có sẵn
                if ($quantity > $product['soluong']) {
                    pdo_execute("ROLLBACK");
                    throw new Exception("Số lượng sản phẩm trong kho không đủ. Số lượng tối đa có thể đặt: " . $product['soluong']);
                }
                
                // Thêm sản phẩm mới vào giỏ hàng
                $sql = "INSERT INTO giohang_chitiet (id_giohang, id_sanpham, soluong, gia) 
                        VALUES (?, ?, ?, ?)";
                $result = pdo_execute($sql, $cart['id'], $productId, $quantity, $currentPrice);
                
                if ($result === false) {
                    pdo_execute("ROLLBACK");
                    throw new Exception("Không thể thêm sản phẩm vào giỏ hàng");
                }
            }
            
            // Commit transaction nếu mọi thứ thành công
            pdo_execute("COMMIT");
            return true;
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            pdo_execute("ROLLBACK");
            error_log("Error in addToCart: " . $e->getMessage());
            throw $e;
        }
    }
    public function updateCartItem($userId, $productId, $quantity) {
        try {
            $cart = $this->getCart($userId);
            if (!$cart) {
                throw new Exception("Không tìm thấy giỏ hàng");
            }

            // Kiểm tra sản phẩm có tồn tại không và lấy số lượng hiện có
            $sql = "SELECT id, soluong, tensanpham FROM sanpham WHERE id = ?";
            $product = pdo_query_one($sql, $productId);
            if (!$product) {
                throw new Exception("Không tìm thấy sản phẩm");
            }

            // Kiểm tra nếu số lượng yêu cầu vượt quá số lượng có sẵn
            if ($quantity > $product['soluong']) {
                throw new Exception("Số lượng sản phẩm '" . $product['tensanpham'] . "' trong kho không đủ. Số lượng tối đa có thể đặt: " . $product['soluong']);
            }

            // Cập nhật số lượng
            $sql = "UPDATE giohang_chitiet SET soluong = ? 
                    WHERE id_giohang = ? AND id_sanpham = ?";
            $result = pdo_execute($sql, $quantity, $cart['id'], $productId);
            
            if ($result === false) {
                throw new Exception("Không thể cập nhật số lượng sản phẩm");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error in updateCartItem: " . $e->getMessage());
            throw $e;
        }
    }
    public function removeCartItem($userId, $productId) {
        try {
            $cart = $this->getCart($userId);
            if (!$cart) {
                error_log("Không tìm thấy giỏ hàng cho người dùng ID: " . $userId);
                return false;
            }
            
            $sql = "DELETE FROM giohang_chitiet 
                    WHERE id_giohang = ? AND id_sanpham = ?";
            $result = pdo_execute($sql, $cart['id'], $productId);
            
            if ($result === false) {
                error_log("Lỗi khi xóa sản phẩm ID: " . $productId . " khỏi giỏ hàng ID: " . $cart['id']);
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Lỗi trong removeCartItem: " . $e->getMessage());
            return false;
        }
    }
    public function clearCart($userId) {
        try {
            echo "<div style='background: #e3f2fd; padding: 10px; margin: 10px;'>";
            echo "<h3>Cart Clear Debug:</h3>";
            pdo_execute("START TRANSACTION");
            echo "1. Starting transaction<br>";
            $sql = "SELECT id FROM giohang WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
            $cart = pdo_query_one($sql, $userId);
            echo "2. Found cart with ID: " . ($cart ? $cart['id'] : 'null') . "<br>";
            if ($cart) {
                $sql = "DELETE FROM giohang_chitiet WHERE id_giohang = ?";
                $result = pdo_execute($sql, $cart['id']);
                echo "3. Deleted cart items. Result: " . ($result ? 'success' : 'failed') . "<br>";              
                $sql = "DELETE FROM giohang WHERE id = ?";
                $result = pdo_execute($sql, $cart['id']);
                echo "4. Deleted cart. Result: " . ($result ? 'success' : 'failed') . "<br>";
            } else {
                echo "3. No cart found to delete<br>";
            }
            pdo_execute("COMMIT");
            echo "5. Transaction committed successfully<br>";
            echo "</div>";
            return true;
        } catch (Exception $e) {
            pdo_execute("ROLLBACK");
            echo "<div style='background: #ffebee; padding: 10px; margin: 10px;'>";
            echo "<h3>Error in clearCart:</h3>";
            echo "Error: " . $e->getMessage() . "<br>";
            echo "Transaction rolled back<br>";
            echo "</div>";
            return false;
        }
    }
    public function addToCartWithPrice($userId, $productId, $quantity = 1, $price) {
        try {
            // Bắt đầu transaction
            pdo_execute("START TRANSACTION");
            
            $cart = $this->getCart($userId);
            if (!$cart) {
                $this->createCart($userId);
                $cart = $this->getCart($userId);
            }
            
            // Lấy thông tin sản phẩm
            $sql = "SELECT soluong FROM sanpham WHERE id = ?";
            $product = pdo_query_one($sql, $productId);
            
            if (!$product) {
                pdo_execute("ROLLBACK");
                throw new Exception("Sản phẩm không tồn tại");
            }
            
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa với cùng giá
            $sql = "SELECT * FROM giohang_chitiet 
                    WHERE id_giohang = ? AND id_sanpham = ? AND gia = ?";
            $existingItem = pdo_query_one($sql, $cart['id'], $productId, $price);
            
            if ($existingItem) {
                // Kiểm tra nếu số lượng vượt quá số lượng có sẵn
                $newQuantity = $existingItem['soluong'] + $quantity;
                if ($newQuantity > $product['soluong']) {
                    pdo_execute("ROLLBACK");
                    throw new Exception("Số lượng sản phẩm trong kho không đủ. Số lượng tối đa có thể đặt: " . $product['soluong']);
                }
                
                // Tăng số lượng hiện tại lên quantity
                $sql = "UPDATE giohang_chitiet SET soluong = ? WHERE id = ?";
                $result = pdo_execute($sql, $newQuantity, $existingItem['id']);
                
                if ($result === false) {
                    pdo_execute("ROLLBACK");
                    throw new Exception("Không thể cập nhật số lượng sản phẩm");
                }
            } else {
                // Kiểm tra nếu số lượng vượt quá số lượng có sẵn
                if ($quantity > $product['soluong']) {
                    pdo_execute("ROLLBACK");
                    throw new Exception("Số lượng sản phẩm trong kho không đủ. Số lượng tối đa có thể đặt: " . $product['soluong']);
                }
                
                // Thêm sản phẩm mới vào giỏ hàng với giá được chỉ định
                $sql = "INSERT INTO giohang_chitiet (id_giohang, id_sanpham, soluong, gia) 
                        VALUES (?, ?, ?, ?)";
                $result = pdo_execute($sql, $cart['id'], $productId, $quantity, $price);
                
                if ($result === false) {
                    pdo_execute("ROLLBACK");
                    throw new Exception("Không thể thêm sản phẩm vào giỏ hàng");
                }
            }
            
            // Commit transaction nếu mọi thứ thành công
            pdo_execute("COMMIT");
            return true;
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            pdo_execute("ROLLBACK");
            error_log("Error in addToCartWithPrice: " . $e->getMessage());
            throw $e;
        }
    }
}
