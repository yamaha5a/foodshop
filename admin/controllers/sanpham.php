<?php
require_once 'Models/sanpham.php'; // Đảm bảo model đã được bao gồm

class SanPhamController {
    private $sanPhamModel;

    public function __construct() {
        $this->sanPhamModel = new SanPhamModel();
    } // Đóng hàm khởi tạo

    public function list() {
        $danhSachSanPham = $this->sanPhamModel->layTatCaSanPham(); 
        include 'views/sanpham/list.php'; 
    }

    // Thêm sản phẩm
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tensanpham = $_POST['tensanpham'];
            $mota = $_POST['mota'];
            $gia = $_POST['gia'];
            $soluong = $_POST['soluong'];
            $hinhanh1 = $_POST['hinhanh1'];
            $hinhanh2 = $_POST['hinhanh2'];
            $hinhanh3 = $_POST['hinhanh3'];
            $id_danhmuc = $_POST['id_danhmuc'];
            $id_loaisanpham = $_POST['id_loaisanpham'];
            $trangthai = $_POST['trangthai'];

            $this->sanPhamModel->themSanPham($tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $trangthai);
            $_SESSION['thongbao'] = "Thêm sản phẩm thành công!";
            header("Location: index.php?act=sanpham");
            exit();
        }
        include 'views/sanpham/add.php'; // Bao gồm view thêm sản phẩm
    }

    // Chi tiết sản phẩm
    public function detail($id) {
        $sanPham = $this->sanPhamModel->laySanPhamTheoID($id);
        if (!$sanPham) {
            die("Không tìm thấy sản phẩm!");
        }
        include 'views/sanpham/detail.php'; // Bao gồm view chi tiết sản phẩm
    }

    // Cập nhật sản phẩm
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $tensanpham = $_POST['tensanpham'];
            $mota = $_POST['mota'];
            $gia = $_POST['gia'];
            $soluong = $_POST['soluong'];
            $hinhanh1 = $_POST['hinhanh1'];
            $hinhanh2 = $_POST['hinhanh2'];
            $hinhanh3 = $_POST['hinhanh3'];
            $id_danhmuc = $_POST['id_danhmuc'];
            $id_loaisanpham = $_POST['id_loaisanpham'];
            $trangthai = $_POST['trangthai'];

            $this->sanPhamModel->capNhatSanPham($id, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $trangthai);
            $_SESSION['thongbao'] = "Cập nhật sản phẩm thành công!";
            header("Location: index.php?act=sanpham");
            exit();
        }

        $sanPham = $this->sanPhamModel->laySanPhamTheoID($id);
        if (!$sanPham) {
            die("Không tìm thấy sản phẩm!");
        }
        include 'views/sanpham/edit.php'; // Bao gồm view cập nhật sản phẩm
    }

    // Xóa sản phẩm
    public function delete($id) {
        $this->sanPhamModel->xoaSanPham($id);
        $_SESSION['thongbao'] = "Xóa sản phẩm thành công!";
        header("Location: index.php?act=sanpham");
        exit();
    }
} 

// Đóng lớp SanPhamController
?>
