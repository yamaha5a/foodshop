<?php
    require_once 'model/cart.php';

    class CartController {
        private $cartModel;

        public function __construct() {
            $this->cartModel = new CartModel();
        }

        public function addToCart() {
            if (!isset($_SESSION['user'])) {
                $_SESSION['error_message'] = "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng";
                header("Location: index.php?page=login");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $_SESSION['error_message'] = "Phương thức không hợp lệ";
                header("Location: index.php");
                exit;
            }

            $productId = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;

            if (!$productId) {
                $_SESSION['error_message'] = "Không tìm thấy sản phẩm";
                header("Location: index.php");
                exit;
            }

            $userId = $_SESSION['user']['id'];
            try {
                $this->cartModel->addToCart($userId, $productId, $quantity);
                $_SESSION['success_message'] = "Đã thêm sản phẩm vào giỏ hàng thành công!";
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Lỗi: " . $e->getMessage();
            }

            // Quay lại trang trước đó
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer);
            exit;
        }

        public function viewCart() {
            if (!isset($_SESSION['user'])) {
                $_SESSION['error_message'] = "Vui lòng đăng nhập để xem giỏ hàng";
                header("Location: index.php?page=login");
                exit;
            }

            $userId = $_SESSION['user']['id'];
            $cartItems = $this->cartModel->getCartItems($userId);
            
            include 'views/cart/cart.php';
        }

        public function updateCart() {
            header('Content-Type: application/json');
            
            if (!isset($_SESSION['user'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để cập nhật giỏ hàng']);
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productId = $_POST['product_id'] ?? null;
                $quantity = $_POST['quantity'] ?? 1;

                if (!$productId) {
                    echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
                    exit;
                }

                $userId = $_SESSION['user']['id'];
                try {
                    $this->cartModel->updateCartItem($userId, $productId, $quantity);
                    
                    // Get updated cart totals
                    $cartItems = $this->cartModel->getCartItems($userId);
                    $totalAll = 0;
                    $productTotal = 0;
                    
                    foreach ($cartItems as $item) {
                        $itemTotal = $item['gia'] * $item['soluong'];
                        $totalAll += $itemTotal;
                        if ($item['id_sanpham'] == $productId) {
                            $productTotal = $itemTotal;
                        }
                    }
                    
                    echo json_encode([
                        'success' => true,
                        'totalAll' => $totalAll,
                        'productTotal' => $productTotal,
                        'message' => 'Đã cập nhật số lượng thành công'
                    ]);
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
                exit;
            }
        }

        public function removeCart() {
            header('Content-Type: application/json');
            
            if (!isset($_SESSION['user'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để xóa sản phẩm']);
                exit;
            }

            $productId = $_GET['id'] ?? null;
            if (!$productId) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
                exit;
            }

            $userId = $_SESSION['user']['id'];
            try {
                $this->cartModel->removeCartItem($userId, $productId);
                echo json_encode(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
            }
            exit;
        }
    }
