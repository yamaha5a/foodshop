<?php
require_once 'connection.php'; 

function get_product_by_id($id) {
    $sql = "SELECT * FROM sanpham WHERE id = ?";
    return pdo_query_one($sql, $id);
}
?>
