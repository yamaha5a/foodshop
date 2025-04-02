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

    public function chiTietNguoiDung($id) {
        $nguoiDung = $this->nguoiDungModel->layNguoiDungTheoID($id);
        
        if (!$nguoiDung) {
            die("Không tìm thấy người dùng!"); 
        }
        
        include __DIR__ . '/../views/nguoidung/detail.php'; 
    }
    public function capNhatNguoiDung() {
        // Kiểm tra xem có dữ liệu được gửi lên hay không
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST); // Kiểm tra dữ liệu đã gửi
        exit; // Dừ
            // Lấy dữ liệu từ form  
            $id = $_POST['id'] ?? null;
            $ten = $_POST['ten'] ?? null;
            $email = $_POST['email'] ?? null;
            $sodienthoai = $_POST['sodienthoai'] ?? null;
            $hinhanh = $_POST['hinhanh'] ?? null; // Xử lý upload hình ảnh nếu cần
            $id_phanquyen = $_POST['id_phanquyen'] ?? null;
            $trangthai = $_POST['trangthai'] ?? null;
    
            // Kiểm tra dữ liệu hợp lệ
            if ($id && $ten && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Gọi hàm cập nhật người dùng trong model
                $this->nguoiDungModel->capNhatNguoiDung($id, $ten, $email, $sodienthoai, $hinhanh, $id_phanquyen, $trangthai);
    
                // Chuyển hướng về trang danh sách người dùng hoặc thông báo thành công
                header("Location: danh_sach_nguoi_dung.php?msg=CapNhatThanhCong");
                exit();
            } else {
                // Xử lý lỗi nếu dữ liệu không hợp lệ
                header("Location: cap_nhat_nguoi_dung.php?id=$id&msg=DuLieuKhongHopLe");
                exit();
            }
        } else {
            // Nếu không phải là yêu cầu POST, chuyển hướng về trang danh sách
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=nguoidung">';
            exit();
        }
    }
    
}

// Khởi tạo controller và gọi hàm cập nhật
?>
