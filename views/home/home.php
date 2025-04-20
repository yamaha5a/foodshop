<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 999;
    }

    .popup-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        color: #28a745;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
        font-size: 18px;
        font-weight: bold;
        z-index: 1000;
        text-align: center;
    }

    .product-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 3em;
    }
    
    .product-name {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 1.5em;
    }

    .product-link {
        color: inherit;
        text-decoration: none;
    }

    .product-link:hover {
        color: inherit;
        text-decoration: none;
    }

    .position-relative {
        position: relative;
    }

    .stretched-link::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 0;
        content: "";
    }

    /* Ensure the Add to Cart button remains clickable */
    .position-relative [style*="z-index: 1"] {
        position: relative;
        z-index: 1;
    }

    /* Add hover effect to the product card */
    .p-4.rounded.bg-light {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .p-4.rounded.bg-light:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Add hover effect to the regular product cards */
    .fruite-item {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .fruite-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Ensure product name and description don't change color on hover */
    .product-link .text-dark:hover {
        color: inherit !important;
    }

    .product-link:hover .product-description {
        color: inherit;
    }
</style>
<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <div class="container-fluid fruite py-5">
            <div class="container py-5">                                   
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>Sản phẩm mới nhất</h1>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" href="index.php?page=product">
    <span class="text-dark" style="width: 130px;">All Products</span>
</a>
                                </li>
                            </ul>
                        </div>
                    </div>
<!-- sản phẩm -->
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                <?php if (isset($sanphams) && count($sanphams) > 0): ?>
                                <?php foreach ($sanphams as $sanpham): ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <a href="index.php?page=detail&id=<?= $sanpham['id']; ?>" class="text-decoration-none">
                                                    <img src="upload/<?= htmlspecialchars($sanpham['hinhanh1']); ?>" class="img-fluid w-100 rounded-top" alt="<?= htmlspecialchars($sanpham['tensanpham']); ?>">
                                                </a>
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Food</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <a href="index.php?page=detail&id=<?= $sanpham['id']; ?>" class="text-decoration-none">
                                                    <h4 class="text-dark product-name">
                                                        <?= htmlspecialchars($sanpham['tensanpham']); ?>
                                                    </h4>
                                                    <p class="mb-4 product-description"><?= htmlspecialchars($sanpham['chitiet']); ?></p>
                                                </a>
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="w-100 mb-3">
                                                        <p class="text-dark fs-5 fw-bold mb-1">Giá: 
                                                            <?= number_format($sanpham['gia'], 0, ',', '.') ?> VNĐ
                                                        </p>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-primary me-2">Số lượng:</span>
                                                            <span class="fw-bold <?= $sanpham['soluong'] > 10 ? 'text-success' : ($sanpham['soluong'] > 0 ? 'text-warning' : 'text-danger') ?>">
                                                                <?= htmlspecialchars($sanpham['soluong']); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="w-100 text-center">
                                                        <button type="button" class="btn border border-secondary rounded-pill px-4 py-2 text-primary w-100 add-to-cart-btn" 
                                                                data-product-id="<?= $sanpham['id']; ?>">
                                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center">Không có sản phẩm nào để hiển thị.</p>
                            <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
     <!-- Fruits Shop End-->
        <!-- Featurs Start -->
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-secondary rounded border border-secondary">
                                <img src="upload/anh2.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-primary text-center p-4 rounded">
                                        <h5 class="text-white">Sạch sẽ, tiện lợi</h5>
                                        <h3 class="mb-0">20% OFF</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-dark rounded border border-dark">
                                <img src="upload/anh4.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-light text-center p-4 rounded">
                                        <h5 class="text-primary">Dễ dàng </h5>
                                        <h3 class="mb-0">Đặt món yêu thích</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-primary rounded border border-primary">
                                <img src="upload/anh3.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-secondary text-center p-4 rounded">
                                        <h5 class="text-white">Giá rẻ bất chấp</h5>
                                        <h3 class="mb-0">Bất ngờ chưa</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featurs End -->
        <!-- Vesitable Shop Start-->
        <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary">Thức ăn nhanh ngon miệng và tiện lợi</h1>
                <p class="lead text-muted">Khám phá các món ăn nhanh chất lượng cao với giá cả phải chăng</p>
            </div>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php if (isset($sanphams) && count($sanphams) > 0): ?>
                    <?php foreach ($sanphams as $sanpham): ?>
                        <div class="border border-primary rounded position-relative vesitable-item shadow-sm">
                            <div class="vesitable-img">
                                <a href="index.php?page=detail&id=<?= $sanpham['id']; ?>" class="text-decoration-none">
                                    <img src="upload/<?= htmlspecialchars($sanpham['hinhanh1']); ?>" class="img-fluid w-100 rounded-top" alt="<?= htmlspecialchars($sanpham['tensanpham']); ?>">
                                </a>
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Thức ăn nhanh</div>
                            <div class="p-4 rounded-bottom">
                                <a href="index.php?page=detail&id=<?= $sanpham['id']; ?>" class="text-decoration-none">
                                    <h4 class="mb-3 product-name"><?= htmlspecialchars($sanpham['tensanpham']); ?></h4>
                                    <p class="text-muted mb-3 product-description"><?= htmlspecialchars($sanpham['chitiet']); ?></p>
                                </a>
                                <div class="d-flex flex-column">
                                    <div class="mb-3">
                                        <p class="text-dark fs-5 fw-bold mb-1"><?= number_format($sanpham['gia'], 0, ',', '.') ?> VNĐ</p>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-info me-2">Số lượng:</span>
                                            <span class="fw-bold <?= $sanpham['soluong'] > 10 ? 'text-success' : ($sanpham['soluong'] > 0 ? 'text-warning' : 'text-danger') ?>">
                                                <?= htmlspecialchars($sanpham['soluong']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="w-100 text-center">
                                        <button type="button" class="btn border border-secondary rounded-pill px-4 py-2 w-100 text-primary add-to-cart-btn" 
                                                data-product-id="<?= $sanpham['id']; ?>">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Không có sản phẩm nào để hiển thị.</p>
                <?php endif; ?>
            </div>
        </div>
               
        <!-- Vesitable Shop End -->


        <!-- Banner Section Start-->
        <div class="container-fluid banner bg-secondary my-5">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="py-4">
                            <h1 class="display-3 text-white">Chào mừng bạn đến với ShopFood!</h1>
                            <p class="fw-normal display-3 text-dark mb-4">Mua Ngay</p>
                            <p class="mb-4 text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic words etc.</p>
                            <a href="#" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">BUY</a>
                        </div>  
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="img/baner-1.png" class="img-fluid w-100 rounded" alt="">
                            <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute" style="width: 140px; height: 140px; top: 0; left: 0;">
                                <h1 style="font-size: 100px;">1</h1>
                                <div class="d-flex flex-column">
                                    <span class="h2 mb-0">50$</span>
                                    <span class="h4 text-muted mb-0">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner Section End -->


        <!-- Bestsaler Product Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-4">Sản phẩm giảm giá</h1>
                    <p>Với mục đích nâng cao nhu cầu khách hàng chúng tôi đã giảm giá sản phẩm</p>
                </div>
                <div class="row g-4">
                    <?php if (isset($sanphamgiamgia) && count($sanphamgiamgia) > 0): ?>
                        <?php foreach ($sanphamgiamgia as $spg): ?>
                            <div class="col-lg-6 col-xl-4">
                                <div class="p-4 rounded bg-light">
                                    <div class="row align-items-center position-relative">
                                        <a href="index.php?page=detail&id=<?= $spg['id'] ?>" class="text-decoration-none stretched-link product-link">
                                            <div class="col-6">
                                                <img src="upload/<?= htmlspecialchars($spg['hinhanh1']); ?>" class="img-fluid rounded-circle w-100" alt="<?= htmlspecialchars($spg['tensanpham']); ?>">
                                            </div>
                                            <div class="col-6">
                                                <h5 class="text-dark"><?= htmlspecialchars($spg['tensanpham']); ?></h5>
                                                <div class="d-flex my-3">
                                                    <i class="fas fa-star text-primary"></i>
                                                    <i class="fas fa-star text-primary"></i>
                                                    <i class="fas fa-star text-primary"></i>
                                                    <i class="fas fa-star text-primary"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <h4 class="mb-0 text-danger"><?= number_format($spg['giagiam'], 0, ',', '.') ?> VNĐ</h4>
                                                    <h5 class="mb-0 text-muted text-decoration-line-through ms-2"><?= number_format($spg['gia'], 0, ',', '.') ?> VNĐ</h5>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="col-12 mt-3 position-relative" style="z-index: 1;">
                                            <form method="post" action="index.php?page=addToCart" onsubmit="return addToCart(event)">
                                                <input type="hidden" name="product_id" value="<?= $spg['id']; ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="is_discounted" value="1">
                                                <input type="hidden" name="discounted_price" value="<?= $spg['giagiam']; ?>">
                                                <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary w-100">
                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Hiện không có sản phẩm giảm giá nào.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Bestsaler Product End -->


        <!-- Fact Start -->
        <div class="container-fluid py-5">
            <div class="container">
                <div class="bg-light p-5 rounded">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Khách hàng hài lòng</h4>
                                <h1>1963</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Chất lượng dịch vụ</h4>
                                <h1>99%</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Chứng chỉ đảm bảo chất lượng</h4>
                                <h1>33</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Sản phẩm đang có sẵn</h4>
                                <h1>89</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fact Start -->
<script>
function addToCart(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const form = event.target;
    
    // Kiểm tra đăng nhập trước khi gửi request
    <?php if (!isset($_SESSION['user'])): ?>
        Swal.fire({
            title: 'Thông báo!',
            text: 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đăng nhập',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?page=login";
            }
        });
        return false;
    <?php endif; ?>
    
    // Lấy dữ liệu từ form
    const formData = new FormData(form);
    
    // Gửi request AJAX
    fetch('index.php?page=addToCart', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(html => {
        // Tạo một div ẩn để chứa response
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        
        // Lấy thông báo từ session
        const successMessage = tempDiv.querySelector('meta[name="success_message"]')?.content;
        const errorMessage = tempDiv.querySelector('meta[name="error_message"]')?.content;
        const cartCount = tempDiv.querySelector('meta[name="cart_count"]')?.content;
        
        if (successMessage) {
            // Cập nhật số lượng giỏ hàng từ session
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = cartCount;
            } else {
                console.log('Element with ID "cart-count" not found');
            }
            
            Swal.fire({
                title: 'Thành công!',
                text: successMessage,
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 1500,
                showConfirmButton: false
            });
        } else if (errorMessage) {
            Swal.fire({
                title: 'Lỗi!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Lỗi!',
            text: 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
    
    return false;
}

// Add this new function to handle the "Add to cart" button clicks
document.addEventListener('DOMContentLoaded', function() {
    // Handle the new button-based approach
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            
            const productId = this.getAttribute('data-product-id');
            
            // Kiểm tra đăng nhập trước khi gửi request
            <?php if (!isset($_SESSION['user'])): ?>
                Swal.fire({
                    title: 'Thông báo!',
                    text: 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đăng nhập',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "index.php?page=login";
                    }
                });
                return false;
            <?php endif; ?>
            
            // Tạo FormData
            const formData = new FormData();
            formData.append('product_id', productId);
            
            // Gửi request AJAX
            fetch('index.php?page=addToCart', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                // Tạo một div ẩn để chứa response
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                
                // Lấy thông báo từ session
                const successMessage = tempDiv.querySelector('meta[name="success_message"]')?.content;
                const errorMessage = tempDiv.querySelector('meta[name="error_message"]')?.content;
                const cartCount = tempDiv.querySelector('meta[name="cart_count"]')?.content;
                
                if (successMessage) {
                    // Cập nhật số lượng giỏ hàng từ session
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = cartCount;
                    } else {
                        console.log('Element with ID "cart-count" not found');
                    }
                    
                    Swal.fire({
                        title: 'Thành công!',
                        text: successMessage,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else if (errorMessage) {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
});
</script>

