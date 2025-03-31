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
            header("Location: index.php?act=nguoidung");
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
