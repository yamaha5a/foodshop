<?php
require_once 'connection.php';

function getAllDanhMuc() {
    $sql = "
        SELECT dm.*, COUNT(sp.id) as total 
        FROM danhmuc dm 
        LEFT JOIN sanpham sp ON dm.id = sp.id_danhmuc 
        GROUP BY dm.id 
        ORDER BY dm.id DESC";
    return pdo_query($sql);
}


?>