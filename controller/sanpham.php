<?php
require_once 'model/SanPham.php';

class SanPhamController {
    public function list() {
        $products = SanPham::getAllProducts();
        include 'view/sanpham.php'; // Hiển thị view
    }
}
?>
