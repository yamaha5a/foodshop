<?php
require_once 'model/cart.php';

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

    public function addToCart() {
        if (!isset($_SESSION['user'])) {
            echo '<meta name="error_message" content="Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng">';
            echo '<meta http-equiv="refresh" content="0;url=index.php?page=login">';
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo '<meta name="error_message" content="Phương thức không hợp lệ">';
            exit();
        }

        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$productId) {
            echo '<meta name="error_message" content="Không tìm thấy sản phẩm">';
            exit();
        }

        $userId = $_SESSION['user']['id'];
        try {
            $this->cartModel->addToCart($userId, $productId, $quantity);
            
            // Lấy số lượng sản phẩm trong giỏ hàng
            $cartItems = $this->cartModel->getCartItems($userId);
            $cartCount = count($cartItems);
            
            echo '<meta name="success_message" content="Đã thêm sản phẩm vào giỏ hàng thành công!">';
            echo '<meta name="cart_count" content="' . $cartCount . '">';
        } catch (Exception $e) {
            echo '<meta name="error_message" content="Lỗi: ' . htmlspecialchars($e->getMessage()) . '">';
        }
        exit();
    }

    public function viewCart() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để xem giỏ hàng";
            header("Location: index.php?page=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cartItems = $this->cartModel->getCartItems($userId);
        
        // Calculate total amount
        $totalAll = 0;
        foreach ($cartItems as $item) {
            $totalAll += $item['gia'] * $item['soluong'];
        }
        
        // Apply discount if exists
        if (isset($_SESSION['discount'])) {
            $discountAmount = $_SESSION['discount']['amount'];
            $newTotal = $totalAll - $discountAmount;
            
            // Update session with new total
            $_SESSION['discount']['newTotal'] = $newTotal;
        }
        
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
            
            // Lấy thông tin sản phẩm để kiểm tra số lượng
            $sql = "SELECT soluong FROM sanpham WHERE id = ?";
            $product = pdo_query_one($sql, $productId);
            
            if (!$product) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
                exit;
            }
            
            // Kiểm tra nếu số lượng vượt quá số lượng có sẵn
            if ($quantity > $product['soluong']) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Số lượng sản phẩm trong kho không đủ. Số lượng tối đa có thể đặt: ' . $product['soluong']
                ]);
                exit;
            }
            
            try {
                $result = $this->cartModel->updateCartItem($userId, $productId, $quantity);
                
                if (!$result) {
                    echo json_encode(['success' => false, 'message' => 'Không thể cập nhật số lượng']);
                    exit;
                }
                
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
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật số lượng']);
            }
            exit;
        }
    }

    public function removeCart() {
        if (!isset($_SESSION['user'])) {
            echo '<meta http-equiv="refresh" content="0;url=index.php?page=login">';
            exit();
        }

        $productId = $_GET['id'] ?? null;
        if (!$productId) {
            echo '<meta http-equiv="refresh" content="0;url=index.php?page=cart">';
            exit();
        }

        $userId = $_SESSION['user']['id'];
        try {
            $this->cartModel->removeCartItem($userId, $productId);
            $_SESSION['success_message'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
            echo '<meta http-equiv="refresh" content="0;url=index.php?page=cart">';
            exit();
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Lỗi: ' . $e->getMessage();
            echo '<meta http-equiv="refresh" content="0;url=index.php?page=cart">';
            exit();
        }
    }

    // Thêm phương thức mới để cập nhật số lượng giỏ hàng khi đăng nhập
    public function updateCartCount() {
        if (!isset($_SESSION['user'])) {
            return;
        }

        $userId = $_SESSION['user']['id'];
        $cartItems = $this->cartModel->getCartItems($userId);
        $_SESSION['cart_count'] = count($cartItems);
    }
}
