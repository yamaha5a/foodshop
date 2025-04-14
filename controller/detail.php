<?php
require_once 'model/sanpham.php';

class DetailController {
    public function showDetail($id) {
        $product = get_product_by_id($id);
        include 'views/detail/detail.php'; 
    }
}
?>
