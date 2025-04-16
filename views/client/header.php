<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Spinner Start -->
<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End -->
<!-- Navbar start -->
<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Trinh văn bô, Hà Nội</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">longok.com@gmail.com</a></small>
            </div>
            <div class="top-link pe-2">
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="text-white"><small class="text-white mx-2">Xin chào, <?php echo htmlspecialchars($_SESSION['user']['ten']); ?></small></span>
                <?php endif; ?>
                <span class="text-white"><small class="text-white mx-2">Giờ mở cửa: 7:00 AM - 24:00 PM</small>/</span>
                <span class="text-white"><small class="text-white mx-2">Thời gian phục vụ: 7 ngày trong tuần</small></span>
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="index.php?page=home" class="navbar-brand"><h1 class="text-primary display-6">longBeo</h1></a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php?page=home" class="nav-item nav-link active">Trang chủ</a>





                    
                    <a href="index.php?page=product" class="nav-item nav-link">Cửa hàng</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="index.php?page=cart" class="dropdown-item">Giỏ hàng</a>
                            <a href="index.php?page=checkout" class="dropdown-item">Thanh toán</a>
                            <a href="index.php?page=danhgia" class="dropdown-item">Testimonial</a>
                            <a href="404.html" class="dropdown-item">404 Page</a>
                        </div>
                    </div>
                    <a href="index.php?page=contact" class="nav-item nav-link">Liên Hệ</a>
                    <a href="index.php?page=contact" class="nav-item nav-link">Về chúng tôi</a>
                </div>
                <div class="d-flex m-3 me-0">
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search text-primary"></i>
                    </button>

                    <a href="index.php?page=cart" class="position-relative me-4 my-auto">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                        <span id="cart-count" class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                            style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?></span>
                    </a>

                    <div class="dropdown">
                        <a href="#" class="my-auto dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php if (isset($_SESSION['user'])): ?>
                                <li><a class="dropdown-item" href="index.php?page=profile">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="index.php?page=orders">Đơn hàng của tôi</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?page=logout">Đăng xuất</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="index.php?page=login">Đăng nhập</a></li>
                                <li><a class="dropdown-item" href="index.php?page=register">Đăng ký</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
<script>
    // Khi trang load, đọc dữ liệu từ localStorage
    document.addEventListener('DOMContentLoaded', () => {
        const storedCartCount = localStorage.getItem('cartCount') || 0;
        document.getElementById('cart-count').textContent = storedCartCount;
    });
</script>

