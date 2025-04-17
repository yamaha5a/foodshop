<?php
require_once "connection.php";

class danhMucModel{
function getAllDanhMuc() {
    $sql = "SELECT * FROM danhmuc ORDER BY id DESC";
    return pdo_query($sql);
}

function addDanhMuc($tendanhmuc) {
    $sql = "INSERT INTO danhmuc (tendanhmuc) VALUES (?)";
    pdo_execute($sql, $tendanhmuc);
}

function getOneDanhMuc($id) {
    $sql = "SELECT * FROM danhmuc WHERE id = ?";
    return pdo_query_one($sql, $id);
}

function updateDanhMuc($id, $tendanhmuc) {
    $sql = "UPDATE danhmuc SET tendanhmuc = ? WHERE id = ?";
    pdo_execute($sql, $tendanhmuc, $id);
}

function deleteDanhMuc($id) {
    $sql = "DELETE FROM danhmuc WHERE id = ?";
    pdo_execute($sql, $id);
}

// Kiểm tra xem danh mục có sản phẩm không
function kiemTraDanhMucCoSanPham($id) {
    $sql = "SELECT COUNT(*) as count FROM sanpham WHERE id_danhmuc = ?";
    $result = pdo_query_one($sql, $id);
    return $result['count'] > 0;
}
}