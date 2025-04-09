       <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Shop Detail</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
                <li class="breadcrumb-item"><a href="index.php?page=detail">Pages</a></li>
                <li class="breadcrumb-item active text-white">Shop Detail</li>
            </ol>
        </div>
        <div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="border rounded">
                        <a href="index.php?page=detail&id=<?= $product['id'] ?>">
                                <img src="<?= htmlspecialchars($product['hinhanh1']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['tensanpham']) ?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3"><?= htmlspecialchars($product['tensanpham']) ?></h4>
                        <p class="mb-3">Category: <?= isset($product['danhmuc']) ? htmlspecialchars($product['danhmuc']) : 'N/A' ?></p>
                        <h5 class="fw-bold mb-3">$<?= number_format($product['gia'], 2) ?></h5>
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
                        <button class="btn btn-primary rounded-pill px-4">
                            <i class="fa fa-shopping-bag me-2"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>
            </div>

                                 