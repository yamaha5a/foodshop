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
            echo '<meta http-equiv="refresh" content="0;url=index.php?page=login">';
            exit();
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
        
        // Get active payment methods from database
        $paymentMethods = $this->model->getPaymentMethods();
        
        // Get active promotions
        $promotions = $this->model->getActivePromotions();

        // Load view
        include 'views/checkout/checkout.php';
    }

    // Process checkout
    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            $requiredFields = ['first_name', 'address', 'sodienthoai', 'email', 'payment_method'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin";
                    include 'views/checkout/redirect.php';
                    echo '<script>setTimeout(function() { window.location.href = "index.php?page=checkout"; }, 2000);</script>';
                    exit;
                }
            }

            // Get user ID from session
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
                $_SESSION['error'] = "Vui lòng đăng nhập để thanh toán";
                include 'views/checkout/redirect.php';
                echo '<script>setTimeout(function() { window.location.href = "index.php?page=login"; }, 2000);</script>';
                exit;
            }
            
            $userId = $_SESSION['user']['id'];
            
            // Get cart items
            $cartItems = $this->model->getCartDetails($userId);
            
            if (empty($cartItems)) {
                $_SESSION['error'] = "Giỏ hàng của bạn đang trống";
                include 'views/checkout/redirect.php';
                echo '<script>setTimeout(function() { window.location.href = "index.php?page=checkout"; }, 2000);</script>';
                exit;
            }

            // Validate payment method
            $paymentMethods = $this->model->getPaymentMethods();
            $validPaymentMethod = false;
            foreach ($paymentMethods as $method) {
                if ($method['id'] == $_POST['payment_method']) {
                    $validPaymentMethod = true;
                    break;
                }
            }

            if (!$validPaymentMethod) {
                $_SESSION['error'] = "Phương thức thanh toán không hợp lệ";
                include 'views/checkout/redirect.php';
                echo '<script>setTimeout(function() { window.location.href = "index.php?page=checkout"; }, 2000);</script>';
                exit;
            }
            
            // Prepare data for order creation
            $orderData = [
                'userId' => $userId,
                'address' => $_POST['address'],
                'note' => $_POST['note'] ?? '',
                'payment_method' => $_POST['payment_method'],
                'cart_items' => $cartItems
            ];
            
            // Create order
            $orderId = $this->model->createOrder($orderData);
            
            if ($orderId) {
                // Create order details
                $this->model->createOrderDetails($orderId, $cartItems);
                
                // Update cart status
                $cartId = $this->model->getCartId($userId);
                if ($cartId) {
                    $this->model->updateCartStatus($cartId['id']);
                }
                
                $_SESSION['success'] = "Đặt hàng thành công!";
                $_SESSION['order_id'] = $orderId;
                
                // Clear cart after successful order
                unset($_SESSION['cart']);
                
                // Redirect directly to orders page using echo
                echo '<script>window.location.href = "index.php?page=orders";</script>';
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi đặt hàng";
                echo '<script>window.location.href = "index.php?page=checkout";</script>';
                exit;
            }
        }
    }
}
