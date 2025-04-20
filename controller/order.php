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
        // Debug: Kiểm tra user ID
        error_log("User ID: " . $userId);
        
        $orders = $this->orderModel->getOrders($userId);
        
        // Debug: Kiểm tra số lượng đơn hàng
        error_log("Number of orders: " . count($orders));
        
        // Kiểm tra dữ liệu trước khi truyền sang view
        if (!empty($orders)) {
            foreach ($orders as &$order) {
                if (!isset($order['phuongthucthanhtoan'])) {
                    $order['phuongthucthanhtoan'] = 'Chưa xác định';
                }
                // Debug: Kiểm tra từng đơn hàng
                error_log("Order ID: " . $order['id'] . ", Status: " . $order['trangthai']);
            }
        }

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

        // Lấy chi tiết sản phẩm trong đơn hàng
        $orderItems = $this->orderModel->getOrderItems($orderId);
        
        // Truyền dữ liệu sang view
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

                $orderId = $this->orderModel->createOrder($orderData, $cartItems);

                if ($orderId) {
                    // Clear cart session
                    unset($_SESSION['cart']);
                    
                    // Clear cart from database
                    $this->cartModel->clearCart($userId);
                    
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
    
    /**
     * Handle order cancellation request
     */
    public function cancelOrder() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để hủy đơn hàng";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Phương thức không hợp lệ";
            echo '<script>window.location.href = "index.php?page=orders";</script>';
            exit;
        }
        
        if (!isset($_POST['order_id']) || empty($_POST['order_id'])) {
            $_SESSION['error_message'] = "Không tìm thấy đơn hàng";
            echo '<script>window.location.href = "index.php?page=orders";</script>';
            exit;
        }
        
        $orderId = $_POST['order_id'];
        $userId = $_SESSION['user']['id'];
        
        // Check current status
        $currentOrder = $this->orderModel->getOrderById($orderId, $userId);
        if (!$currentOrder) {
            $_SESSION['error_message'] = "Không tìm thấy đơn hàng";
            echo '<script>window.location.href = "index.php?page=orders";</script>';
            exit;
        }

        // If order is already cancelled, continue processing
        if ($currentOrder['trangthai'] === 'Đã hủy') {
            $result = $this->orderModel->updateOrderStatus($orderId, $userId, 'Đang xử lý');
            if ($result) {
                $_SESSION['success_message'] = "Đã tiếp tục xử lý đơn hàng #" . $orderId;
            } else {
                $_SESSION['error_message'] = "Không thể tiếp tục xử lý đơn hàng";
            }
        } else {
            // Cancel the order
            $result = $this->orderModel->updateOrderStatus($orderId, $userId, 'Đã hủy');
            if ($result) {
                $_SESSION['success_message'] = "Đã hủy đơn hàng #" . $orderId . " thành công";
            } else {
                $_SESSION['error_message'] = "Không thể hủy đơn hàng";
            }
        }
        
        // Redirect back to order details page using JavaScript
        echo '<script>window.location.href = "index.php?page=orderDetails&id=' . $orderId . '";</script>';
        exit;
    }

    public function continueOrder() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để tiếp tục xử lý đơn hàng";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Phương thức không hợp lệ";
            echo '<script>window.location.href = "index.php?page=orders";</script>';
            exit;
        }
        
        if (!isset($_POST['order_id']) || empty($_POST['order_id'])) {
            $_SESSION['error_message'] = "Không tìm thấy đơn hàng";
            echo '<script>window.location.href = "index.php?page=orders";</script>';
            exit;
        }
        
        $orderId = $_POST['order_id'];
        $userId = $_SESSION['user']['id'];
        
        // Update order status to "Đang vận chuyển"
        $result = $this->orderModel->updateOrderStatus($orderId, $userId, 'Đang vận chuyển');
        
        if ($result) {
            $_SESSION['success_message'] = "Đã cập nhật trạng thái đơn hàng #" . $orderId . " thành công";
        } else {
            $_SESSION['error_message'] = "Không thể cập nhật trạng thái đơn hàng";
        }
        
        echo '<script>window.location.href = "index.php?page=orderDetails&id=' . $orderId . '";</script>';
        exit;
    }

    public function completeOrder() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để xác nhận đơn hàng";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Phương thức không hợp lệ";
            echo '<script>window.location.href = "index.php?page=orders";</script>';
            exit;
        }
        
        if (!isset($_POST['order_id']) || empty($_POST['order_id'])) {
            $_SESSION['error_message'] = "Không tìm thấy đơn hàng";
            echo '<script>window.location.href = "index.php?page=orders";</script>';
            exit;
        }
        
        $orderId = $_POST['order_id'];
        $userId = $_SESSION['user']['id'];
        
        // Update order status to "Khách hàng đã nhận" and set delivery date with time
        $result = $this->orderModel->updateOrderStatus($orderId, $userId, 'Khách hàng đã nhận', date('Y-m-d H:i:s'));
        
        if ($result) {
            $_SESSION['success_message'] = "Đã xác nhận nhận hàng thành công cho đơn hàng #" . $orderId;
        } else {
            $_SESSION['error_message'] = "Không thể xác nhận nhận hàng";
        }
        
        echo '<script>window.location.href = "index.php?page=orderDetails&id=' . $orderId . '";</script>';
        exit;
    }
} 