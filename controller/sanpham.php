<?php
require_once 'model/sanpham.php';
require_once 'model/danhMuc.php';


class sanPhamController
{
    private $sanphamModel;
    private $danhMucModel;

    public function __construct()
    {
        $this->sanphamModel = new SanPham();
        $this->danhMucModel = new danhMuc();
    }

    public function list()
    {
        $sanphams = $this->sanphamModel->get8sp(); // Lấy danh sách sản phẩm

        // Kiểm tra nếu có sản phẩm
        if (!$sanphams) {
            echo 'Không có sản phẩm nào để hiển thị.'; // Thông báo nếu không có sản phẩm
            return; // Dừng hàm nếu không có sản phẩm
        }

        include 'views/home/home.php'; // Bao gồm view nếu có sản phẩm
    }

    public function listProduct()
    {
        $limit = 8;
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($page < 1) $page = 1;
        $start = ($page - 1) * $limit;
    
        $danhMucs = $this->danhMucModel->getAllDanhMuc();
    
        if (isset($_GET['danhmuc'])) {
            $idDanhMuc = (int)$_GET['danhmuc'];
            $sanphams = $this->sanphamModel->getSanPhamByDanhMuc($idDanhMuc, $start, $limit);
            $totalSanPham = $this->sanphamModel->countSanPhamByDanhMuc($idDanhMuc);
        } else {
            $sanphams = $this->sanphamModel->getSanPhamByPage($start, $limit);
            $totalSanPham = $this->sanphamModel->countAllSanPham();
        }
    
        $totalPages = ceil($totalSanPham / $limit);
    
        include 'views/product/product.php';
    }
    
}
