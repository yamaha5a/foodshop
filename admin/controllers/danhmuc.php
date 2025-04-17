<?php
require_once __DIR__ . '/../models/danhmuc.php';

class DanhMucController {
    protected $danhMucModel;

    public function __construct() {
        $this->danhMucModel = new danhMucModel(); // Tạo đối tượng
    }

    public function index() {
        $listDM = $this->danhMucModel->getAllDanhMuc(); // Gọi qua object
        include 'views/danhmuc/danhmuc.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tendanhmuc = $_POST['tendanhmuc'];
            $this->danhMucModel->addDanhMuc($tendanhmuc);
            $_SESSION['thongbao'] = "Thêm thành công!";
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=danhmuc">';
            exit();
        }
        include 'views/danhmuc/add.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        $dm = $this->danhMucModel->getOneDanhMuc($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tendanhmuc = $_POST['tendanhmuc'];
            $this->danhMucModel->updateDanhMuc($id, $tendanhmuc);
            $_SESSION['thongbao'] = "Cập nhật thành công!";
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=danhmuc">';
            exit();
        }
        include 'views/danhmuc/update.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        
        // Kiểm tra xem danh mục có sản phẩm không
        if ($this->danhMucModel->kiemTraDanhMucCoSanPham($id)) {
            $_SESSION['thongbao'] = "Không thể xóa danh mục này vì đã có sản phẩm liên quan!";
        } else {
            $this->danhMucModel->deleteDanhMuc($id);
            $_SESSION['thongbao'] = "Xóa danh mục thành công!";
        }
        
        echo '<meta http-equiv="refresh" content="0;url=index.php?act=danhmuc">';
        exit();
    }
}

