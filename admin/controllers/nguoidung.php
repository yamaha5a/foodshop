<?php
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
        $currentPage = max(1, $currentPage); // Đảm bảo trang hiện tại không nhỏ hơn 1

        // Lấy tổng số người dùng (có thể bao gồm điều kiện tìm kiếm)
        $totalItems = $this->nguoiDungModel->layTongSoNguoiDung($search);
        $totalPages = ceil($totalItems / $this->itemsPerPage);

        // Đảm bảo trang hiện tại không vượt quá tổng số trang
        $currentPage = min($currentPage, $totalPages);

        // Tính offset cho truy vấn
        $offset = ($currentPage - 1) * $this->itemsPerPage;

        // Lấy danh sách người dùng với phân trang và tìm kiếm
        $danhSachNguoiDung = $this->nguoiDungModel->layDanhSachNguoiDungPhanTrang($search, $offset, $this->itemsPerPage);

        // Truyền các biến cần thiết cho view
        $GLOBALS['danhSachNguoiDung'] = $danhSachNguoiDung;
        $GLOBALS['currentPage'] = $currentPage;
        $GLOBALS['totalPages'] = $totalPages;
        $GLOBALS['search'] = $search;

        include __DIR__ . '/../views/nguoidung/list.php';
    }

    public function layTenQuyen($id) {
        $sql = "SELECT tenquyen FROM phanquyen WHERE id = ?";
        return pdo_query_value($sql, $id); // Hàm này cần được định nghĩa trong pdo_functions
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten = trim($_POST['ten']);
            $email = trim($_POST['email']);
            $matkhau = trim($_POST['matkhau']);
            $id_phanquyen = $_POST['id_phanquyen'];

            if (empty($ten) || empty($email) || empty($matkhau) || empty($id_phanquyen)) {
                error_log("Một trong các trường nhập không hợp lệ.");
                return;
            }
            $hinhanh = '';
            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
                $uploadDir = __DIR__ . '/../public/img/nguoidung/';
                $tenHinh = basename($_FILES['hinhanh']['name']);
                $hinhanh = "img/nguoidung/" . $tenHinh;
                $target_file = $uploadDir . $tenHinh;

                if (!move_uploaded_file($_FILES['hinhanh']['tmp_name'], $target_file)) {
                    error_log("Lỗi upload hình ảnh.");
                }
            }
            $this->nguoiDungModel->themNguoiDung($ten, $email, $matkhau, $hinhanh, $id_phanquyen);
            if (ob_get_length()) {
                ob_clean(); 
            }
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=nguoidung">';
            exit();
        }
        include __DIR__ . '/../views/nguoidung/add.php';
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
            header("Location: index.php?act=nguoidung");
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
    
            // Gọi hàm cập nhật người dùng trong model
            $this->nguoiDungModel->capNhatNguoiDung($id, $ten, $email, $sodienthoai, $hinhanh, $id_phanquyen, $trangthai);
    
            // Thông báo và chuyển trang
            $_SESSION['thongbao'] = "Cập nhật thành công!";
            header("Location: index.php?act=nguoidung");
            exit();
        }
    
        // Nếu là GET, hiển thị form cập nhật
        include 'views/nguoidung/update.php';
    }
    
  
}
?>