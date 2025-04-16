<?php
require_once 'model/khuyenmai.php';

class DiscountController {
    private $discountModel;

    public function __construct() {
        $this->discountModel = new KhuyenMaiModel();
    }

    public function applyDiscount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            
            if (!isset($_SESSION['user'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để sử dụng mã giảm giá'
                ]);
                exit;
            }

            $discountCode = $_POST['code'];
            
            // Kiểm tra mã giảm giá
            $discount = $this->discountModel->getDiscountByCode($discountCode);
            
            if (!$discount) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Mã giảm giá không hợp lệ'
                ]);
                exit;
            }

            // Kiểm tra ngày hiệu lực
            $currentDate = date('Y-m-d');
            if ($currentDate < $discount['ngaybatdau'] || $currentDate > $discount['ngayketthuc']) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Mã giảm giá đã hết hạn hoặc chưa đến ngày áp dụng'
                ]);
                exit;
            }

            // Kiểm tra trạng thái
            if ($discount['trangthai'] !== 'Hoạt động') {
                echo json_encode([
                    'success' => false,
                    'message' => 'Mã giảm giá không còn hoạt động'
                ]);
                exit;
            }

            // Tính toán số tiền giảm giá
            $subtotal = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
            }

            // Kiểm tra nếu số tiền giảm giá lớn hơn tổng tiền
            if ($discount['giatrigiam'] > $subtotal) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Số tiền giảm giá không được lớn hơn tổng tiền đơn hàng'
                ]);
                exit;
            }

            $discountAmount = $discount['giatrigiam'];
            $newTotal = $subtotal - $discountAmount;

            // Lưu thông tin giảm giá vào session
            $_SESSION['discount'] = [
                'code' => $discountCode,
                'amount' => $discountAmount,
                'newTotal' => $newTotal
            ];

            echo json_encode([
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công',
                'discountAmount' => number_format($discountAmount, 0, ',', '.'),
                'newTotal' => number_format($newTotal, 0, ',', '.'),
                'subtotal' => number_format($subtotal, 0, ',', '.')
            ]);
            exit;
        }
    }

    public function removeDiscount() {
        if (isset($_SESSION['discount'])) {
            unset($_SESSION['discount']);
            $_SESSION['success_message'] = 'Đã xóa mã giảm giá';
        }
        header('Location: index.php?page=cart');
        exit;
    }
}
?> 