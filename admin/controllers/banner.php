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
            if (!isset($_FILES['hinhanh']) || $_FILES['hinhanh']['error'] != 0) {
                error_log("Vui lòng chọn một hình ảnh.");
                $_SESSION['thongbao'] = "Vui lòng chọn một hình ảnh.";
                header("Location: index.php?act=addbanner");
                exit();
            }
    
            $uploadDir = __DIR__ . '/../public/img/banner/';
            $tenHinh = basename($_FILES['hinhanh']['name']);
            $hinhanh = "img/banner/" . $tenHinh; // Đây là đường dẫn lưu trong database
            $target_file = $uploadDir . $tenHinh; // Đây là đường dẫn lưu file trên server

    
            if (!move_uploaded_file($_FILES['hinhanh']['tmp_name'], $target_file)) {
                error_log("Lỗi upload hình ảnh.");
                $_SESSION['thongbao'] = "Lỗi khi tải ảnh lên.";
                header("Location: index.php?act=addbanner");
                exit();
            }
    
            // Thêm banner vào database
            $this->bannerModel->addBanner($hinhanh);
    
            // Kiểm tra nếu có dữ liệu output, thì xóa trước khi header()
            if (ob_get_length()) {
                ob_clean();
            }
    
            $_SESSION['thongbao'] = "Thêm banner thành công!";
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
        $id = $_GET["id"] ?? 0; // Lấy ID từ GET
        $this->bannerModel->deleteBanner($id); // Gọi phương thức xóa banner từ model
    
        $_SESSION['thongbao'] = "Xóa banner thành công!"; // Lưu thông báo vào session
    
        // Chuyển hướng về trang banner
        echo '<meta http-equiv="refresh" content="0;url=index.php?act=banner">';
        exit(); 
    }
    
    
}
?>