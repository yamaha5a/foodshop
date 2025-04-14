<?php
require_once 'connection.php';

function get_comments_by_product($product_id) {
    $sql = "SELECT b.*, n.ten, n.hinhanh 
            FROM binhluan b 
            JOIN nguoidung n ON b.id_nguoidung = n.id 
            WHERE b.id_sanpham = ? 
            ORDER BY b.ngaydang DESC";
    return pdo_query($sql, $product_id);
}

function add_comment($user_id, $product_id, $content, $rating) {
    // Kiểm tra số lượng bình luận của người dùng cho sản phẩm này
    $sql = "SELECT COUNT(*) as count FROM binhluan WHERE id_nguoidung = ? AND id_sanpham = ?";
    $result = pdo_query_one($sql, $user_id, $product_id);
    
    if ($result['count'] >= 5) {
        return false; // Đã đạt giới hạn 5 bình luận
    }
    
    // Thêm bình luận mới
    $sql = "INSERT INTO binhluan (id_nguoidung, id_sanpham, noidung, danhgia) VALUES (?, ?, ?, ?)";
    return pdo_execute($sql, $user_id, $product_id, $content, $rating);
}

function get_comment_count($user_id, $product_id) {
    $sql = "SELECT COUNT(*) as count FROM binhluan WHERE id_nguoidung = ? AND id_sanpham = ?";
    $result = pdo_query_one($sql, $user_id, $product_id);
    return $result['count'];
}
?> 