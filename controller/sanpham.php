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
        $featuredDiscountedProducts = $this->sanphamModel->getDiscountedProducts(4);
    
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
    
    public function getSanPhamByPriceAsc()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $start = ($page - 1) * $limit;
        
        $sanPhamModel = new SanPham();
        $totalProducts = $sanPhamModel->countAll();
        $totalPages = ceil($totalProducts / $limit);
        
        $products = $sanPhamModel->getSanPhamByPriceAsc($start, $limit);
        
        include 'views/product/product.php';
    }

    public function getSanPhamByPriceDesc()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $start = ($page - 1) * $limit;
        
        $sanPhamModel = new SanPham();
        $totalProducts = $sanPhamModel->countAll();
        $totalPages = ceil($totalProducts / $limit);
        
        $products = $sanPhamModel->getSanPhamByPriceDesc($start, $limit);
        
        include 'views/product/product.php';
    }

    public function getSanPhamByDanhMucAndPriceAsc($idDanhMuc)
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $start = ($page - 1) * $limit;
        
        $sanPhamModel = new SanPham();
        $totalProducts = $sanPhamModel->countByDanhMuc($idDanhMuc);
        $totalPages = ceil($totalProducts / $limit);
        
        $products = $sanPhamModel->getSanPhamByDanhMucAndPriceAsc($idDanhMuc, $start, $limit);
        
        include 'views/product/product.php';
    }

    public function getSanPhamByDanhMucAndPriceDesc($idDanhMuc)
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $start = ($page - 1) * $limit;
        
        $sanPhamModel = new SanPham();
        $totalProducts = $sanPhamModel->countByDanhMuc($idDanhMuc);
        $totalPages = ceil($totalProducts / $limit);
        
        $products = $sanPhamModel->getSanPhamByDanhMucAndPriceDesc($idDanhMuc, $start, $limit);
        
        include 'views/product/product.php';
    }

    public function searchSanPhamByPriceAsc()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $start = ($page - 1) * $limit;
        
        $sanPhamModel = new SanPham();
        $totalProducts = $sanPhamModel->countSearch($keyword);
        $totalPages = ceil($totalProducts / $limit);
        
        $products = $sanPhamModel->searchSanPhamByPriceAsc($keyword, $start, $limit);
        
        include 'views/product/product.php';
    }

    public function searchSanPhamByPriceDesc()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $start = ($page - 1) * $limit;
        
        $sanPhamModel = new SanPham();
        $totalProducts = $sanPhamModel->countSearch($keyword);
        $totalPages = ceil($totalProducts / $limit);
        
        $products = $sanPhamModel->searchSanPhamByPriceDesc($keyword, $start, $limit);
        
        include 'views/product/product.php';
    }
}
