<?php
require_once __DIR__ . '/../Models/sanphamgiamgia.php';

class SanPhamGiamGiaController {
    private $sanPhamGiamGiaModel;

    public function __construct() {
        $this->sanPhamGiamGiaModel = new SanPhamGiamGiaModel();
    }

    public function index() {
        // Xử lý phân trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;

        $danhSachGiamGia = $this->sanPhamGiamGiaModel->getAllSanPhamGiamGia($page, $limit);
        $totalItems = $this->sanPhamGiamGiaModel->getTotalSanPhamGiamGia();
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_sanpham = $_POST['id_sanpham'] ?? '';
            $giagiam = $_POST['giagiam'] ?? '';
            $ngay_giamgia = $_POST['ngay_giamgia'] ?? date('Y-m-d');

            if ($this->sanPhamGiamGiaModel->updateSanPhamGiamGia($id, $id_sanpham, $giagiam, $ngay_giamgia)) {
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
            if ($this->sanPhamGiamGiaModel->deleteSanPhamGiamGia($id)) {
                $_SESSION['thongbaoxoa'] = "Xóa sản phẩm giảm giá thành công!";
            } else {
                $_SESSION['thongbaoxoa'] = "Xóa sản phẩm giảm giá thất bại!";
            }
        }
        echo "<script>window.location.href='index.php?act=sanphamgiamgia';</script>";
        exit;
    }
}