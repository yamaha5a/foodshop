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
        $current_category = null;
        
        if (isset($product['id_danhmuc']) && !empty($product['id_danhmuc'])) {
            $related_products = get_related_products($product['id_danhmuc'], $id);
            
            // Debug để kiểm tra dữ liệu
            // echo "<pre>Product ID: " . $id . ", Category ID: " . $product['id_danhmuc'] . "</pre>";
            // echo "<pre>Related Products: "; print_r($related_products); echo "</pre>";
            
            // Nếu không có sản phẩm liên quan, lấy một số sản phẩm ngẫu nhiên từ cùng danh mục
            if (empty($related_products)) {
                // Lấy tất cả sản phẩm từ cùng danh mục
                $sql = "SELECT sp.*, dm.tendanhmuc, dm.id as id_danhmuc
                        FROM sanpham sp 
                        LEFT JOIN danhmuc dm ON sp.id_danhmuc = dm.id 
                        WHERE sp.id_danhmuc = ? AND sp.id != ? 
                        ORDER BY RAND() 
                        LIMIT 4";
                
                $related_products = pdo_query($sql, $product['id_danhmuc'], $id);
            }
            
            // Lấy thông tin danh mục hiện tại
            foreach ($categories as $category) {
                if ($category['id'] == $product['id_danhmuc']) {
                    $current_category = $category;
                    break;
                }
            }
        }
        
        include 'views/detail/detail.php'; 
    }
}
?>
