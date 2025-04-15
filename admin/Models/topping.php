<?php
require_once 'connection.php';

class ToppingModel {
    public function getAllToppings() {
        $sql = "SELECT * FROM topping ORDER BY id DESC";
        return pdo_query($sql);
    }

    public function getToppingById($id) {
        $sql = "SELECT * FROM topping WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    public function addTopping($data) {
        $sql = "INSERT INTO topping (tentopping, gia) VALUES (?, ?)";
        return pdo_execute($sql, $data['tentopping'], $data['gia']);
    }

    public function updateTopping($id, $data) {
        $sql = "UPDATE topping SET tentopping = ?, gia = ? WHERE id = ?";
        return pdo_execute($sql, $data['tentopping'], $data['gia'], $id);
    }

    public function deleteTopping($id) {
        // Kiểm tra xem topping có được sử dụng trong sản phẩm nào không
        $checkSql = "SELECT COUNT(*) as count FROM sanpham_topping WHERE id_topping = ?";
        $result = pdo_query_one($checkSql, $id);
        
        if ($result['count'] > 0) {
            return false; // Không thể xóa vì đang được sử dụng
        }

        $sql = "DELETE FROM topping WHERE id = ?";
        return pdo_execute($sql, $id);
    }

    public function getRelatedProducts($toppingId) {
        $sql = "SELECT st.*, sp.tensanpham 
                FROM sanpham_topping st 
                JOIN sanpham sp ON st.id_sanpham = sp.id 
                WHERE st.id_topping = ?";
        return pdo_query($sql, $toppingId);
    }
} 