<?php
require_once 'model/sanpham.php';

class SanPhamController {
    private $sanphamModel;

    public function __construct() {
        $this->sanphamModel = new SanPham();
    }

    public function list() {
        $sanphams = $this->sanphamModel->getAll(); // Lấy danh sách sản phẩm

        // Kiểm tra nếu có sản phẩm
        if (!$sanphams) {
            echo 'Không có sản phẩm nào để hiển thị.'; // Thông báo nếu không có sản phẩm
            return; // Dừng hàm nếu không có sản phẩm
        }

        include 'views/home/home.php'; // Bao gồm view nếu có sản phẩm
    }
}

?>
