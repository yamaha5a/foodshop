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

    // New method to get products without including the view
    public function getProducts()
    {
        $sanphams = $this->sanphamModel->get8sp(); // Lấy danh sách sản phẩm
        return $sanphams;
    }

    public function listProduct()
    {
        $limit = 8;
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($page < 1) $page = 1;
        $start = ($page - 1) * $limit;
    
        $danhMucs = $this->danhMucModel->getAllDanhMuc();
    
        // Get search parameters
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
        $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : PHP_FLOAT_MAX;
    
        // Determine which query to use based on parameters
        if (isset($_GET['danhmuc'])) {
            $idDanhMuc = (int)$_GET['danhmuc'];
            $sanphams = $this->sanphamModel->getSanPhamByDanhMuc($idDanhMuc, $start, $limit);
            $totalSanPham = $this->sanphamModel->countSanPhamByDanhMuc($idDanhMuc);
        } elseif (!empty($keyword) && ($minPrice > 0 || $maxPrice < PHP_FLOAT_MAX)) {
            // Both search and price filter
            $sanphams = $this->sanphamModel->searchAndFilterByPrice($keyword, $minPrice, $maxPrice, $start, $limit);
            $totalSanPham = $this->sanphamModel->countSearchAndFilterByPrice($keyword, $minPrice, $maxPrice);
        } elseif (!empty($keyword)) {
            // Only search
            $sanphams = $this->sanphamModel->searchSanPham($keyword, $start, $limit);
            $totalSanPham = $this->sanphamModel->countSearchSanPham($keyword);
        } elseif ($minPrice > 0 || $maxPrice < PHP_FLOAT_MAX) {
            // Only price filter
            $sanphams = $this->sanphamModel->filterByPrice($minPrice, $maxPrice, $start, $limit);
            $totalSanPham = $this->sanphamModel->countFilterByPrice($minPrice, $maxPrice);
        } else {
            // Default: get all products
            $sanphams = $this->sanphamModel->getSanPhamByPage($start, $limit);
            $totalSanPham = $this->sanphamModel->countAllSanPham();
        }
    
        $totalPages = ceil($totalSanPham / $limit);
    
        // Pass search parameters to view
        $searchParams = [
            'keyword' => $keyword,
            'min_price' => $minPrice,
            'max_price' => $maxPrice
        ];

        include 'views/product/product.php';
    }
    
}
