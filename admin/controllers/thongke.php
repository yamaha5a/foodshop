<?php
require_once __DIR__ . '/../check_auth.php';
require_once __DIR__ . '/../Models/thongke.php';

class ThongKeController {
    private $thongKeModel;
    
    public function __construct() {
        global $conn;
        $this->thongKeModel = new ThongKe($conn);
    }
    
    public function index() {
        $data = [
            'total_users' => $this->thongKeModel->demTongTaiKhoan(),
            'total_orders' => $this->thongKeModel->demTongDonHang(),
            'total_revenue' => $this->thongKeModel->tinhTongDoanhThu(),
            'total_products' => $this->thongKeModel->demTongSanPham(),
            'recent_orders' => $this->thongKeModel->getDonHangMoiNhat()
        ];
        return $data;
    }
}

// Khởi tạo controller
$thongKeController = new ThongKeController();
$thongKeData = $thongKeController->index();

// Truyền dữ liệu vào view
extract($thongKeData);
?>
