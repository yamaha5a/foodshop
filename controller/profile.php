<?php
require_once 'model/nguoidung.php';

class ProfileController {
    private $userModel;

    public function __construct() {
        $this->userModel = new NguoiDungModel();
    }

    public function viewProfile() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để xem thông tin cá nhân";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit();
        }

        try {
            // Lấy thông tin người dùng từ database
            $user = $this->userModel->getUserById($_SESSION['user']['id']);
            
            if (!$user) {
                $_SESSION['error_message'] = "Không tìm thấy thông tin người dùng";
                echo '<script>window.location.href = "index.php?page=home";</script>';
                exit();
            }

            // Lấy lịch sử bình luận
            $comments = $this->userModel->getCommentHistory($_SESSION['user']['id']);

            // Cập nhật thông tin trong session
            $_SESSION['user'] = $user;
            
            // Truyền dữ liệu sang view
            $GLOBALS['comments'] = $comments;
            
            // Hiển thị trang profile
            include 'views/profile/profile.php';
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Có lỗi xảy ra khi tải thông tin người dùng";
            echo '<script>window.location.href = "index.php?page=home";</script>';
            exit();
        }
    }
}
?> 