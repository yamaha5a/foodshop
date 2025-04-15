<?php
require_once 'model/checkout.php';

class CheckoutController {
    private $model;

    public function __construct() {
        $this->model = new CheckoutModel();
    }

    // Display checkout page
    public function viewCheckout() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để thanh toán";
            header('Location: index.php?page=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        
        // Get cart items
        $cartItems = $this->model->getCartDetails($userId);
        
        // Calculate total
        $total = 0;
        if (!empty($cartItems)) {
            foreach ($cartItems as $item) {
                $total += ($item['gia'] + ($item['gia_topping'] ?? 0)) * $item['soluong'];
            }
        }

        // Get user addresses
        $addresses = $this->model->getUserAddresses($userId);
        
        // Get payment methods
        $paymentMethods = $this->model->getPaymentMethods();
        
        // Get active promotions
        $promotions = $this->model->getActivePromotions();

        // Load view
        include 'views/checkout/checkout.php';
    }

    // Process checkout
    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user'])) {
                $_SESSION['error_message'] = "Vui lòng đăng nhập để thanh toán";
                header("Location: index.php?page=login");
                exit;
            }

            $userId = $_SESSION['user']['id'];
            $cartItems = $this->model->getCartDetails($userId);

            if (empty($cartItems)) {
                $_SESSION['error_message'] = "Giỏ hàng trống";
                header("Location: index.php?page=cart");
                exit;
            }

            try {
                // Validate required fields
                $requiredFields = ['first_name', 'address', 'sodienthoai', 'email', 'payment_method'];
                foreach ($requiredFields as $field) {
                    if (!isset($_POST[$field]) || empty($_POST[$field])) {
                        throw new Exception("Vui lòng điền đầy đủ thông tin");
                    }
                }

                // Calculate total
                $total = 0;
                foreach ($cartItems as $item) {
                    $total += $item['gia'] * $item['soluong'];
                }

                // Create order data
                $orderData = [
                    'id_nguoidung' => $userId,
                    'diachigiaohang' => $_POST['address'],
                    'tongtien' => $total,
                    'trangthai' => 'Chờ xác nhận',
                    'ghichu' => $_POST['note'] ?? '',
                    'id_phuongthucthanhtoan' => $_POST['payment_method']
                ];

                $orderId = $this->model->createOrder($orderData);

                if ($orderId) {
                    // Clear cart session
                    unset($_SESSION['cart']);
                    
                    // Clear cart from database
                    $this->model->clearCart($userId);
                    
                    $_SESSION['success_message'] = "Đặt hàng thành công! Mã đơn hàng: #" . $orderId;
                    header("Location: index.php?page=mock_order");
                    exit;
                } else {
                    throw new Exception("Không thể tạo đơn hàng");
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header("Location: index.php?page=checkout");
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Phương thức không hợp lệ";
            header("Location: index.php?page=checkout");
            exit;
        }
    }
}
