<?php
require_once 'connection.php';

function get_all_discounts() {
    $sql = "SELECT * FROM khuyenmai ORDER BY ngaybatdau DESC";
    return pdo_query($sql);
}

function get_discount_by_id($id) {
    $sql = "SELECT * FROM khuyenmai WHERE id = ?";
    return pdo_query_one($sql, $id);
}

function add_discount($tenkhuyenmai, $giatrigiam, $ngaybatdau, $ngayketthuc, $trangthai) {
    $sql = "INSERT INTO khuyenmai (tenkhuyenmai, giatrigiam, ngaybatdau, ngayketthuc, trangthai) 
            VALUES (?, ?, ?, ?, ?)";
    return pdo_execute($sql, $tenkhuyenmai, $giatrigiam, $ngaybatdau, $ngayketthuc, $trangthai);
}

function update_discount($id, $tenkhuyenmai, $giatrigiam, $ngaybatdau, $ngayketthuc, $trangthai) {
    $sql = "UPDATE khuyenmai 
            SET tenkhuyenmai = ?, giatrigiam = ?, ngaybatdau = ?, ngayketthuc = ?, trangthai = ? 
            WHERE id = ?";
    return pdo_execute($sql, $tenkhuyenmai, $giatrigiam, $ngaybatdau, $ngayketthuc, $trangthai, $id);
}

function delete_discount($id) {
    $sql = "DELETE FROM khuyenmai WHERE id = ?";
    return pdo_execute($sql, $id);
}

function update_discount_status() {
    $sql = "UPDATE khuyenmai 
            SET trangthai = 'Hết hạn' 
            WHERE ngayketthuc < CURDATE() AND trangthai = 'Hoạt động'";
    return pdo_execute($sql);
}

function get_active_discounts() {
    $sql = "SELECT * FROM khuyenmai 
            WHERE trangthai = 'Hoạt động' 
            AND ngaybatdau <= CURDATE() 
            AND ngayketthuc >= CURDATE() 
            ORDER BY giatrigiam DESC";
    return pdo_query($sql);
}
?> 