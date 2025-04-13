<?php
require_once 'connection.php';

class NguoiDungModel {
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=shopfood", "root", "");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getUsers($page = 1, $perPage = 8, $search = '') {
        try {
            $offset = ($page - 1) * $perPage;
            
            $query = "SELECT n.*, p.tenquyen 
                     FROM nguoidung n 
                     LEFT JOIN phanquyen p ON n.id_phanquyen = p.id 
                     WHERE 1=1";
            
            if (!empty($search)) {
                $query .= " AND (n.ten LIKE :search OR n.email LIKE :search)";
            }
            
            $query .= " ORDER BY n.id DESC LIMIT :offset, :perPage";
            
            $stmt = $this->conn->prepare($query);
            
            if (!empty($search)) {
                $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getTotalUsers($search = '') {
        try {
            $query = "SELECT COUNT(*) as total FROM nguoidung WHERE 1=1";
            
            if (!empty($search)) {
                $query .= " AND (ten LIKE :search OR email LIKE :search)";
            }
            
            $stmt = $this->conn->prepare($query);
            
            if (!empty($search)) {
                $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return 0;
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
}
