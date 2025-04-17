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
    // Debug information
    error_log("add_comment called with: user_id=$user_id, product_id=$product_id, rating=$rating");
    error_log("Comment content: $content");
    
    // Kiểm tra số lượng bình luận của người dùng cho sản phẩm này
    $sql = "SELECT COUNT(*) as count FROM binhluan WHERE id_nguoidung = ? AND id_sanpham = ?";
    $result = pdo_query_one($sql, $user_id, $product_id);
    
    error_log("Comment count query result: " . print_r($result, true));
    
    if ($result['count'] >= 5) {
        error_log("User has reached the comment limit");
        return false; // Đã đạt giới hạn 5 bình luận
    }
    
    // Thêm bình luận mới
    $sql = "INSERT INTO binhluan (id_nguoidung, id_sanpham, noidung, danhgia) VALUES (?, ?, ?, ?)";
    $result = pdo_execute($sql, $user_id, $product_id, $content, $rating);
    
    error_log("Insert comment result: " . ($result ? "success" : "failed"));
    
    return $result;
}

function get_comment_count($user_id, $product_id) {
    $sql = "SELECT COUNT(*) as count FROM binhluan WHERE id_nguoidung = ? AND id_sanpham = ?";
    $result = pdo_query_one($sql, $user_id, $product_id);
    return $result['count'];
}
?> 