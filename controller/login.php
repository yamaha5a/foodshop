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
}
