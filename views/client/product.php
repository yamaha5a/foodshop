<?php
require_once 'models/Product.php';

$productModel = new Product();
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$products = $search ? $productModel->searchProducts($search) : $productModel->getAllProducts();
?>

<!-- Product Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="border-bottom border-5 border-primary mb-5">
            <h1 class="display-5 text-uppercase text-center mb-0">
                <?php echo $search ? "Kết quả tìm kiếm: " . htmlspecialchars($search) : "Tất cả sản phẩm"; ?>
            </h1>
        </div>

        <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <h3>Không tìm thấy sản phẩm nào</h3>
                <p>Vui lòng thử lại với từ khóa khác</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="product-item">
                            <div class="position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="text-center p-4">
                                <h5 class="text-uppercase mb-3"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="mb-0"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</p>
                                <button class="btn btn-primary mt-3 add-to-cart" data-id="<?php echo $product['id']; ?>">
                                    <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Product End -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý thêm vào giỏ hàng
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            // Lấy số lượng sản phẩm hiện tại trong giỏ hàng
            let cartCount = parseInt(localStorage.getItem('cartCount') || 0);
            // Tăng số lượng lên 1
            cartCount++;
            // Lưu lại vào localStorage
            localStorage.setItem('cartCount', cartCount);
            // Cập nhật số lượng hiển thị trên icon giỏ hàng
            document.getElementById('cart-count').textContent = cartCount;
            // Thông báo thành công
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        });
    });
});
</script> 