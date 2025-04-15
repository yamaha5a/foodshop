<?php
require_once 'connection.php';

class SanPhamToppingModel {
    public function getAllProductToppings() {
        $sql = "SELECT st.*, sp.tensanpham, sp.hinhanh1, t.tentopping, t.gia
                FROM sanpham_topping st
                JOIN sanpham sp ON st.id_sanpham = sp.id
                JOIN topping t ON st.id_topping = t.id
                ORDER BY st.id DESC";
        return pdo_query($sql);
    }

    public function getProductToppingById($id) {
        $sql = "SELECT st.*, sp.tensanpham, sp.hinhanh1, t.tentopping, t.gia
                FROM sanpham_topping st
                JOIN sanpham sp ON st.id_sanpham = sp.id
                JOIN topping t ON st.id_topping = t.id
                WHERE st.id = ?";
        return pdo_query_one($sql, $id);
    }

    public function getToppingsByProductId($productId) {
        $sql = "SELECT st.*, t.tentopping, t.gia
                FROM sanpham_topping st
                JOIN topping t ON st.id_topping = t.id
                WHERE st.id_sanpham = ?";
        return pdo_query($sql, $productId);
    }

    public function checkProductToppingExists($sanpham_id, $topping_id, $exclude_id = null) {
        $sql = "SELECT COUNT(*) as count FROM sanpham_topping 
                WHERE id_sanpham = ? AND id_topping = ?";
        $params = [$sanpham_id, $topping_id];
        
        if ($exclude_id !== null) {
            $sql .= " AND id != ?";
            $params[] = $exclude_id;
        }
        
        $result = pdo_query_one($sql, ...$params);
        return $result['count'] > 0;
    }

    public function addProductTopping($sanpham_id, $topping_id) {
        $sql = "INSERT INTO sanpham_topping (id_sanpham, id_topping) VALUES (?, ?)";
        return pdo_execute($sql, $sanpham_id, $topping_id);
    }

    public function updateProductTopping($id, $sanpham_id, $topping_id) {
        $sql = "UPDATE sanpham_topping SET id_sanpham = ?, id_topping = ? WHERE id = ?";
        return pdo_execute($sql, $sanpham_id, $topping_id, $id);
    }

    public function deleteProductTopping($id) {
        $sql = "DELETE FROM sanpham_topping WHERE id = ?";
        return pdo_execute($sql, $id);
    }

    public function getAllProducts() {
        $sql = "SELECT id, tensanpham, hinhanh1 FROM sanpham ORDER BY tensanpham";
        return pdo_query($sql);
    }

    public function getAllToppings() {
        $sql = "SELECT id, tentopping, gia FROM topping ORDER BY tentopping";
        return pdo_query($sql);
    }
} 