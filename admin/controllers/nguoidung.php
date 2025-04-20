<?php
require_once __DIR__ . '/../check_auth.php';
require_once __DIR__ . '/../models/NguoiDung.php'; // Sử dụng đường dẫn tuyệt đối

class NguoiDungController {
    private $nguoiDungModel;
    private $itemsPerPage = 10; // Số item trên mỗi trang

    public function __construct() {
        $this->nguoiDungModel = new NguoiDung();
    }

    public function danhSach() {
        // Lấy tham số tìm kiếm và trang hiện tại
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Đảm bảo trang hiện tại không nhỏ hơn 1
        $currentPage = max(1, $currentPage);

        // Lấy tổng số người dùng (có thể bao gồm điều kiện tìm kiếm)
        $totalItems = $this->nguoiDungModel->layTongSoNguoiDung($search);
        $totalPages = ceil($totalItems / $this->itemsPerPage);

        // Đảm bảo trang hiện tại không vượt quá tổng số trang
        $currentPage = min($currentPage, $totalPages);

        // Tính offset cho truy vấn, đảm bảo không âm
        $offset = max(0, ($currentPage - 1) * $this->itemsPerPage);

        // Lấy danh sách người dùng với phân trang và tìm kiếm
        $danhSachNguoiDung = $this->nguoiDungModel->layDanhSachNguoiDungPhanTrang($search, $offset, $this->itemsPerPage);

        // Truyền các biến cần thiết cho view
        $GLOBALS['danhSachNguoiDung'] = $danhSachNguoiDung;
        $GLOBALS['currentPage'] = $currentPage;
        $GLOBALS['totalPages'] = $totalPages;
        $GLOBALS['search'] = $search;

        include __DIR__ . '/../views/nguoidung/list.php';
    }
    public function chiTietNguoiDung() {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            die("Thiếu ID người dùng!");
        }
    
        $nguoiDung = $this->nguoiDungModel->layNguoiDungTheoID($id);
        
        if (!$nguoiDung) {
            die("Không tìm thấy người dùng!"); 
        }
    
        include __DIR__ . '/../views/nguoidung/detail.php'; 
    }
    
    public function capNhatNguoiDung() {
        $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
        if (!$id) {
            // Nếu không có id thì quay lại danh sách
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=nguoidung">';
            exit();
        }
    
        // Lấy dữ liệu người dùng theo ID
        $nguoiDung = $this->nguoiDungModel->layNguoiDungTheoId($id);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $ten = $_POST['ten'] ?? $nguoiDung['ten'];
            $email = $_POST['email'] ?? $nguoiDung['email'];
            $sodienthoai = $_POST['sodienthoai'] ?? $nguoiDung['sodienthoai'];
            $hinhanh = $_POST['hinhanh'] ?? $nguoiDung['hinhanh'];
            $id_phanquyen = $_POST['id_phanquyen'] ?? $nguoiDung['id_phanquyen'];
            $trangthai = $_POST['trangthai'] ?? $nguoiDung['trangthai'];
            
            // Xử lý upload file ảnh mới nếu có
            if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] == 0) {
                $uploadDir = __DIR__ . '/../public/img/nguoidung/';
                
                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Lấy tên file và tạo tên file mới
                $tenHinh = basename($_FILES['fileInput']['name']);
                $timestamp = time();
                $tenHinhMoi = $timestamp . '_' . $tenHinh;
                
                // Đường dẫn đầy đủ để lưu file
                $target_file = $uploadDir . $tenHinhMoi;
                
                // Đường dẫn tương đối để lưu vào database
                $hinhanh = "img/nguoidung/" . $tenHinhMoi;
                
                // Upload file
                if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $target_file)) {
                    // Xóa file ảnh cũ nếu có
                    if (!empty($nguoiDung['hinhanh'])) {
                        $oldFile = __DIR__ . '/../public/' . $nguoiDung['hinhanh'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                } else {
                    error_log("Lỗi upload hình ảnh: " . $_FILES['fileInput']['error']);
                }
            }
    
            // Gọi hàm cập nhật người dùng trong model
            $this->nguoiDungModel->capNhatNguoiDung($id, $ten, $email, $sodienthoai, $hinhanh, $id_phanquyen, $trangthai);
    
            // Thông báo thành công
            $_SESSION['thongbao'] = "Cập nhật thành công!";
            
            // Lấy lại dữ liệu người dùng đã cập nhật
            $nguoiDung = $this->nguoiDungModel->layNguoiDungTheoId($id);
            
            // Hiển thị form cập nhật với thông báo
            include 'views/nguoidung/update.php';
            exit();
        }
    
        // Nếu là GET, hiển thị form cập nhật
        include 'views/nguoidung/update.php';
    }
    
    public function layTenQuyen($id) {
        return $this->nguoiDungModel->layTenQuyen($id);
    }
}
?>