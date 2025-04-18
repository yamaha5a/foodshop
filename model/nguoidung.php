<?php
require_once 'connection.php';

class NguoiDungModel {
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=shopfood", "root", "");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getUsers($search = '') {
        try {
            $query = "SELECT n.*, p.tenquyen 
                     FROM nguoidung n 
                     LEFT JOIN phanquyen p ON n.id_phanquyen = p.id 
                     WHERE 1=1";
            
            if (!empty($search)) {
                $query .= " AND (n.ten LIKE :search OR n.email LIKE :search)";
            }
            
            $query .= " ORDER BY n.id DESC";
            
            $stmt = $this->conn->prepare($query);
            
            if (!empty($search)) {
                $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    public function dangNhap($email) {
        $sql = "SELECT * FROM nguoidung WHERE email = ?";
        return pdo_query_one($sql, $email);
    }

    public function dangKy($ten, $email, $matkhau, $sodienthoai, $diachi,  $gioitinh, $id_phanquyen) {
        try {
            $sql = "INSERT INTO nguoidung (ten, email, matkhau, sodienthoai, diachi, gioitinh, id_phanquyen)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            pdo_execute($sql, $ten, $email, $matkhau, $sodienthoai, $diachi, $gioitinh, $id_phanquyen);
            return true;
        } catch (PDOException $e) {
            echo "<pre>Lỗi DB: " . $e->getMessage() . "</pre>";
            return false;
        }
    }

    public function getUserById($id) {
        try {
            $sql = "SELECT * FROM nguoidung WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getCommentHistory($userId) {
        try {
            $sql = "SELECT b.*, s.tensanpham, s.hinhanh1 as hinhanh 
                    FROM binhluan b 
                    JOIN sanpham s ON b.id_sanpham = s.id 
                    WHERE b.id_nguoidung = ? 
                    ORDER BY b.ngaydang DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function capNhatMatKhau($id, $matkhau) {
        try {
            $sql = "UPDATE nguoidung SET matkhau = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([password_hash($matkhau, PASSWORD_DEFAULT), $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateAvatar($userId, $avatarPath) {
        $sql = "UPDATE nguoidung SET hinhanh = ? WHERE id = ?";
        return pdo_execute($sql, $avatarPath, $userId);
    }
}
