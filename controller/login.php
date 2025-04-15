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
}
