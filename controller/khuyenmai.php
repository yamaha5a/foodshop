<?php
require_once '../model/khuyenmai.php';
require_once 'model/cart.php';

class KhuyenMaiController {
    private $khuyenMaiModel;
    private $cartModel;

    public function __construct() {
        $this->khuyenMaiModel = new KhuyenMaiModel();
        $this->cartModel = new CartModel();
    }

    public function applyDiscount($code) {
        $discount = $this->khuyenMaiModel->getDiscountByCode($code);
        if ($discount) {
            return [
                'success' => true,
                'discount' => $discount
            ];
        }
        return [
            'success' => false,
            'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn'
        ];
    }

    public function getAllDiscounts() {
        return $this->khuyenMaiModel->getAllDiscounts();
    }

    public function addDiscount($data) {
        return $this->khuyenMaiModel->addDiscount($data);
    }

    public function updateDiscount($id, $data) {
        return $this->khuyenMaiModel->updateDiscount($id, $data);
    }

    public function deleteDiscount($id) {
        return $this->khuyenMaiModel->deleteDiscount($id);
    }

    public function getActiveDiscounts() {
        return $this->khuyenMaiModel->getActiveDiscounts();
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
            $discount = $this->khuyenMaiModel->getDiscountByCode($discountCode);
            
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

            // Tính toán tổng tiền từ giỏ hàng
            $userId = $_SESSION['user']['id'];
            $cartItems = $this->cartModel->getCartItems($userId);
            
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['gia'] * $item['soluong'];
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