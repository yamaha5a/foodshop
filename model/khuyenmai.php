<?php
require_once 'connection.php';

class KhuyenMaiModel {
    public function getDiscountByCode($code) {
        $sql = "SELECT * FROM khuyenmai WHERE tenkhuyenmai = ?";
        return pdo_query_one($sql, $code);
    }

    public function getAllDiscounts() {
        $sql = "SELECT * FROM khuyenmai ORDER BY ngaybatdau DESC";
        return pdo_query($sql);
    }

    public function addDiscount($data) {
        $sql = "INSERT INTO khuyenmai (tenkhuyenmai, giatrigiam, ngaybatdau, ngayketthuc, trangthai) 
                VALUES (?, ?, ?, ?, ?)";
        pdo_execute($sql, 
            $data['tenkhuyenmai'],
            $data['giatrigiam'],
            $data['ngaybatdau'],
            $data['ngayketthuc'],
            $data['trangthai']
        );
    }

    public function updateDiscount($id, $data) {
        $sql = "UPDATE khuyenmai 
                SET tenkhuyenmai = ?, 
                    giatrigiam = ?, 
                    ngaybatdau = ?, 
                    ngayketthuc = ?, 
                    trangthai = ? 
                WHERE id = ?";
        pdo_execute($sql, 
            $data['tenkhuyenmai'],
            $data['giatrigiam'],
            $data['ngaybatdau'],
            $data['ngayketthuc'],
            $data['trangthai'],
            $id
        );
    }

    public function deleteDiscount($id) {
        $sql = "DELETE FROM khuyenmai WHERE id = ?";
        pdo_execute($sql, $id);
    }

    public function getActiveDiscounts() {
        $currentDate = date('Y-m-d');
        $sql = "SELECT * FROM khuyenmai 
                WHERE trangthai = 'Hoạt động' 
                AND ? BETWEEN ngaybatdau AND ngayketthuc";
        return pdo_query($sql, $currentDate);
    }
}
?> 