<?php
require_once 'model/danhMuc.php';

class danhMucController
{
    private $danhmucModel;

    public function __construct()
    {
        $this->danhmucModel = new danhMuc();
    }
    public function list()
    {
        $sanphams = $this->danhMucModel->getAllDanhMuc(); // Lấy danh sách sản phẩm

        // Kiểm tra nếu có sản phẩm
        if (!$sanphams) {
            echo 'Không có sản phẩm nào để hiển thị.'; // Thông báo nếu không có sản phẩm
            return; // Dừng hàm nếu không có sản phẩm
        }

        include 'views/home/home.php'; // Bao gồm view nếu có sản phẩm
    }
    
    // New method to get categories without including the view
    public function getCategories()
    {
        $danhMucs = $this->danhMucModel->getAllDanhMuc(); // Lấy danh sách danh mục
        return $danhMucs;
    }
}