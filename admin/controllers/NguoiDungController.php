<?php
require_once 'admin/models/NguoiDung.php';

class NguoiDungController {
    private $nguoiDungModel;
    private $itemsPerPage = 10;

    public function __construct() {
        $this->nguoiDungModel = new NguoiDung();
    }

    public function index() {
        $search = $_GET['search'] ?? '';
        $currentPage = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
        $offset = ($currentPage - 1) * $this->itemsPerPage;

        $users = $this->nguoiDungModel->layDanhSachNguoiDungPhanTrang($search, $offset, $this->itemsPerPage);
        $totalUsers = $this->nguoiDungModel->layTongSoNguoiDung($search);
        $totalPages = ceil($totalUsers / $this->itemsPerPage);

        require_once 'admin/views/nguoidung/index.php';
    }

    public function them() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoten = $_POST['hoten'] ?? '';
            $email = $_POST['email'] ?? '';
            $matkhau = $_POST['matkhau'] ?? '';

            if (empty($hoten) || empty($email) || empty($matkhau)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
                header('Location: ?page=nguoidung');
                exit;
            }

            if ($this->nguoiDungModel->kiemTraEmailTonTai($email)) {
                $_SESSION['error'] = 'Email đã tồn tại';
                header('Location: ?page=nguoidung');
                exit;
            }

            if ($this->nguoiDungModel->themNguoiDung($hoten, $email, $matkhau)) {
                $_SESSION['success'] = 'Thêm người dùng thành công';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi thêm người dùng';
            }

            header('Location: ?page=nguoidung');
            exit;
        }
    }

    public function sua() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $hoten = $_POST['hoten'] ?? '';
            $email = $_POST['email'] ?? '';
            $matkhau = $_POST['matkhau'] ?? '';

            if (empty($id) || empty($hoten) || empty($email)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
                header('Location: ?page=nguoidung');
                exit;
            }

            if ($this->nguoiDungModel->kiemTraEmailTonTai($email, $id)) {
                $_SESSION['error'] = 'Email đã tồn tại';
                header('Location: ?page=nguoidung');
                exit;
            }

            if ($this->nguoiDungModel->capNhatNguoiDung($id, $hoten, $email, $matkhau)) {
                $_SESSION['success'] = 'Cập nhật người dùng thành công';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật người dùng';
            }

            header('Location: ?page=nguoidung');
            exit;
        }
    }

    public function xoa() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->nguoiDungModel->xoaNguoiDung($id)) {
                $_SESSION['success'] = 'Xóa người dùng thành công';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi xóa người dùng';
            }
        }
        header('Location: ?page=nguoidung');
        exit;
    }

    public function layThongTin() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $user = $this->nguoiDungModel->layThongTinNguoiDung($id);
            if ($user) {
                header('Content-Type: application/json');
                echo json_encode($user);
                exit;
            }
        }
        http_response_code(404);
        echo json_encode(['error' => 'Không tìm thấy người dùng']);
        exit;
    }
} 