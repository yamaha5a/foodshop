<?php
require_once 'model/lienhe.php';

class ContactController {
    private $lienHeModel;

    public function __construct() {
        $this->lienHeModel = new LienHeModel();
    }

    /**
     * Hiển thị trang liên hệ
     */
    public function viewContact() {
        // Nếu người dùng đã đăng nhập, lấy danh sách liên hệ của họ
        $lienHeList = [];
        if (isset($_SESSION['user'])) {
            $lienHeList = $this->lienHeModel->getLienHeByUserId($_SESSION['user']['id']);
        }
        
        // Hiển thị trang liên hệ
        include 'views/contact/contact.php';
    }

    /**
     * Xử lý gửi liên hệ
     */
    public function sendContact() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để gửi liên hệ";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra dữ liệu đầu vào
            if (empty($_POST['tieude']) || empty($_POST['noidung'])) {
                $_SESSION['error_message'] = "Vui lòng điền đầy đủ thông tin liên hệ";
                echo '<script>window.location.href = "index.php?page=contact";</script>';
                exit();
            }

            $nguoidung_id = $_SESSION['user']['id'];
            $tieude = $_POST['tieude'];
            $noidung = $_POST['noidung'];

            // Thêm liên hệ vào database
            $result = $this->lienHeModel->themLienHe($nguoidung_id, $tieude, $noidung);

            if ($result) {
                $_SESSION['success_message'] = "Gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất có thể.";
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi gửi liên hệ. Vui lòng thử lại sau.";
            }

            echo '<script>window.location.href = "index.php?page=contact";</script>';
            exit();
        } else {
            // Nếu không phải POST request, chuyển hướng về trang liên hệ
            echo '<script>window.location.href = "index.php?page=contact";</script>';
            exit();
        }
    }

    /**
     * Xem chi tiết liên hệ
     */
    public function viewContactDetail() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để xem chi tiết liên hệ";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit();
        }

        // Kiểm tra ID liên hệ
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error_message'] = "ID liên hệ không hợp lệ";
            echo '<script>window.location.href = "index.php?page=contact";</script>';
            exit();
        }

        $id = $_GET['id'];
        $lienHe = $this->lienHeModel->getLienHeById($id);

        // Kiểm tra quyền xem liên hệ
        if (!$lienHe || $lienHe['nguoidung_id'] != $_SESSION['user']['id']) {
            $_SESSION['error_message'] = "Bạn không có quyền xem liên hệ này";
            echo '<script>window.location.href = "index.php?page=contact";</script>';
            exit();
        }

        // Hiển thị chi tiết liên hệ
        include 'views/contact/contact_detail.php';
    }
} 