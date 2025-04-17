<?php
require_once 'connection.php';

class KhuyenMaiModel {
    public function getDiscountByCode($code) {
        $sql = "SELECT * FROM khuyenmai WHERE makm = ?";
        return pdo_query_one($sql, $code);
    }

    public function getAllDiscounts() {
        $sql = "SELECT * FROM khuyenmai ORDER BY ngaybatdau DESC";
        return pdo_query($sql);
    }

    public function getActiveDiscounts() {
        $currentDate = date('Y-m-d');
        $sql = "SELECT * FROM khuyenmai 
                WHERE trangthai = 'Hoạt động' 
                AND ngaybatdau <= ? 
                AND ngayketthuc >= ?
                ORDER BY ngaybatdau DESC";
        return pdo_query($sql, $currentDate, $currentDate);
    }

    public function addDiscount($data) {
        $sql = "INSERT INTO khuyenmai (makm, tenkhuyenmai, giatrigiam, ngaybatdau, ngayketthuc, trangthai) 
                VALUES (?, ?, ?, ?, ?, ?)";
        return pdo_execute($sql, 
            $data['makm'],
            $data['tenkhuyenmai'],
            $data['giatrigiam'],
            $data['ngaybatdau'],
            $data['ngayketthuc'],
            $data['trangthai'] ?? 'Hoạt động'
        );
    }

    public function updateDiscount($id, $data) {
        $sql = "UPDATE khuyenmai 
                SET makm = ?, 
                    tenkhuyenmai = ?, 
                    giatrigiam = ?, 
                    ngaybatdau = ?, 
                    ngayketthuc = ?, 
                    trangthai = ? 
                WHERE id = ?";
        return pdo_execute($sql, 
            $data['makm'],
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
        return pdo_execute($sql, $id);
    }
}
?>
