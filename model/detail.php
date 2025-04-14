<?php
require_once 'connection.php'; 

function get_product_by_id($id) {
    $sql = "SELECT sp.*, dm.tendanhmuc 
            FROM sanpham sp 
            LEFT JOIN danhmuc dm ON sp.id_danhmuc = dm.id 
            WHERE sp.id = ?";
    return pdo_query_one($sql, $id);
}

function get_related_products($category_id, $current_product_id, $limit = 4) {
    $sql = "SELECT sp.*, dm.tendanhmuc 
            FROM sanpham sp 
            LEFT JOIN danhmuc dm ON sp.id_danhmuc = dm.id 
            WHERE sp.id_danhmuc = ? AND sp.id != ? 
            ORDER BY RAND() 
            LIMIT ?";
    return pdo_query($sql, $category_id, $current_product_id, $limit);
}
?>
