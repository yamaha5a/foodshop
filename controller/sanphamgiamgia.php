<?php
require_once 'model/sanphamgiamgia.php';
require_once 'model/sanpham.php';

class SanPhamGiamGiaController
{
    private $sanPhamGiamGiaModel;
    private $sanPhamModel;

    public function __construct()
    {
        $this->sanPhamGiamGiaModel = new SanPhamGiamGia();
        $this->sanPhamModel = new SanPham();
    }

    // Hiển thị danh sách sản phẩm giảm giá trên trang chủ
    public function listDiscountProducts()
    {
        // Lấy 6 sản phẩm giảm giá mới nhất
        $sanphamgiamgia = $this->sanPhamGiamGiaModel->getSanPhamGiamGiaByLimit(6);
        
        // Lấy danh sách sản phẩm thông thường
        $sanphams = $this->sanPhamModel->get8sp();
        
        // Bao gồm view
        include 'views/home/home.php';
    }

    // New method to get discount products without including the view
    public function getDiscountProducts()
    {
        // Lấy 6 sản phẩm giảm giá mới nhất
        $sanphamgiamgia = $this->sanPhamGiamGiaModel->getSanPhamGiamGiaByLimit(6);
        return $sanphamgiamgia;
    }

    // Hiển thị tất cả sản phẩm giảm giá
    public function listAllDiscountProducts()
    {
        $sanphamgiamgia = $this->sanPhamGiamGiaModel->getAll();
        include 'views/product/discount.php';
    }

    // Thêm sản phẩm giảm giá (cho admin)
    public function addDiscountProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_sanpham = $_POST['id_sanpham'] ?? 0;
            $giagiam = $_POST['giagiam'] ?? 0;
            $ngay_giamgia = $_POST['ngay_giamgia'] ?? date('Y-m-d');

            if ($this->sanPhamGiamGiaModel->addSanPhamGiamGia($id_sanpham, $giagiam, $ngay_giamgia)) {
                $_SESSION['success_message'] = "Thêm sản phẩm giảm giá thành công!";
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi thêm sản phẩm giảm giá!";
            }
            
            header("Location: index.php?page=admin&action=discount");
            exit;
        }
    }

    // Cập nhật sản phẩm giảm giá (cho admin)
    public function updateDiscountProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $giagiam = $_POST['giagiam'] ?? 0;
            $ngay_giamgia = $_POST['ngay_giamgia'] ?? date('Y-m-d');

            if ($this->sanPhamGiamGiaModel->updateSanPhamGiamGia($id, $giagiam, $ngay_giamgia)) {
                $_SESSION['success_message'] = "Cập nhật sản phẩm giảm giá thành công!";
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi cập nhật sản phẩm giảm giá!";
            }
            
            header("Location: index.php?page=admin&action=discount");
            exit;
        }
    }

    // Xóa sản phẩm giảm giá (cho admin)
    public function deleteDiscountProduct()
    {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            
            if ($this->sanPhamGiamGiaModel->deleteSanPhamGiamGia($id)) {
                $_SESSION['success_message'] = "Xóa sản phẩm giảm giá thành công!";
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi xóa sản phẩm giảm giá!";
            }
            
            header("Location: index.php?page=admin&action=discount");
            exit;
        }
    }
} 