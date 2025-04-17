<?php
require_once __DIR__ . '/../Models/bieudo.php';

class BieuDoController {
    private $bieuDoModel;
    
    public function __construct() {
        global $conn;
        $this->bieuDoModel = new BieuDo($conn);
    }
    
    public function index() {
        // Lấy dữ liệu doanh thu theo tháng
        $doanhThuData = $this->bieuDoModel->getDoanhThuTheoThang();
        
        // Chuyển đổi dữ liệu thành JSON để sử dụng trong JavaScript
        $labels = json_encode($doanhThuData['labels']);
        $data = json_encode($doanhThuData['data']);
        
        // Truyền dữ liệu vào view
        include __DIR__ . '/../Views/bieudo/bieudo.php';
    }
}

// Khởi tạo controller và gọi phương thức index
$bieuDoController = new BieuDoController();
$bieuDoController->index();
?> 