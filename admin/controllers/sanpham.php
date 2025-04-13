<?php
require_once 'Models/sanpham.php'; // Đảm bảo model đã được bao gồm
require_once 'Models/danhmuc.php';

class SanPhamController
{
    private $sanPhamModel;
    private $danhMucModel;

    public function __construct()
    {
        $this->sanPhamModel = new SanPhamModel();
        $this->danhMucModel = new danhMucModel();
    } // Đóng hàm khởi tạo

    // public function list()
    // {
    //     $kyw = $_GET['kyw'] ?? '';
    //     $iddm = $_GET['iddm'] ?? 0;

    //     $dsDanhmuc = $this->danhMucModel->getAllDanhMuc();
    //     $danhSachSanPham = $this->sanPhamModel->layTatCaSanPham($kyw, $iddm);

    //     include 'views/sanpham/list.php';
    // }
    public function list() {
        $kyw = $_GET['kyw'] ?? '';
        $iddm = $_GET['iddm'] ?? 0;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
    
        $dsDanhmuc = $this->danhMucModel->getAllDanhMuc();
        $tongSp = $this->sanPhamModel->demSanPham($kyw, $iddm);
        $soTrang = ceil($tongSp / $limit);
    
        $danhSachSanPham = $this->sanPhamModel->layTatCaSanPham($kyw, $iddm, $limit, $offset);
    
        include 'views/sanpham/list.php';
    }
    

    // Thêm sản phẩm
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tensanpham = $_POST['tensanpham'];
            $mota = $_POST['mota'];
            $gia = $_POST['gia'];
            $soluong = $_POST['soluong'];
            $id_danhmuc = $_POST['id_danhmuc'];
            // Upload ảnh an toàn
            $target_dir = "../upload/";
            $hinhanh1 = (!empty($_FILES['hinhanh1']['name'])) ? $_FILES['hinhanh1']['name'] : "";
            $hinhanh2 = (!empty($_FILES['hinhanh2']['name'])) ? $_FILES['hinhanh2']['name'] : "";
            $hinhanh3 = (!empty($_FILES['hinhanh3']['name'])) ? $_FILES['hinhanh3']['name'] : "";

            if (!empty($hinhanh1)) move_uploaded_file($_FILES["hinhanh1"]["tmp_name"], $target_dir . $hinhanh1);
            if (!empty($hinhanh2)) move_uploaded_file($_FILES["hinhanh2"]["tmp_name"], $target_dir . $hinhanh2);
            if (!empty($hinhanh3)) move_uploaded_file($_FILES["hinhanh3"]["tmp_name"], $target_dir . $hinhanh3);

            $this->sanPhamModel->themSanPham($tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc);
            $_SESSION['thongbao'] = "Thêm sản phẩm thành công!";
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=sanpham">';
            exit();
        }
        $dsDanhmuc = $this->danhMucModel->getAllDanhMuc();
        include 'views/sanpham/add.php'; // Bao gồm view thêm sản phẩm
    }

    // Chi tiết sản phẩm
    public function detail($id)
    {
        $sanPham = $this->sanPhamModel->laySanPhamTheoID($id);
        if (!$sanPham) {
            die("Không tìm thấy sản phẩm!");
        }
        include 'views/sanpham/detail.php'; // Bao gồm view chi tiết sản phẩm
    }

    // Cập nhật sản phẩm
    public function edit()
    {
        $id = $_GET['id'] ?? $_POST['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $tensanpham = $_POST['tensanpham'];
            $mota = $_POST['mota'];
            $gia = $_POST['gia'];
            $soluong = $_POST['soluong'];
            $id_danhmuc = $_POST['id_danhmuc'];
            // Lấy ảnh cũ từ form
            $hinhanh1 = $_POST['hinhanh_cu1'];
            $hinhanh2 = $_POST['hinhanh_cu2'];
            $hinhanh3 = $_POST['hinhanh_cu3'];

            // Thư mục lưu ảnh
            $target_dir = "../upload/";

            // Kiểm tra và cập nhật ảnh mới nếu có
            if (!empty($_FILES['hinhanh1']['name'])) {
                $hinhanh1 = $_FILES['hinhanh1']['name'];
                move_uploaded_file($_FILES["hinhanh1"]["tmp_name"], $target_dir . $hinhanh1);
            }

            if (!empty($_FILES['hinhanh2']['name'])) {
                $hinhanh2 = $_FILES['hinhanh2']['name'];
                move_uploaded_file($_FILES["hinhanh2"]["tmp_name"], $target_dir . $hinhanh2);
            }

            if (!empty($_FILES['hinhanh3']['name'])) {
                $hinhanh3 = $_FILES['hinhanh3']['name'];
                move_uploaded_file($_FILES["hinhanh3"]["tmp_name"], $target_dir . $hinhanh3);
            }


            $this->sanPhamModel->capNhatSanPham($id, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc);
            $_SESSION['thongbao'] = "Cập nhật sản phẩm thành công!";
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=sanpham">';
            exit();
        }

        $sanPham = $this->sanPhamModel->laySanPhamTheoID($id);
        $dsDanhmuc = $this->danhMucModel->getAllDanhMuc();

        if (!$sanPham) {
            die("Không tìm thấy sản phẩm!");
        }
        include 'views/sanpham/edit.php'; // Bao gồm view cập nhật sản phẩm
    }

    // Xóa sản phẩm
    public function delete()
    {
        $id = $_GET["id"] ?? 0;
        $this->sanPhamModel->xoaSanPham($id);
        $_SESSION['thongbaoxoa'] = "Xóa sản phẩm thành công!";
        echo '<meta http-equiv="refresh" content="0;url=index.php?act=sanpham">';
        exit();
    }
}

// Đóng lớp SanPhamController
