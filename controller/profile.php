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

    public function changeAvatar() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để thay đổi ảnh đại diện";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $userId = $_SESSION['user']['id'];
                
                // Kiểm tra xem có file được tải lên không
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                    $file = $_FILES['avatar'];
                    
                    // Kiểm tra loại file
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($file['type'], $allowedTypes)) {
                        throw new Exception('Chỉ chấp nhận file ảnh (JPEG, PNG, GIF)');
                    }
                    
                    // Kiểm tra kích thước file (tối đa 5MB)
                    if ($file['size'] > 5 * 1024 * 1024) {
                        throw new Exception('Kích thước file không được vượt quá 5MB');
                    }
                    
                    // Tạo tên file mới
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $newFileName = 'avatar_' . $userId . '_' . time() . '.' . $extension;
                    
                    // Đường dẫn lưu file
                    $uploadDir = 'admin/public/img/nguoidung/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    $targetPath = $uploadDir . $newFileName;
                    
                    // Di chuyển file
                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        // Cập nhật đường dẫn ảnh trong database
                        $avatarPath = 'img/nguoidung/' . $newFileName;
                        $this->userModel->updateAvatar($userId, $avatarPath);
                        
                        // Cập nhật session
                        $_SESSION['user']['hinhanh'] = $avatarPath;
                        
                        $_SESSION['success_message'] = "Thay đổi ảnh đại diện thành công!";
                    } else {
                        throw new Exception('Không thể tải ảnh lên. Vui lòng thử lại.');
                    }
                } else {
                    throw new Exception('Vui lòng chọn ảnh để tải lên');
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
            }
        }
        
        // Chuyển hướng về trang profile
        echo '<script>window.location.href = "index.php?page=profile";</script>';
        exit();
    }
}
?> 