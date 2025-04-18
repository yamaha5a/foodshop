<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Chi tiết</a></li>
        <li class="breadcrumb-item active text-white">Sản phẩm</li>
            </ol>
        </div>
        <div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="border rounded">
                            <div id="productImageSlider" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php if (!empty($product['hinhanh1'])): ?>
                                        <div class="carousel-item active">
                                            <img src="upload/<?= htmlspecialchars($product['hinhanh1']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['tensanpham']) ?>">
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($product['hinhanh2'])): ?>
                                        <div class="carousel-item">
                                            <img src="upload/<?= htmlspecialchars($product['hinhanh2']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['tensanpham']) ?>">
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($product['hinhanh3'])): ?>
                                        <div class="carousel-item">
                                            <img src="upload/<?= htmlspecialchars($product['hinhanh3']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['tensanpham']) ?>">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($product['hinhanh2']) || !empty($product['hinhanh3'])): ?>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#productImageSlider" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#productImageSlider" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">Tên sản phẩm: <?= htmlspecialchars($product['tensanpham']) ?></h4>
                        <p class="mb-3">Danh mục: <?= htmlspecialchars($product['tendanhmuc']) ?></p>
                        <h5 class="fw-bold mb-3">
                            <?php if (isset($product['is_discounted']) && $product['is_discounted']): ?>
                                <span class="text-decoration-line-through text-muted"><?= number_format($product['gia'], 0, ',', '.') ?> VNĐ</span><br>
                                <span class="text-danger"><?= number_format($product['giagiam'], 0, ',', '.') ?> VNĐ</span>
                            <?php else: ?>
                                <?= number_format($product['gia'], 0, ',', '.') ?> VNĐ
                            <?php endif; ?>
                        </h5>
                        <div class="d-flex mb-4">Đánh giá:    
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <span class="badge bg-info me-2">Số lượng:</span>
                            <span class="fw-bold <?= $product['soluong'] > 10 ? 'text-success' : ($product['soluong'] > 0 ? 'text-warning' : 'text-danger') ?>">
                                <?= htmlspecialchars($product['soluong']); ?>
                            </span>
                        </div>
                        <p class="mb-4">Mô tả: <?= nl2br(htmlspecialchars($product['chitiet'])) ?></p>
                        <div class="input-group quantity mb-5" style="width: 100px;">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border" id="decrease-btn">
                                    <i class="fa fa-minus"></i>
                                </button>   
                            </div>
                            <input type="text" id="quantity-input" class="form-control form-control-sm text-center border-0" value="1" data-available="<?= $product['soluong'] ?>">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border" id="increase-btn">
                                    <i class="fa fa-plus"></i>  
                                </button>
                            </div>
                        </div>
                        <small class="text-muted d-block mb-3">Còn lại: <?= $product['soluong'] ?> sản phẩm</small>

                        <?php if (isset($toppings) && count($toppings) > 0): ?>
                        <div class="mb-4">
                            <h5>Toppings</h5>
                            <div class="topping-selection">
                                <?php foreach ($toppings as $topping): ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input topping-checkbox" type="checkbox" 
                                           name="toppings[]" 
                                           value="<?= $topping['id_topping'] ?>" 
                                           id="topping_<?= $topping['id_topping'] ?>"
                                           data-price="<?= $topping['gia'] ?>">
                                    <label class="form-check-label" for="topping_<?= $topping['id_topping'] ?>">
                                        <?= htmlspecialchars($topping['tentopping']) ?> 
                                        (+<?= number_format($topping['gia'], 0, ',', '.') ?> VNĐ)
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <form method="post" action="index.php?page=addToCart" onsubmit="return addToCart(event)" class="add-to-cart-form">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" id="quantity-hidden" value="1">
                            <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="row g-4 fruite">
                    <div class="col-lg-12">
                        <div class="input-group w-100 mx-auto d-flex mb-4">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                        <div class="mb-4">
                            <h4>Danh mục sản phẩm</h4>
                            <ul class="list-unstyled fruite-categorie">
                                <?php if (isset($categories) && count($categories) > 0): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="index.php?page=product&category=<?= $category['id'] ?>">
                                                    <i class="fas fa-apple-alt me-2"></i><?= htmlspecialchars($category['tendanhmuc']) ?>
                                                </a>
                                                <span>(<?= $category['soluong'] ?>)</span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-center">Không có danh mục nào</p>
                                <?php endif; ?>
                                
                            </ul>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="col-lg-12">
            <nav>
                <div class="nav nav-tabs mb-3">
                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                        id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                        aria-controls="nav-about" aria-selected="true">Chi tiết sản phẩm</button>
                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                        aria-controls="nav-mission" aria-selected="false">Đánh giá</button>
                </div>
            </nav>
            <div class="tab-content mb-5">
                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                    <p><?= nl2br(htmlspecialchars($product['mota'])) ?></p>
                </div>
                <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                    <?php if (isset($comments) && count($comments) > 0): ?>
                        <?php foreach ($comments as $comment): ?>
                        <div class="d-flex mb-4">
                            <img src="upload/<?= htmlspecialchars($comment['hinhanh']) ?>" 
                                 class="img-fluid rounded-circle p-3" 
                                 style="width: 100px; height: 100px;" 
                                 alt="<?= htmlspecialchars($comment['ten']) ?>">
                            <div class="ms-3">
                                <p class="mb-2" style="font-size: 14px;">
                                    <?= date('d/m/Y H:i', strtotime($comment['ngaydang'])) ?>
                                </p>
                                <div class="d-flex justify-content-between">
                                    <h5><?= htmlspecialchars($comment['ten']) ?></h5>
                                    <div class="d-flex mb-3">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa fa-star <?= $i <= $comment['danhgia'] ? 'text-secondary' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p><?= nl2br(htmlspecialchars($comment['noidung'])) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">Chưa có đánh giá nào cho sản phẩm này.</p>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user'])): ?>
                    <div class="mt-4">
                        <h5>Viết đánh giá của bạn</h5>
                        <?php 
                        $comment_count = get_comment_count($_SESSION['user']['id'], $product['id']);
                        $remaining = 5 - $comment_count;
                        if ($remaining > 0): 
                        ?>
                        <p class="text-muted">Bạn còn <?= $remaining ?> lượt bình luận cho sản phẩm này</p>
                        
                        <?php if (isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success">
                                <?= $_SESSION['success_message'] ?>
                                <?php unset($_SESSION['success_message']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['error_message'] ?>
                                <?php unset($_SESSION['error_message']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" action="index.php?page=addComment">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label">Đánh giá của bạn</label>
                                <div class="rating">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required>
                                        <label for="star<?= $i ?>"><i class="fa fa-star"></i></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                        <?php else: ?>
                        <p class="text-danger">Bạn đã đạt giới hạn 5 bình luận cho sản phẩm này</p>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <p class="text-center mt-4">
                        <a href="index.php?page=login" class="text-primary">Đăng nhập</a> để viết đánh giá
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
        <h1 class="fw-bold mb-0">Sản phẩm liên quan</h1>
                <div class="vesitable">
                    <div class="owl-carousel vegetable-carousel justify-content-center">
                        <?php if (isset($related_products) && count($related_products) > 0): ?>
                            <?php foreach ($related_products as $related): ?>
                                <div class="border border-primary rounded position-relative vesitable-item mx-2">
                                    <div class="vesitable-img" style="cursor: pointer;" onclick="loadProductDetail(<?= $related['id'] ?>)">
                                        <?php
                                        if (!empty($related['hinhanh1'])) {
                                            $image_path = 'upload/' . htmlspecialchars($related['hinhanh1']);
                                        } else {
                                            $image_path = 'upload/fruite-item-2.jpg';
                                        }
                                        ?>
                                        <img src="<?= $image_path ?>" class="img-fluid w-100 rounded-top" alt="<?= htmlspecialchars($related['tensanpham']) ?>">
                                    </div>
                                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                                        <?= htmlspecialchars($related['tendanhmuc']) ?>
                                    </div>
                                    <div class="p-4 pb-0 rounded-bottom">
                                        <h4 class="product-name" style="cursor: pointer;" onclick="loadProductDetail(<?= $related['id'] ?>)"><?= htmlspecialchars($related['tensanpham']) ?></h4>
                                        <p class="product-description"><?= htmlspecialchars($related['mota']) ?></p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <?php if (isset($related['is_discounted']) && $related['is_discounted']): ?>
                                                <p class="text-dark fs-5 fw-bold">
                                                    <span class="text-decoration-line-through text-muted"><?= number_format($related['gia'], 0, ',', '.') ?> VNĐ</span><br>
                                                    <span id="related-price-<?= $related['id'] ?>" class="text-danger discounted" 
                                                          data-original-price="<?= $related['gia'] ?>" 
                                                          data-discounted-price="<?= $related['giagiam'] ?>">
                                                        <?= number_format($related['giagiam'], 0, ',', '.') ?> VNĐ
                                                    </span>
                                                </p>
                                            <?php else: ?>
                                                <p class="text-dark fs-5 fw-bold">
                                                    <span id="related-price-<?= $related['id'] ?>">
                                                        <?= number_format($related['gia'], 0, ',', '.') ?> VNĐ
                                                    </span>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="p-4 pt-0">
                                        <form method="post" action="index.php?page=addToCart" onsubmit="return addRelatedToCart(event, <?= $related['id'] ?>)" class="text-center">
                                            <input type="hidden" name="product_id" value="<?= $related['id'] ?>">
                                            <input type="hidden" name="quantity" id="related-quantity-hidden-<?= $related['id'] ?>" value="1">
                                            <button type="submit" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">
                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm vào giỏ hàng
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <p class="text-muted">Không có sản phẩm liên quan trong danh mục này</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
.rating input {
    display: none;
}
.rating label {
    cursor: pointer;
    font-size: 1.5em;
    color: #ddd;
    padding: 0 2px;
}
.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
    color: #ffd700;
}

/* Styles for product display */
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

/* Styles for related products in carousel */
.vesitable-item h4 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 1.5em;
}

.vesitable-item p {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 3em;
}
</style>
<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Hàm tăng số lượng
function increaseQuantity() {
    const input = document.getElementById('quantity-input');
    const hiddenInput = document.getElementById('quantity-hidden');
    let value = parseInt(input.value);
    value = isNaN(value) ? 0 : value;
    
    // Get the available quantity from the data attribute
    const availableQuantity = parseInt(input.getAttribute('data-available') || '100');
    
    if (value < availableQuantity) {
        value++;
        input.value = value;
        hiddenInput.value = value;
    } else {
        // Show specific error message for maximum stock reached
        Swal.fire({
            title: 'Đã đạt tối đa!',
            text: `Sản phẩm đã đạt số lượng tối đa trong kho (${availableQuantity})`,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    }
}

// Hàm giảm số lượng
function decreaseQuantity() {
    const input = document.getElementById('quantity-input');
    const hiddenInput = document.getElementById('quantity-hidden');
    let value = parseInt(input.value);
    value = isNaN(value) ? 0 : value;
    if (value > 1) {
        value--;
        input.value = value;
        hiddenInput.value = value;
    }
}

// Hàm tăng số lượng cho sản phẩm liên quan
function increaseRelatedQuantity(productId) {
    const input = document.getElementById(`related-quantity-${productId}`);
    const hiddenInput = document.getElementById(`related-quantity-hidden-${productId}`);
    let value = parseInt(input.value);
    value = isNaN(value) ? 0 : value;
    
    // Get the available quantity from the data attribute
    const availableQuantity = parseInt(input.getAttribute('data-available') || '100');
    
    if (value < availableQuantity) {
        value++;
        input.value = value;
        hiddenInput.value = value;
    } else {
        // Show specific error message for maximum stock reached
        Swal.fire({
            title: 'Đã đạt tối đa!',
            text: `Sản phẩm đã đạt số lượng tối đa trong kho (${availableQuantity})`,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    }
}

// Hàm giảm số lượng cho sản phẩm liên quan
function decreaseRelatedQuantity(productId) {
    const input = document.getElementById(`related-quantity-${productId}`);
    const hiddenInput = document.getElementById(`related-quantity-hidden-${productId}`);
    let value = parseInt(input.value);
    value = isNaN(value) ? 0 : value;
    if (value > 1) {
        value--;
        input.value = value;
        hiddenInput.value = value;
    }
}

// Thêm sản phẩm liên quan vào giỏ hàng
function addRelatedToCart(event, productId) {
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
    
    // Thêm thông tin về sản phẩm giảm giá nếu có
    const priceElement = document.querySelector(`#related-price-${productId}`);
    if (priceElement && priceElement.classList.contains('discounted')) {
        formData.append('is_discounted', '1');
        formData.append('discounted_price', priceElement.getAttribute('data-discounted-price'));
    }
    
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

// Thêm event listeners cho các nút tăng giảm
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners cho nút tăng giảm
    const increaseBtn = document.getElementById('increase-btn');
    const decreaseBtn = document.getElementById('decrease-btn');
    const quantityInput = document.getElementById('quantity-input');
    const hiddenInput = document.getElementById('quantity-hidden');
    
    // Xóa tất cả event listeners cũ (nếu có)
    const newIncreaseBtn = increaseBtn.cloneNode(true);
    const newDecreaseBtn = decreaseBtn.cloneNode(true);
    
    increaseBtn.parentNode.replaceChild(newIncreaseBtn, increaseBtn);
    decreaseBtn.parentNode.replaceChild(newDecreaseBtn, decreaseBtn);
    
    // Thêm event listeners mới
    newIncreaseBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        increaseQuantity();
    });
    
    newDecreaseBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        decreaseQuantity();
    });
    
    // Add event listener for manual quantity input
    quantityInput.addEventListener('change', function() {
        let value = parseInt(this.value);
        const availableQuantity = parseInt(this.getAttribute('data-available') || '100');
        
        if (isNaN(value) || value < 1) {
            value = 1;
        } else if (value > availableQuantity) {
            value = availableQuantity;
            Swal.fire({
                title: 'Đã đạt tối đa!',
                text: `Sản phẩm đã đạt số lượng tối đa trong kho (${availableQuantity})`,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
        
        this.value = value;
        hiddenInput.value = value;
    });
    
    // Event listeners cho các nút tăng giảm của sản phẩm liên quan
    const relatedIncreaseBtns = document.querySelectorAll('.related-increase-btn');
    const relatedDecreaseBtns = document.querySelectorAll('.related-decrease-btn');
    const relatedQuantityInputs = document.querySelectorAll('.related-quantity-input');
    
    relatedIncreaseBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.getAttribute('data-product-id');
            increaseRelatedQuantity(productId);
        });
    });
    
    relatedDecreaseBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.getAttribute('data-product-id');
            decreaseRelatedQuantity(productId);
        });
    });
    
    relatedQuantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.id.replace('related-quantity-', '');
            const hiddenInput = document.getElementById(`related-quantity-hidden-${productId}`);
            let value = parseInt(this.value);
            const availableQuantity = parseInt(this.getAttribute('data-available') || '100');
            
            if (isNaN(value) || value < 1) {
                value = 1;
            } else if (value > availableQuantity) {
                value = availableQuantity;
                Swal.fire({
                    title: 'Đã đạt tối đa!',
                    text: `Sản phẩm đã đạt số lượng tối đa trong kho (${availableQuantity})`,
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            }
            
            this.value = value;
            hiddenInput.value = value;
        });
    });
    
    // Event listeners cho các form add to cart
    const forms = document.querySelectorAll('form[action="index.php?page=addToCart"]');
    forms.forEach(form => {
        form.addEventListener('submit', addToCart);
    });
});

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
    
    // Thêm thông tin về sản phẩm giảm giá nếu có
    <?php if ($product['is_discounted']): ?>
    formData.append('is_discounted', '1');
    formData.append('discounted_price', '<?= $product['giagiam'] ?>');
    <?php endif; ?>
    
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

function loadProductDetail(productId) {
    // Hiển thị loading
    Swal.fire({
        title: 'Đang tải...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Gửi request AJAX để lấy thông tin sản phẩm
    fetch('index.php?page=detail&id=' + productId)
        .then(response => response.text())
        .then(html => {
            // Tạo một div ẩn để chứa response
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            // Lấy nội dung chính từ response
            const mainContent = tempDiv.querySelector('.container-fluid.py-5.mt-5');
            
            if (mainContent) {
                // Thay thế nội dung hiện tại bằng nội dung mới
                document.querySelector('.container-fluid.py-5.mt-5').innerHTML = mainContent.innerHTML;
                
                // Cập nhật URL mà không reload trang
                window.history.pushState({}, '', 'index.php?page=detail&id=' + productId);
                
                // Khởi tạo lại các script và style cần thiết
                initializeScripts();
                
                // Đóng loading
                Swal.close();
            } else {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Không thể tải thông tin sản phẩm',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Lỗi!',
                text: 'Có lỗi xảy ra khi tải thông tin sản phẩm',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
}

// Hàm khởi tạo lại các script và style cần thiết
function initializeScripts() {
    // Khởi tạo lại carousel
    if (typeof $.fn.owlCarousel !== 'undefined') {
        $('.vegetable-carousel').owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            center: true,
            margin: 30,
            dots: true,
            loop: true,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });
    }
    
    // Khởi tạo lại các event listener cho nút tăng giảm số lượng
    document.addEventListener('DOMContentLoaded', function() {
        // Event listeners cho nút tăng giảm
        const increaseBtn = document.getElementById('increase-btn');
        const decreaseBtn = document.getElementById('decrease-btn');
        const quantityInput = document.getElementById('quantity-input');
        const hiddenInput = document.getElementById('quantity-hidden');
        
        if (increaseBtn && decreaseBtn && quantityInput && hiddenInput) {
            // Xóa tất cả event listeners cũ (nếu có)
            const newIncreaseBtn = increaseBtn.cloneNode(true);
            const newDecreaseBtn = decreaseBtn.cloneNode(true);
            
            increaseBtn.parentNode.replaceChild(newIncreaseBtn, increaseBtn);
            decreaseBtn.parentNode.replaceChild(newDecreaseBtn, decreaseBtn);
            
            // Thêm event listeners mới
            newIncreaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                increaseQuantity();
            });
            
            newDecreaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                decreaseQuantity();
            });
            
            // Add event listener for manual quantity input
            quantityInput.addEventListener('change', function() {
                let value = parseInt(this.value);
                const availableQuantity = parseInt(this.getAttribute('data-available') || '100');
                
                if (isNaN(value) || value < 1) {
                    value = 1;
                } else if (value > availableQuantity) {
                    value = availableQuantity;
                    Swal.fire({
                        title: 'Đã đạt tối đa!',
                        text: `Sản phẩm đã đạt số lượng tối đa trong kho (${availableQuantity})`,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }
                
                this.value = value;
                hiddenInput.value = value;
            });
        }
    });
}
</script>