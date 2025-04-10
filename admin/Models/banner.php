<?php
require_once "connection.php";

class Banner {
    private $conn;

    public function __construct() {
        $this->conn = pdo_get_connection(); // Khởi tạo kết nối database

        if (!$this->conn) {
            die("Lỗi: Không thể kết nối database.");
        }
    }

    public function getAllBanners() {
        $sql = "SELECT * FROM banner";
        return pdo_query($sql);
    }

    public function addBanner($hinhanh) {
        $sql = "INSERT INTO banner (hinhanh) VALUES (?)";
        pdo_execute($sql, $hinhanh);
    }

    public function updateBanner($id, $hinhanh, $lienket) {
        $sql = "UPDATE banner SET hinhanh = ?, lienket = ? WHERE id = ?";
        pdo_execute($sql, $hinhanh, $lienket, $id);
    }

    public function deleteBanner($id) {
        // Kiểm tra kết nối có tồn tại không
        if ($this->conn === null) {
            die("Lỗi: Không có kết nối đến database.");
        }
    
        // Lấy đường dẫn ảnh từ database trước khi xóa
        $sql = "SELECT hinhanh FROM banner WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $banner = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Xóa file ảnh nếu tồn tại
        if ($banner && !empty($banner['hinhanh'])) {
            // Đường dẫn đầy đủ đến file ảnh trong thư mục
            $filePath = __DIR__ . "/../../public/img/banner/" . $banner['hinhanh'];
            if (file_exists($filePath)) {
                // Xóa file ảnh
                unlink($filePath);
            }
        }
    
        // Xóa banner trong database
        $sql = "DELETE FROM banner WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
    
    }
?>
