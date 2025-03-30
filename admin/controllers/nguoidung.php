<?php
require_once __DIR__ . '/../models/NguoiDung.php'; // Sử dụng đường dẫn tuyệt đối

class NguoiDungController {
    private $nguoiDungModel;

    public function __construct() {
        $this->nguoiDungModel = new NguoiDung();
    }

    public function danhSach() {
        $danhSachNguoiDung = $this->nguoiDungModel->layDanhSachNguoiDung();
        include __DIR__ . '/../views/nguoidung/list.php'; 
    }

    public function layTenQuyen($id) {
        $sql = "SELECT tenquyen FROM phanquyen WHERE id = ?";
        return pdo_query_value($sql, $id); // Hàm này cần được định nghĩa trong pdo_functions
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $ten = trim($_POST['ten']);
            $email = trim($_POST['email']);
            $matkhau = trim($_POST['matkhau']);
            $id_phanquyen = $_POST['id_phanquyen'];

            // Kiểm tra dữ liệu hợp lệ
            if (empty($ten) || empty($email) || empty($matkhau) || empty($id_phanquyen)) {
                error_log("Một trong các trường nhập không hợp lệ.");
                return;
            }

            // Xử lý hình ảnh
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

            // Thêm người dùng vào cơ sở dữ liệu (BỎ SỐ ĐIỆN THOẠI & GIỚI TÍNH)
            $this->nguoiDungModel->themNguoiDung($ten, $email, $matkhau, $hinhanh, $id_phanquyen);
            if (ob_get_length()) {
                ob_clean(); // Xóa toàn bộ dữ liệu đã xuất ra trước đó
            }
            // Chuyển hướng về danh sách người dùng
            header("Location: index.php?act=nguoidung");
            exit();
        }
        include __DIR__ . '/../views/nguoidung/add.php';
    }

    public function chiTietNguoiDung($id) {
        // Lấy thông tin chi tiết người dùng theo ID
        $nguoiDung = $this->nguoiDungModel->layNguoiDungTheoID($id);
        
        if (!$nguoiDung) {
            die("Không tìm thấy người dùng!"); // Kiểm tra nếu không có dữ liệu
        }
        
        include __DIR__ . '/../views/nguoidung/detail.php'; 
    }
    public function xoaNguoiDung($id) {
        if (!is_numeric($id)) {
            die("ID không hợp lệ!");
        }
    
        // Xóa người dùng
        $this->nguoiDungModel->xoaNguoiDungTheoID($id);
    
        // Ngăn lỗi output trước khi chuyển hướng
        if (ob_get_length()) {
            ob_end_clean(); // Xóa dữ liệu đã xuất ra trước đó
        }
    
        // Chuyển hướng về danh sách người dùng
        header("Location: index.php?act=nguoidung");
        exit();
    }
    public function capNhatNguoiDung() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $ten = trim($_POST['ten']);
            $email = trim($_POST['email']);
            $sdt = trim($_POST['sdt']);
            $id_phanquyen = $_POST['id_phanquyen'];
            $trangthai = $_POST['trangthai'];
            $hinhanh = $_POST['hinhanh']; 

            if (!empty($_FILES['hinhanh']['name'])) {
                $uploadDir = __DIR__ . '/../public/img/nguoidung/';
                $tenHinh = basename($_FILES['hinhanh']['name']);
                $hinhanh = "img/nguoidung/" . $tenHinh;
                move_uploaded_file($_FILES['hinhanh']['tmp_name'], $uploadDir . $tenHinh);
            }

            $this->nguoiDungModel->capNhatNguoiDung($id, $ten, $email, $sdt, $hinhanh, $id_phanquyen, $trangthai);

            if (ob_get_length()) {
                ob_clean();
            }

            header("Location: index.php?act=nguoidung");
            exit();
        }
        include __DIR__ . '/../views/nguoidung/update.php';
    }
}
?>
