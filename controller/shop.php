<?php
require_once 'model/shop.php';
class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function getAllProducts() {
        return $this->productModel->getAllProducts();
    }

    public function getProductsByCategory($categoryId) {
        return $this->productModel->getProductsByCategory($categoryId);
    }
}


?>
