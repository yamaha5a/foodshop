<?php
require_once "connection.php"; // Đảm bảo thay đổi đường dẫn cho đúng

class NguoiDung {
    public function layDanhSachNguoiDung() {
        $sql = "SELECT * FROM nguoidung"; // Truy vấn để lấy danh sách người dùng
        return pdo_query($sql); // Gọi hàm pdo_query để thực hiện truy vấn
    }

    public function themNguoiDung($ten, $email, $matkhau, $hinhanh, $id_phanquyen) {
        $sql = "INSERT INTO nguoidung (ten, email, matkhau, hinhanh, id_phanquyen) VALUES (?, ?, ?, ?, ?)";
        try {
            pdo_execute($sql, $ten, $email, password_hash($matkhau, PASSWORD_DEFAULT), $hinhanh, $id_phanquyen);
            error_log("Thêm người dùng thành công: Tên: $ten, Email: $email");
        } catch (PDOException $e) {
            error_log("Lỗi thêm người dùng: " . $e->getMessage()); // Ghi log lỗi
        }
    }
    public function layNguoiDungTheoID($id) {
        $sql = "SELECT * FROM nguoidung WHERE id = ?";
        return pdo_query_one($sql, $id);
    }
    public function capNhatNguoiDung($id, $ten, $email, $sodienthoai, $hinhanh, $id_phanquyen, $trangthai) {
        $sql = "UPDATE nguoidung SET ten = ?, email = ?, sodienthoai = ?, id_phanquyen = ?, trangthai = ?, hinhanh = ? WHERE id = ?";
        return pdo_execute($sql, $ten, $email, $sodienthoai, $id_phanquyen, $trangthai, $hinhanh, $id);
    }
        
}
?>