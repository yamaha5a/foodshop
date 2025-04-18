<?php
require_once 'model/nguoidung.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $matkhau = $_POST['matkhau'] ?? '';
    
            $userModel = new NguoiDungModel();
            $user = $userModel->dangNhap($email);
    
            if ($user && password_verify($matkhau, $user['matkhau'])) {
                $_SESSION['user'] = $user;
                $_SESSION['success_message'] = "Đăng nhập thành công!";
                echo '<script>window.location.href = "index.php?page=home";</script>';
                exit;
            } else {
                $_SESSION['error_message'] = "Email hoặc mật khẩu không đúng";
                echo '<script>window.location.href = "index.php?page=login";</script>';
                exit;
            }
        } else {
            include 'views/login/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            if (empty($_POST['ten']) || empty($_POST['email']) || empty($_POST['matkhau'])) {
                $_SESSION['error_message'] = "Vui lòng điền đầy đủ thông tin bắt buộc";
                echo '<script>window.location.href = "index.php?page=register";</script>';
                exit;
            }

            // Validate name (only letters and spaces)
            if (!preg_match('/^[a-zA-Z\sÀ-ỹ]+$/', $_POST['ten'])) {
                $_SESSION['error_message'] = "Tên không được chứa số hoặc ký tự đặc biệt";
                echo '<script>window.location.href = "index.php?page=register";</script>';
                exit;
            }

            // Validate email format
            if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $_POST['email'])) {
                $_SESSION['error_message'] = "Email phải có định dạng @gmail.com";
                echo '<script>window.location.href = "index.php?page=register";</script>';
                exit;
            }

            // Validate password length
            if (strlen($_POST['matkhau']) < 6) {
                $_SESSION['error_message'] = "Mật khẩu phải có ít nhất 6 ký tự";
                echo '<script>window.location.href = "index.php?page=register";</script>';
                exit;
            }

            // Validate phone number if provided
            if (!empty($_POST['sodienthoai']) && !preg_match('/^0\d{9}$/', $_POST['sodienthoai'])) {
                $_SESSION['error_message'] = "Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số";
                echo '<script>window.location.href = "index.php?page=register";</script>';
                exit;
            }

            $ten = $_POST['ten'];
            $email = $_POST['email'];
            $matkhau = password_hash($_POST['matkhau'], PASSWORD_DEFAULT);
            $sodienthoai = $_POST['sodienthoai'] ?? '';
            $diachi = $_POST['diachi'] ?? '';
            $gioitinh = $_POST['gioitinh'] ?? 'Khác';
            $id_phanquyen = 2;

            // Check if email already exists
            $userModel = new NguoiDungModel();
            $existingUser = $userModel->dangNhap($email);
            if ($existingUser) {
                $_SESSION['error_message'] = "Email này đã được sử dụng";
                echo '<script>window.location.href = "index.php?page=register";</script>';
                exit;
            }

            if($userModel->dangKy($ten, $email, $matkhau, $sodienthoai, $diachi, $gioitinh, $id_phanquyen)) {
                $_SESSION['success_message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                echo '<script>window.location.href = "index.php?page=login";</script>';
                exit;
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.";
                echo '<script>window.location.href = "index.php?page=register";</script>';
                exit;
            }
        } else {
            include 'views/login/register.php';
        }
    }

    public function logout() {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to home page
        $_SESSION['success_message'] = "Đăng xuất thành công!";
        echo '<script>window.location.href = "index.php?page=home";</script>';
        exit;
    }

    public function changePassword() {
        if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
            echo '<script>alert("Vui lòng đăng nhập để thay đổi mật khẩu"); window.location.href = "index.php?page=home";</script>';
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['currentPassword'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            // Validate input
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                echo '<script>alert("Vui lòng điền đầy đủ thông tin"); window.location.href = "index.php?page=profile";</script>';
                exit();
            }

            if ($newPassword !== $confirmPassword) {
                echo '<script>alert("Mật khẩu mới không khớp"); window.location.href = "index.php?page=profile";</script>';
                exit();
            }

            if (strlen($newPassword) < 6) {
                echo '<script>alert("Mật khẩu mới phải có ít nhất 6 ký tự"); window.location.href = "index.php?page=profile";</script>';
                exit();
            }

            // Verify current password
            $userModel = new NguoiDungModel();
            $user = $userModel->getUserById($_SESSION['user']['id']);

            if (!$user || !password_verify($currentPassword, $user['matkhau'])) {
                echo '<script>alert("Mật khẩu hiện tại không đúng"); window.location.href = "index.php?page=profile";</script>';
                exit();
            }

            // Update password
            if ($userModel->capNhatMatKhau($user['id'], $newPassword)) {
                // Clear all session data
                session_unset();
                session_destroy();
                // Start new session for the success message
                session_start();
                echo '<script>alert("Cập nhật mật khẩu thành công. Vui lòng đăng nhập lại."); window.location.href = "index.php?page=login";</script>';
                exit();
            } else {
                echo '<script>alert("Cập nhật mật khẩu thất bại"); window.location.href = "index.php?page=profile";</script>';
                exit();
            }
        }
    }
}
