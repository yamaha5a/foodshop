<?php
require_once 'connection.php';

class ProductModel {
    public function getAllProducts() {
        $sql = "SELECT * FROM sanpham";
        return pdo_query($sql);
    }

    public function getProductsByCategory($categoryId) {
        $sql = "SELECT * FROM sanpham WHERE id_danhmuc = ?";
        return pdo_query($sql, [$categoryId]);
    }
}


?>
