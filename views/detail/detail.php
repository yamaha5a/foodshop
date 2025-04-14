<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Shop</li>
    </ol>
</div>
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="border rounded">
                            <a href="#">
                                <img src="upload/<?= htmlspecialchars($product['hinhanh1']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['tensanpham']) ?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3"><?= htmlspecialchars($product['tensanpham']) ?></h4>
                        <p class="mb-3">Category: <?= htmlspecialchars($product['tendanhmuc']) ?></p>
                        <h5 class="fw-bold mb-3"><?= number_format($product['gia'], 0, ',', '.') ?> VNĐ</h5>
                        <div class="d-flex mb-4">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <p class="mb-4"><?= nl2br(htmlspecialchars($product['mota'])) ?></p>
                        <div class="input-group quantity mb-5" style="width: 100px;">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <form method="post" action="index.php?page=addToCart" onsubmit="return checkLogin(event)">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
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
<div class="col-lg-12">
    <div class="text-center mb-5">
        <h1 class="fw-bold mb-0">Sản phẩm liên quan</h1>
    </div>
    <div class="vesitable">
        <div class="owl-carousel vegetable-carousel justify-content-center">
            <?php if (isset($related_products) && count($related_products) > 0): ?>
                <?php foreach ($related_products as $related): ?>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <a href="index.php?page=detail&id=<?= $related['id'] ?>">
                                <img src="upload/<?= htmlspecialchars($related['hinhanh1']) ?>" class="img-fluid w-100 rounded-top" alt="<?= htmlspecialchars($related['tensanpham']) ?>">
                            </a>
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                            <?= htmlspecialchars($related['tendanhmuc']) ?>
                        </div>
                        <div class="p-4 pb-0 rounded-bottom">
                            <h4>
                                <a href="index.php?page=detail&id=<?= $related['id'] ?>" class="text-dark text-decoration-none">
                                    <?= htmlspecialchars($related['tensanpham']) ?>
                                </a>
                            </h4>
                            <p><?= htmlspecialchars($related['mota']) ?></p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0"><?= number_format($related['gia'], 0, ',', '.') ?> VNĐ</p>
                                <form method="post" action="index.php?page=addToCart" onsubmit="return checkLogin(event)">
                                    <input type="hidden" name="product_id" value="<?= $related['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center p-4">
                    <p class="text-muted">Không có sản phẩm liên quan</p>
                </div>
            <?php endif; ?>
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
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('index.php?page=addToCart', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng giỏ hàng
                    document.getElementById('cart-count').textContent = data.cart_count;
                    
                    // Hiển thị thông báo thành công
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
            });
        });
    });
});
</script>