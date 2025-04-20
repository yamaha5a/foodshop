<?php
session_start();
?>
<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SHOP FOOD - LONGBEO</title>
    <link rel="icon" type="" href="upload/logo.jpg">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="public/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="public/css/style.css" rel="stylesheet">
    
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body>
<?php
include 'views/client/header.php'; // Load header

$page = $_GET['page'] ?? 'home';    

switch ($page) {
    case 'home':
        require_once 'controller/banner.php';
        require_once 'controller/sanpham.php';
        require_once 'controller/sanphamgiamgia.php';
        $bannerController = new BannerController();
        $bannerController->showBanners();
        include 'views/home/sliderbar.php'; 
        $sanphamController = new SanPhamController();
        $sanphams = $sanphamController->getProducts();
        $sanphamGiamGiaController = new SanPhamGiamGiaController();
        $sanphamgiamgia = $sanphamGiamGiaController->getDiscountProducts();
        include 'views/home/home.php';
        break;
    case 'about':
        include 'views/about/about.php';
        break;
    case 'contact':
        require_once 'controller/contact.php';
        $contactController = new ContactController();
        $contactController->viewContact();
        break;
        
    case 'sendContact':
        require_once 'controller/contact.php';
        $contactController = new ContactController();
        $contactController->sendContact();
        break;
        
    case 'contactDetail':
        require_once 'controller/contact.php';
        $contactController = new ContactController();
        $contactController->viewContactDetail();
        break;

    case 'product':
        require_once 'controller/sanpham.php';
        $productController = new SanPhamController();
        $productController->listProduct();
        break;
    
    case 'cart':
        require_once 'controller/cart.php';
        $cartController = new CartController();
        $cartController->viewCart();
        break;
    
    case 'addToCart':
        require_once 'controller/cart.php';
        $cart = new CartController();
        $cart->addToCart();
        break;
    case 'updateCart':
        require_once 'controller/cart.php';
        $cartController = new CartController();
        $cartController->updateCart();
        break;
    case 'removeCart':
        require_once 'controller/cart.php';
        $cartController = new CartController();
        $cartController->removeCart();
        break;
                    
    case 'checkout':
        require_once 'controller/checkout.php';
        $checkoutController = new CheckoutController();
        $checkoutController->viewCheckout();
        break;

    case 'processCheckout':
        require_once 'controller/checkout.php';
        $checkoutController = new CheckoutController();
        $checkoutController->processCheckout();
        break;

    case 'detail':
        require_once 'controller/detail.php';
        $detailController = new DetailController();
    
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            $detailController->showDetail($id);
        } else {
            include 'views/404.php';
        }
        break;
    case 'addComment':
        require_once 'controller/binhluan.php';
        $commentController = new CommentController();
        $commentController->addComment();
        break;
    case 'login':
        include 'controller/login.php';
        $login = new AuthController();
        $login->login();
        break;
    case 'register':
        include 'controller/login.php';
        $login = new AuthController();
        $login->register();
        break;
    case 'logout':
        include 'controller/login.php';
        $login = new AuthController();
        $login->logout();   
        break;
    case 'profile':
        include 'views/profile/profile.php';
        break;
    case 'changeAvatar':
        require_once 'controller/profile.php';
        $profileController = new ProfileController();
        $profileController->changeAvatar();
        break;
    case 'orders':
        require_once 'controller/order.php';
        $orderController = new OrderController();
        $orderController->viewOrders();
        break;

    case 'orderDetails':
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để xem chi tiết đơn hàng";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit;
        }
        require_once 'controller/order.php';
        $orderController = new OrderController();
        $orderController->viewOrderDetails();
        break;
    case 'cancelOrder':
        require_once 'controller/order.php';
        $orderController = new OrderController();
        $orderController->cancelOrder();
        break;
    case 'applyDiscount':
        require_once 'controller/khuyenmai.php';
        $khuyenMaiController = new KhuyenMaiController();
        $khuyenMaiController->applyDiscount();
        break;
    case 'discount':
        require_once 'controller/sanphamgiamgia.php';
        $sanphamGiamGiaController = new SanPhamGiamGiaController();
        $sanphamGiamGiaController->listAllDiscountProducts();
        break;

    case 'changePassword':
        require_once 'controller/login.php';
        $authController = new AuthController();
        $authController->changePassword();
        break;

    default:
        include 'views/404.php';
        break;
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/lib/easing/easing.min.js"></script>
<script src="public/lib/waypoints/waypoints.min.js"></script>
<script src="public/lib/lightbox/js/lightbox.min.js"></script>
<script src="public/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="public/js/main.js"></script>

<!-- Toastify JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    // Kiểm tra và hiển thị thông báo từ localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const message = localStorage.getItem('message');
        const messageType = localStorage.getItem('messageType');
        
        if (message) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "center",
                backgroundColor: messageType === 'success' ? "#28a745" : "#dc3545",
                stopOnFocus: true,
                onClick: function(){}
            }).showToast();
            
            // Xóa thông báo sau khi hiển thị
            localStorage.removeItem('message');
            localStorage.removeItem('messageType');
        }
    });
</script>

<?php if (isset($_SESSION['success_message'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Toastify({
            text: "<?php echo $_SESSION['success_message']; ?>",
            duration: 3000,
            gravity: "top",
            position: "center",
            backgroundColor: "#28a745",
            stopOnFocus: true,
            onClick: function(){}
        }).showToast();
    });
    <?php unset($_SESSION['success_message']); ?>
</script>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Toastify({
            text: "<?php echo $_SESSION['error_message']; ?>",
            duration: 3000,
            gravity: "top",
            position: "center",
            backgroundColor: "#dc3545",
            stopOnFocus: true,
            onClick: function(){}
        }).showToast();
    });
    <?php unset($_SESSION['error_message']); ?>
</script>
<?php endif; ?>

<?php
    include 'views/client/footer.php';
?>
</body>
</html>
