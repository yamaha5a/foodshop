<?php
require_once 'model/cart.php';

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if user is logged in
            if (!isset($_SESSION['user'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng']);
                exit;
            }

            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            // Get product details
            $product = get_sanpham_by_id($productId);
            if (!$product) {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
                exit;
            }

            $userId = $_SESSION['user']['id'];
            
            // Get or create cart
            $cartId = $this->cartModel->getOrCreateCart($userId);
            
            // Check if product already exists in cart
            $existingItem = $this->cartModel->getCartItem($cartId, $productId);
            
            if ($existingItem) {
                // Update quantity if product exists
                $newQuantity = $existingItem['soluong'] + $quantity;
                $this->cartModel->updateCartItem($cartId, $productId, $newQuantity);
            } else {
                // Add new item if product doesn't exist
                $this->cartModel->addCartItem($cartId, $productId, $quantity, $product['gia']);
            }
            
            // Update session cart
            $this->updateSessionCart($userId);
            
            // Get updated cart items count
            $cartItems = $this->cartModel->getCartItems($userId);
            $cartCount = count($cartItems);
            
            echo json_encode([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'cartCount' => $cartCount
            ]);
            exit;
        }
    }

    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Set header for JSON response
            header('Content-Type: application/json');
            
            if (!isset($_SESSION['user'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
                exit;
            }

            $productId = $_POST['id'];
            $action = $_POST['action'];
            
            $userId = $_SESSION['user']['id'];
            $cartId = $this->cartModel->getOrCreateCart($userId);
            $item = $this->cartModel->getCartItem($cartId, $productId);
            
            if (!$item) {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
                exit;
            }

            $newQuantity = $item['soluong'];
            if ($action === 'increase') {
                $newQuantity++;
            } elseif ($action === 'decrease' && $newQuantity > 1) {
                $newQuantity--;
            }

            $this->cartModel->updateCartItem($cartId, $productId, $newQuantity);
            $this->updateSessionCart($userId);

            // Calculate totals
            $total = $item['gia'] * $newQuantity;
            $totalAll = $this->calculateTotal($userId);

            echo json_encode([
                'success' => true,
                'newQuantity' => $newQuantity,
                'productTotal' => number_format($total, 2),
                'totalAll' => number_format($totalAll, 2)
            ]);
            exit;
        }
    }

    public function removeCart() {
        if (isset($_GET['id'])) {
            if (!isset($_SESSION['user'])) {
                $_SESSION['error_message'] = "Vui lòng đăng nhập";
                header("Location: index.php?page=login");
                exit;
            }

            $productId = $_GET['id'];
            $userId = $_SESSION['user']['id'];
            $cartId = $this->cartModel->getOrCreateCart($userId);
            
            $this->cartModel->removeCartItem($cartId, $productId);
            $this->updateSessionCart($userId);
            
            $_SESSION['success_message'] = "Đã xóa sản phẩm khỏi giỏ hàng";
            header("Location: index.php?page=cart");
            exit;
        }
    }

    private function updateSessionCart($userId) {
        $cartItems = $this->cartModel->getCartItems($userId);
        if ($cartItems) {
            $_SESSION['cart'] = array_map(function($item) {
                return [
                    'id' => $item['id_sanpham'],
                    'name' => $item['tensanpham'],
                    'price' => $item['gia'],
                    'quantity' => $item['soluong'],
                    'image' => $item['hinhanh1']
                ];
            }, $cartItems);
        } else {
            $_SESSION['cart'] = [];
        }
    }

    private function calculateTotal($userId) {
        $cartItems = $this->cartModel->getCartItems($userId);
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['gia'] * $item['soluong'];
        }
        return $total;
    }

    public function viewCart() {
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $this->updateSessionCart($userId);
            
            // Calculate total for all items
            $totalAll = $this->calculateTotal($userId);
        } else {
            $totalAll = 0;
        }

        include 'views/cart/cart.php';
    }

    public function checkout() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để thanh toán";
            header("Location: index.php?page=login");
            exit;
        }

        if (empty($_SESSION['cart'])) {
            $_SESSION['error_message'] = "Giỏ hàng trống";
            header("Location: index.php?page=cart");
            exit;
        }

        // Process checkout logic here
        // ...

        $_SESSION['success_message'] = "Đặt hàng thành công";
        header("Location: index.php?page=home");
        exit;
    }
}

?>
