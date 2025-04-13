<?php
require_once 'model/order.php';
require_once 'model/cart.php';

class OrderController {
    private $orderModel;
    private $cartModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
    }

    public function viewOrders() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để xem đơn hàng";
            header("Location: index.php?page=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $orders = $this->orderModel->getOrders($userId);
        include 'views/orders/orders.php';
    }

    public function viewOrderDetails() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để xem chi tiết đơn hàng";
            header("Location: index.php?page=login");
            exit;
        }

        if (!isset($_GET['id'])) {
            $_SESSION['error_message'] = "Không tìm thấy đơn hàng";
            header("Location: index.php?page=orders");
            exit;
        }

        $orderId = $_GET['id'];
        $userId = $_SESSION['user']['id'];

        $order = $this->orderModel->getOrderById($orderId, $userId);
        if (!$order) {
            $_SESSION['error_message'] = "Không tìm thấy đơn hàng";
            header("Location: index.php?page=orders");
            exit;
        }

        $orderItems = $this->orderModel->getOrderItems($orderId);
        include 'views/orders/order_details.php';
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
                $requiredFields = ['first_name', 'address', 'sodienthoai', 'email', 'payment_method'];
                foreach ($requiredFields as $field) {
                    if (!isset($_POST[$field]) || empty($_POST[$field])) {
                        throw new Exception("Vui lòng điền đầy đủ thông tin");
                    }
                }

                $shippingInfo = [
                    'address' => $_POST['address'],
                    'first_name' => $_POST['first_name'],
                    'sodienthoai' => $_POST['sodienthoai'],
                    'email' => $_POST['email'],
                    'note' => $_POST['note'] ?? ''
                ];

                $paymentMethod = $_POST['payment_method'];

                $orderId = $this->orderModel->createOrder($userId, $shippingInfo, $paymentMethod, 0, $cartItems);

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