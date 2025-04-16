<?php
require_once 'model/detail.php';
require_once 'model/binhluan.php';
require_once 'model/danhMuc.php';

class DetailController {
    public function showDetail($id) {
        $product = get_product_by_id($id);
        if (!$product) {
            header("Location: index.php?page=404");
            exit();
        }
        
        // Lấy danh sách bình luận của sản phẩm
        $comments = get_comments_by_product($id);
        
        // Lấy danh sách danh mục
        $danhmucModel = new danhMuc();
        $categories = $danhmucModel->getAllDanhMuc();
        
        // Lấy sản phẩm liên quan - đảm bảo lấy đúng theo danh mục
        $related_products = [];
        if (isset($product['id_danhmuc']) && !empty($product['id_danhmuc'])) {
            $related_products = get_related_products($product['id_danhmuc'], $id);
        }
        
        include 'views/detail/detail.php'; 
    }
}
?>
