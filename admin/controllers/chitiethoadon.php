<?php
require_once __DIR__ . '/../Models/chitiethoadon.php';

class OrderDetailController {
    private $orderDetailModel;

    public function __construct() {
        $this->orderDetailModel = new OrderDetailModel();
    }

    public function index() {
        $orders = $this->orderDetailModel->getAllOrders();
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
} 