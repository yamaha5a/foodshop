<?php
require_once __DIR__ . '/../check_auth.php';
require_once __DIR__ . '/../Models/sanphamgiamgia.php';

class SanPhamGiamGiaController {
    private $sanPhamGiamGiaModel;

    public function __construct() {
        $this->sanPhamGiamGiaModel = new SanPhamGiamGiaModel();
    }

    public function index() {
        // Xử lý phân trang và tìm kiếm
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $kyw = isset($_GET['kyw']) ? $_GET['kyw'] : '';
        $limit = 10;

        $danhSachGiamGia = $this->sanPhamGiamGiaModel->getAllSanPhamGiamGia($page, $limit, $kyw);
        $totalItems = $this->sanPhamGiamGiaModel->getTotalSanPhamGiamGia($kyw);
        $soTrang = ceil($totalItems / $limit);

        include __DIR__ . '/../Views/sanphamgiamgia/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_sanpham = $_POST['id_sanpham'] ?? '';
            $giagiam = $_POST['giagiam'] ?? '';
            $ngay_giamgia = $_POST['ngay_giamgia'] ?? date('Y-m-d');

            if ($this->sanPhamGiamGiaModel->addSanPhamGiamGia($id_sanpham, $giagiam, $ngay_giamgia)) {
                $_SESSION['thongbao'] = "Thêm sản phẩm giảm giá thành công!";
            } else {
                $_SESSION['thongbao'] = "Thêm sản phẩm giảm giá thành công!";
            }
            echo "<script>window.location.href='index.php?act=sanphamgiamgia';</script>";
            exit;
        }

        // Lấy danh sách sản phẩm để hiển thị trong form
        $danhSachSanPham = $this->sanPhamGiamGiaModel->getAllSanPham();
        include __DIR__ . '/../Views/sanphamgiamgia/add.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            echo "<script>window.location.href='index.php?act=sanphamgiamgia';</script>";
            exit;
        }

        $id = $_GET['id'];
        $giamgia = $this->sanPhamGiamGiaModel->getSanPhamGiamGiaById($id);

        // Kiểm tra xem sản phẩm có đơn hàng đang xử lý không
        if ($this->sanPhamGiamGiaModel->kiemTraSanPhamGiamGiaCoDonHang($id)) {
            $_SESSION['thongbao'] = "Không thể sửa sản phẩm giảm giá vì sản phẩm đang có trong đơn hàng đang xử lý!";
            echo "<script>window.location.href='index.php?act=sanphamgiamgia';</script>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_sanpham = $_POST['id_sanpham'] ?? '';
            $giagiam = $_POST['giagiam'] ?? '';
            $ngay_giamgia = $_POST['ngay_giamgia'] ?? date('Y-m-d');

            // Kiểm tra lại trước khi cập nhật
            if ($this->sanPhamGiamGiaModel->kiemTraSanPhamGiamGiaCoDonHang($id)) {
                $_SESSION['thongbao'] = "Không thể sửa sản phẩm giảm giá vì sản phẩm đang có trong đơn hàng đang xử lý!";
            } else if ($this->sanPhamGiamGiaModel->updateSanPhamGiamGia($id, $id_sanpham, $giagiam, $ngay_giamgia)) {
                $_SESSION['thongbao'] = "Cập nhật sản phẩm giảm giá thành công!";
            } else {
                $_SESSION['thongbao'] = "Cập nhật sản phẩm giảm giá thất bại!";
            }
            echo "<script>window.location.href='index.php?act=sanphamgiamgia';</script>";
            exit;
        }

        $danhSachSanPham = $this->sanPhamGiamGiaModel->getAllSanPham();
        include __DIR__ . '/../Views/sanphamgiamgia/edit.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->sanPhamGiamGiaModel->kiemTraSanPhamGiamGiaCoDonHang($id)) {
                $_SESSION['thongbaoxoa'] = "Không thể xóa sản phẩm giảm giá vì sản phẩm đang có trong đơn hàng đang xử lý!";
            } else if ($this->sanPhamGiamGiaModel->deleteSanPhamGiamGia($id)) {
                $_SESSION['thongbaoxoa'] = "Xóa sản phẩm giảm giá thành công!";
            } else {
                $_SESSION['thongbaoxoa'] = "Xóa sản phẩm giảm giá thất bại!";
            }
        }
        echo "<script>window.location.href='index.php?act=sanphamgiamgia';</script>";
        exit;
    }
}