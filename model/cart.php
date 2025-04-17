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
        $sql = "SELECT gct.*, sp.tensanpham, sp.hinhanh1, sp.gia, sp.soluong as soluong_kho 
                FROM giohang_chitiet gct 
                JOIN sanpham sp ON gct.id_sanpham = sp.id 
                WHERE gct.id_giohang = ?";
        return pdo_query($sql, $cart['id']);
    }
    public function addToCart($userId, $productId, $quantity = 1) {
        try {
            $cart = $this->getCart($userId);
            if (!$cart) {
                $this->createCart($userId);
                $cart = $this->getCart($userId);
            }
            $sql = "SELECT * FROM giohang_chitiet WHERE id_giohang = ? AND id_sanpham = ?";
            $existingItem = pdo_query_one($sql, $cart['id'], $productId);
            if ($existingItem) {
                $sql = "UPDATE giohang_chitiet SET soluong = ? WHERE id = ?";
                return pdo_execute($sql, $quantity, $existingItem['id']);
            } else {
                $sql = "SELECT gia FROM sanpham WHERE id = ?";
                $product = pdo_query_one($sql, $productId);  
                if (!$product) {
                    throw new Exception("Sản phẩm không tồn tại");
                }
                $sql = "INSERT INTO giohang_chitiet (id_giohang, id_sanpham, soluong, gia) 
                        VALUES (?, ?, ?, ?)";
                return pdo_execute($sql, $cart['id'], $productId, $quantity, $product['gia']);
            }
        } catch (Exception $e) {
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
        $cart = $this->getCart($userId);
        if (!$cart) {
            return false;
        }
        $sql = "DELETE FROM giohang_chitiet 
                WHERE id_giohang = ? AND id_sanpham = ?";
        return pdo_execute($sql, $cart['id'], $productId);
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
}
