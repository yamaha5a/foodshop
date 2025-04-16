<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Shop</li>
    </ol>
</div>
<!-- Single Page Header End -->
<!-- Fruits Shop Start-->
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
</style>
<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Fresh fruits shop</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-xl-3">
                        <div class="input-group w-100 mx-auto d-flex">
                            <form action="index.php" method="get" class="w-100">
                                <input type="hidden" name="page" value="product">
                                <div class="input-group">
                                    <input type="search" name="search" class="form-control p-3" placeholder="Tìm kiếm sản phẩm..." value="<?= isset($searchParams['keyword']) ? htmlspecialchars($searchParams['keyword']) : '' ?>">
                                    <button type="submit" class="input-group-text p-3"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-6"></div>
                    <div class="col-xl-3">
                        <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                            <label for="fruits">Sắp xếp:</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" form="fruitform">
                                <option value="volvo">Mặc định</option>
                                <option value="saab">Phổ biến</option>
                                <option value="opel">Giá tăng dần</option>
                                <option value="audi">Giá giảm dần</option>
                            </select>
                        </div>
                        <?php if (!empty($searchParams['keyword']) || $searchParams['min_price'] > 0 || $searchParams['max_price'] < PHP_FLOAT_MAX): ?>
                        <div class="mb-3">
                            <a href="index.php?page=product" class="btn btn-outline-secondary w-100">Xóa bộ lọc</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        <?php foreach ($danhMucs as $dm): ?>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="index.php?page=product&danhmuc=<?= $dm['id'] ?>">
                                                        <i class="fas fa-apple-alt me-2"></i>
                                                        <?= htmlspecialchars($dm['tendanhmuc']) ?>
                                                    </a>
                                                    <span>(<?= $dm['soluong'] ?>)</span>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-2">Giá</h4>
                                    <form action="index.php" method="get" id="priceFilterForm">
                                        <input type="hidden" name="page" value="product">
                                        <?php if (isset($searchParams['keyword']) && !empty($searchParams['keyword'])): ?>
                                            <input type="hidden" name="search" value="<?= htmlspecialchars($searchParams['keyword']) ?>">
                                        <?php endif; ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="number" name="min_price" class="form-control me-2" placeholder="Giá tối thiểu" value="<?= isset($searchParams['min_price']) && $searchParams['min_price'] > 0 ? $searchParams['min_price'] : '' ?>">
                                            <span>-</span>
                                            <input type="number" name="max_price" class="form-control ms-2" placeholder="Giá tối đa" value="<?= isset($searchParams['max_price']) && $searchParams['max_price'] < PHP_FLOAT_MAX ? $searchParams['max_price'] : '' ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Lọc theo giá</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Additional</h4>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-1" name="Categories-1" value="Beverages">
                                        <label for="Categories-1"> Organic</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-2" name="Categories-1" value="Beverages">
                                        <label for="Categories-2"> Fresh</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Beverages">
                                        <label for="Categories-3"> Sales</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-4" name="Categories-1" value="Beverages">
                                        <label for="Categories-4"> Discount</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-5" name="Categories-1" value="Beverages">
                                        <label for="Categories-5"> Expired</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <h4 class="mb-3">Featured products</h4>
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="img/featur-1.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Big Banana</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="img/featur-2.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Big Banana</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="img/featur-3.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Big Banana</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center my-4">
                                    <a href="#" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Vew More</a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="position-relative">
                                    <img src="public/img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                    <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                        <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content">
                            <?php foreach ($sanphams as $sanpham): ?>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item">
                                        <div class="fruite-img">
                                        <a href="index.php?page=detail&id=<?= $sanpham['id'] ?>">   
                                        <img src="upload/<?= $sanpham['hinhanh1'] ?>" class="img-fluid w-100 rounded-top" alt="<?php echo htmlspecialchars($sanpham['tensanpham']); ?>">
                                        </a>  
                                    </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div>
                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                            <a href="index.php?page=detail&id=<?= $sanpham['id'] ?>">
                                            <h4><?php echo htmlspecialchars($sanpham['tensanpham']); ?></h4></a>
                                            <p><?php echo htmlspecialchars($sanpham['mota']); ?></p>
                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                <p class="text-dark fs-5 fw-bold mb-0">$<?php echo number_format($sanpham['gia'], 2); ?></p>
                                                <form method="post" action="index.php?page=addToCart" onsubmit="return addToCart(event)">
                                                <input type="hidden" name="product_id" value="<?= $sanpham['id']; ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                                </button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>



                        <div class="col-12">
                            <div class="pagination d-flex justify-content-center mt-5">
                                <?php
                                $baseLink = "index.php?page=product";
                                
                                // Add search parameter if exists
                                if (isset($searchParams['keyword']) && !empty($searchParams['keyword'])) {
                                    $baseLink .= "&search=" . urlencode($searchParams['keyword']);
                                }
                                
                                // Add price filter parameters if they exist
                                if (isset($searchParams['min_price']) && $searchParams['min_price'] > 0) {
                                    $baseLink .= "&min_price=" . $searchParams['min_price'];
                                }
                                
                                if (isset($searchParams['max_price']) && $searchParams['max_price'] < PHP_FLOAT_MAX) {
                                    $baseLink .= "&max_price=" . $searchParams['max_price'];
                                }
                                
                                // Add category parameter if exists
                                if (isset($_GET['danhmuc'])) {
                                    $baseLink .= "&danhmuc=" . $_GET['danhmuc'];
                                }
                                ?>

                                <!-- Nút Previous -->
                                <?php if ($page > 1): ?>
                                    <a href="<?= $baseLink ?>&p=<?= $page - 1 ?>" class="rounded">&laquo;</a>
                                <?php else: ?>
                                    <a href="#" class="rounded disabled" style="pointer-events: none;">&laquo;</a>
                                <?php endif; ?>

                                <!-- Các trang -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <a href="<?= $baseLink ?>&p=<?= $i ?>" class="rounded <?= ($i == $page) ? 'active' : '' ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>

                                <!-- Nút Next -->
                                <?php if ($page < $totalPages): ?>
                                    <a href="<?= $baseLink ?>&p=<?= $page + 1 ?>" class="rounded">&raquo;</a>
                                <?php else: ?>
                                    <a href="#" class="rounded disabled" style="pointer-events: none;">&raquo;</a>
                                <?php endif; ?>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fruits Shop End-->
<script>
function addToCart(event) {
    event.preventDefault();
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
            document.getElementById('cart-count').textContent = cartCount;
            
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

// Update all add to cart forms to use the new function
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[action="index.php?page=addToCart"]');
    forms.forEach(form => {
        form.addEventListener('submit', addToCart);
    });
});

// Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Price filter form submission
    const priceFilterForm = document.getElementById('priceFilterForm');
    if (priceFilterForm) {
        priceFilterForm.addEventListener('submit', function(e) {
            const minPrice = this.querySelector('input[name="min_price"]').value;
            const maxPrice = this.querySelector('input[name="max_price"]').value;
            
            if (minPrice === '' && maxPrice === '') {
                e.preventDefault();
                alert('Vui lòng nhập ít nhất một giá trị để lọc');
            }
        });
    }
    
    // Search form submission
    const searchForm = document.querySelector('form[action="index.php"]');
    if (searchForm) {
        const searchInput = searchForm.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    searchForm.submit();
                }
            });
        }
    }
});
</script>