<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
require_once __DIR__ . '/../models/Banner.php';

class BannerController {
    private $bannerModel;

    public function __construct() {
        $this->bannerModel = new Banner();
    }

    public function index() {
        $listBanner = $this->bannerModel->getAllBanners();
        include "views/banner/list.php";
    }
    public function addBanner() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
            if (empty($_FILES['hinhanh']) || $_FILES['hinhanh']['error'] !== 0) {
                $_SESSION['thongbao'] = "Vui lòng chọn một hình ảnh.";
                $redirect = "index.php?act=addbanner";
            } else {
                $tenHinh = basename($_FILES['hinhanh']['name']); 
                $target_file = __DIR__ . '/../public/img/banner/' . $tenHinh;  
                $hinhanh = "img/banner/" . $tenHinh; 
    
                if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], $target_file)) {
                    $this->bannerModel->addBanner($hinhanh);
                    $_SESSION['thongbao'] = "Thêm banner thành công!";
                    $redirect = "index.php?act=banner";
                } else {
                    $_SESSION['thongbao'] = "Lỗi khi tải ảnh lên.";
                    $redirect = "index.php?act=addbanner";
                }
            }
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=banner">';
            exit();
        }
        include __DIR__ . '/../views/banner/add.php';
    }       
    public function edit() {
        $id = $_GET["id"] ?? 0;
        $banner = $this->bannerModel->getBannerById($id);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->bannerModel->updateBanner($id, $_POST["hinhanh"], $_POST["lienket"]);
            header("Location: index.php?act=banner");
            exit();
        }
        include "views/banner/edit.php";
    }

    public function delete() {
        $id = $_GET["id"] ?? 0; 
        $this->bannerModel->deleteBanner($id); 
        $_SESSION['thongbao'] = "Xóa banner thành công!"; 
        echo '<meta http-equiv="refresh" content="0;url=index.php?act=banner">';
        exit(); 
    }
}
?>