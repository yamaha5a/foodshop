<?php
require_once 'model/cart.php';
require_once 'model/order.php';
require_once 'model/payment_method.php';

class CheckoutController {
    private $cartModel;
    private $orderModel;
    private $paymentMethodModel;

    public function __construct() {
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        $this->paymentMethodModel = new PaymentMethodModel();
    }

    public function viewCheckout() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để thanh toán";
            header("Location: index.php?page=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cartItems = $this->cartModel->getCartItems($userId);

        if (empty($cartItems)) {
            $_SESSION['error_message'] = "Giỏ hàng trống";
            header("Location: index.php?page=cart");
            exit;
        }
        
        // Calculate total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['gia'] * $item['soluong'];
        }

        // Lấy danh sách phương thức thanh toán
        $paymentMethods = $this->paymentMethodModel->getAll();

        // Truyền dữ liệu sang view
        include 'views/checkout/checkout.php';
    }

    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user'])) {
                $_SESSION['error_message'] = "Vui lòng đăng nhập để thanh toán";
                header("Location: index.php?page=login");
                exit;
            }

            $userId = $_SESSION['user']['id'];
            $cartItems = $this->cartModel->getCartItems($userId);

            if (empty($cartItems)) {
                $_SESSION['error_message'] = "Giỏ hàng trống";
                header("Location: index.php?page=cart");
                exit;
            }

            try {
                // Validate required fields
                $requiredFields = ['address', 'payment_method'];
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

                // Create order data according to hoadon table structure
                $orderData = [
                    'id_nguoidung' => $userId,
                    'diachigiaohang' => $_POST['address'],
                    'tongtien' => $total,
                    'trangthai' => 'Chờ xác nhận',
                    'ghichu' => $_POST['note'] ?? '',
                    'id_phuongthucthanhtoan' => $_POST['payment_method']
                ];

                $orderId = $this->orderModel->createOrder($orderData, $cartItems);

                if ($orderId) {
                    $_SESSION['success_message'] = "Đặt hàng thành công! Mã đơn hàng: #" . $orderId;
                    header("Location: index.php?page=orders");
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