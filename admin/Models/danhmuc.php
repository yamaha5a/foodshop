<?php
require_once "connection.php";

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
