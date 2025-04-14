<?php
require_once 'connection.php';

class CartModel {
    public function getOrCreateCart($userId) {
        // Check if user has an active cart
        $sql = "SELECT id FROM giohang WHERE id_nguoidung = ? AND trangthai = 'Chưa đặt'";
        $cart = pdo_query_one($sql, $userId);

        if (!$cart) {
            // Create new cart
            $sql = "INSERT INTO giohang (id_nguoidung) VALUES (?)";
            pdo_execute($sql, $userId);
            return pdo_last_insert_id();
        }

        return $cart['id'];
    }

    public function getCartItem($cartId, $productId) {
        $sql = "SELECT * FROM giohang_chitiet WHERE id_giohang = ? AND id_sanpham = ?";
        return pdo_query_one($sql, $cartId, $productId);
    }

    public function addCartItem($cartId, $productId, $quantity, $price) {
        $sql = "INSERT INTO giohang_chitiet (id_giohang, id_sanpham, soluong, gia) 
                VALUES (?, ?, ?, ?)";
        pdo_execute($sql, $cartId, $productId, $quantity, $price);
    }

    public function updateCartItem($cartId, $productId, $quantity) {
        $sql = "UPDATE giohang_chitiet SET soluong = ? WHERE id_giohang = ? AND id_sanpham = ?";
        pdo_execute($sql, $quantity, $cartId, $productId);
    }

    public function removeCartItem($cartId, $productId) {
        $sql = "DELETE FROM giohang_chitiet WHERE id_giohang = ? AND id_sanpham = ?";
        pdo_execute($sql, $cartId, $productId);
    }

    public function getCartItems($userId) {
        $sql = "SELECT gct.*, sp.tensanpham, sp.hinhanh1 
                FROM giohang gh 
                JOIN giohang_chitiet gct ON gh.id = gct.id_giohang 
                JOIN sanpham sp ON gct.id_sanpham = sp.id 
                WHERE gh.id_nguoidung = ? AND gh.trangthai = 'Chưa đặt'";
        return pdo_query($sql, $userId);
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
}

function get_sanpham_by_id($id) {
    $sql = "SELECT id, tensanpham, gia, hinhanh1 FROM sanpham WHERE id = ?";
    return pdo_query_one($sql, $id);
}
