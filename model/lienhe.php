<?php
require_once 'connection.php';

class LienHeModel {
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=shopfood", "root", "");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Thêm liên hệ mới vào database
     * @param int $nguoidung_id ID của người dùng gửi liên hệ
     * @param string $tieude Tiêu đề liên hệ
     * @param string $noidung Nội dung liên hệ
     * @return bool Kết quả thêm liên hệ
     */
    public function themLienHe($nguoidung_id, $tieude, $noidung) {
        try {
            $sql = "INSERT INTO lienhe (nguoidung_id, tieude, noidung) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$nguoidung_id, $tieude, $noidung]);
        } catch (PDOException $e) {
            error_log("Lỗi thêm liên hệ: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy danh sách liên hệ của người dùng
     * @param int $nguoidung_id ID của người dùng
     * @return array Danh sách liên hệ
     */
    public function getLienHeByUserId($nguoidung_id) {
        try {
            $sql = "SELECT * FROM lienhe WHERE nguoidung_id = ? ORDER BY ngaygui DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$nguoidung_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy liên hệ: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy chi tiết liên hệ theo ID
     * @param int $id ID của liên hệ
     * @return array|null Thông tin liên hệ
     */
    public function getLienHeById($id) {
        try {
            $sql = "SELECT l.*, n.ten as ten_nguoidung, n.email 
                    FROM lienhe l 
                    JOIN nguoidung n ON l.nguoidung_id = n.id 
                    WHERE l.id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy chi tiết liên hệ: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cập nhật trả lời cho liên hệ
     * @param int $id ID của liên hệ
     * @param string $traloi Nội dung trả lời
     * @return bool Kết quả cập nhật
     */
    public function capNhatTraloi($id, $traloi) {
        try {
            $sql = "UPDATE lienhe SET traloi = ?, ngaytraloi = CURRENT_TIMESTAMP WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$traloi, $id]);
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật trả lời: " . $e->getMessage());
            return false;
        }
    }
} 