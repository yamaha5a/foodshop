<?php
require_once __DIR__ . '/../Models/TrangThaiVanChuyen.php';

class TrangThaiVanChuyenController {
    private $model;

    public function __construct() {
        $this->model = new TrangThaiVanChuyen();
    }

    public function index() {
        $danhSachDonHang = $this->model->layDanhSachDonHang();
        if ($danhSachDonHang === false) {
            $_SESSION['error'] = "Không thể lấy danh sách đơn hàng";
            $danhSachDonHang = [];
        }
        require_once __DIR__ . '/../Views/trangthai/list.php';
    }

    public function capNhatTrangThai() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_hoadon = $_POST['id_hoadon'] ?? null;
            $trangthai_moi = $_POST['trangthai'] ?? null;
            
            if ($id_hoadon && $trangthai_moi) {
                if ($this->model->capNhatTrangThai($id_hoadon, $trangthai_moi)) {
                    $_SESSION['success'] = "Cập nhật trạng thái thành công";
                } else {
                    $_SESSION['error'] = "Không thể cập nhật trạng thái";
                }
            } else {
                $_SESSION['error'] = "Thiếu thông tin cần thiết";
            }
            
            echo "<script>window.location.href = 'index.php?act=trangthai';</script>";
            exit();
        }
    }

    public function chiTietDonHang($id) {
        if (!$id) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng";
            echo "<script>window.location.href = 'index.php?act=trangthai';</script>";
            exit();
        }

        $donHang = $this->model->layChiTietDonHang($id);
        if (!$donHang) {
            $_SESSION['error'] = "Không tìm thấy thông tin đơn hàng";
            echo "<script>window.location.href = 'index.php?act=trangthai';</script>";
            exit();
        }

        require_once __DIR__ . '/../Views/trangthai/detail.php';
    }
} 