<?php
require_once 'connection.php'; 

function get_product_by_id($id) {
    $sql = "SELECT sp.*, dm.tendanhmuc, spg.giagiam, spg.ngay_giamgia,
            CASE WHEN spg.giagiam > 0 THEN 1 ELSE 0 END as is_discounted
            FROM sanpham sp 
            LEFT JOIN danhmuc dm ON sp.id_danhmuc = dm.id 
            LEFT JOIN sanphamgiamgia spg ON sp.id = spg.id_sanpham
            WHERE sp.id = ?";
    return pdo_query_one($sql, $id);
}

function get_related_products($category_id, $current_product_id, $limit = 4) {
    // Kiểm tra xem category_id có hợp lệ không
    if (empty($category_id)) {
        return [];
    }
    
    // Truy vấn để lấy sản phẩm cùng danh mục
    $sql = "SELECT sp.*, dm.tendanhmuc, dm.id as id_danhmuc, spg.giagiam, spg.ngay_giamgia,
            CASE WHEN spg.giagiam > 0 THEN 1 ELSE 0 END as is_discounted
            FROM sanpham sp 
            LEFT JOIN danhmuc dm ON sp.id_danhmuc = dm.id 
            LEFT JOIN sanphamgiamgia spg ON sp.id = spg.id_sanpham
            WHERE sp.id_danhmuc = ? AND sp.id != ? 
            ORDER BY RAND() 
            LIMIT ?";
    
    // Debug để kiểm tra tham số
    // echo "<pre>Category ID: " . $category_id . ", Product ID: " . $current_product_id . ", Limit: " . $limit . "</pre>";
    
    $results = pdo_query($sql, $category_id, $current_product_id, $limit);
    
    // Debug để kiểm tra dữ liệu
    // echo "<pre>"; print_r($results); echo "</pre>";
    
    return $results;
}
?>
