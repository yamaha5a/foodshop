<?php
require_once 'connection.php';

function get_all_contacts() {
    $sql = "SELECT l.*, n.ten as ten_nguoidung, n.email 
            FROM lienhe l 
            JOIN nguoidung n ON l.nguoidung_id = n.id 
            ORDER BY l.ngaygui DESC";
    return pdo_query($sql);
}

function get_contact_by_id($id) {
    $sql = "SELECT l.*, n.ten as ten_nguoidung, n.email, n.sodienthoai, n.diachi 
            FROM lienhe l 
            JOIN nguoidung n ON l.nguoidung_id = n.id 
            WHERE l.id = ?";
    return pdo_query_one($sql, $id);
}

function update_contact($id, $response) {
    $sql = "UPDATE lienhe SET traloi = ?, ngaytraloi = NOW() WHERE id = ?";
    return pdo_execute($sql, $response, $id);
}

function delete_contact($id) {
    $sql = "DELETE FROM lienhe WHERE id = ?";
    return pdo_execute($sql, $id);
}

function mark_as_read($id) {
    // Since there's no daxem column in the database, we'll just return true
    // If you want to track read status, you'll need to add a daxem column to the database
    return true;
}
?> 