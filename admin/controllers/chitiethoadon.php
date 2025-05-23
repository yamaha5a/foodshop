<?php
require_once __DIR__ . '/../check_auth.php';
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
        
        // Get sort parameter
        $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'date_desc';
        
        // Get orders with pagination, search, and sorting
        $orders = $this->orderDetailModel->getAllOrders($page, $limit, $search, $sortBy);
        
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
            
            // Nếu trạng thái là "Khách hàng đã nhận", cập nhật ngày nhận
            if ($status === 'Khách hàng đã nhận') {
                $this->orderDetailModel->updateOrderReceivedDate($orderId);
            }
            
            // Redirect back to detail page with success parameter using echo
            echo "<script>
                window.location.href = 'index.php?act=detailchitiethoadon&id=" . $orderId . "&success=1';
            </script>";
            exit;
        }
    }
    
} 