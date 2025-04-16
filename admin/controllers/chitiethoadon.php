<?php
require_once __DIR__ . '/../Models/chitiethoadon.php';

class OrderDetailController {
    private $orderDetailModel;

    public function __construct() {
        $this->orderDetailModel = new OrderDetailModel();
    }

    public function index() {
        // Get pagination parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Number of items per page
        
        // Get search parameter
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Get orders with pagination and search
        $orders = $this->orderDetailModel->getAllOrders($page, $limit, $search);
        
        // Get total number of orders for pagination
        $totalOrders = $this->orderDetailModel->getTotalOrders($search);
        
        // Calculate total pages
        $totalPages = ceil($totalOrders / $limit);
        
        // Pass data to the view
        include __DIR__ . '/../Views/chitiethoadon/list.php';
    }

    public function detail() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?act=chitiethoadon");
            exit;
        }

        $orderId = $_GET['id'];
        $order = $this->orderDetailModel->getOrderById($orderId);
        $orderItems = $this->orderDetailModel->getOrderItems($orderId);
        
        include __DIR__ . '/../Views/chitiethoadon/detail.php';
    }
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['trangthai'])) {
            $orderId = $_POST['order_id'];
            $status = $_POST['trangthai'];
    
            $this->orderDetailModel->updateOrderStatus($orderId, $status);
            
            // Redirect back to detail page with success parameter using echo
            echo "<script>
                window.location.href = 'index.php?act=detailchitiethoadon&id=" . $orderId . "&success=1';
            </script>";
            exit;
        }
    }
    
} 