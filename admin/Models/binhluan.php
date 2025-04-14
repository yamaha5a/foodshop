<?php
require_once 'connection.php';

function get_all_comments() {
    $sql = "SELECT b.*, n.ten as ten_nguoidung, s.tensanpham 
            FROM binhluan b 
            JOIN nguoidung n ON b.id_nguoidung = n.id 
            JOIN sanpham s ON b.id_sanpham = s.id 
            ORDER BY b.ngaydang DESC";
    return pdo_query($sql);
}

function get_comment_by_id($id) {
    $sql = "SELECT b.*, n.ten as ten_nguoidung, s.tensanpham 
            FROM binhluan b 
            JOIN nguoidung n ON b.id_nguoidung = n.id 
            JOIN sanpham s ON b.id_sanpham = s.id 
            WHERE b.id = ?";
    return pdo_query_one($sql, $id);
}

function delete_comment($id) {
    $sql = "DELETE FROM binhluan WHERE id = ?";
    return pdo_execute($sql, $id);
}

function get_comments_by_product($product_id) {
    $sql = "SELECT b.*, n.ten as ten_nguoidung 
            FROM binhluan b 
            JOIN nguoidung n ON b.id_nguoidung = n.id 
            WHERE b.id_sanpham = ? 
            ORDER BY b.ngaydang DESC";
    return pdo_query($sql, $product_id);
}

function get_comment_count($user_id, $product_id) {
    $sql = "SELECT COUNT(*) as count 
            FROM binhluan 
            WHERE id_nguoidung = ? AND id_sanpham = ?";
    $result = pdo_query_one($sql, $user_id, $product_id);
    return $result['count'];
}
?> 