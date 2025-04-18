<div class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar filters -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Bộ lọc</h5>
                </div>
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select name="danhmuc" class="form-select">
                                <option value="">Tất cả</option>
                                <?php foreach ($danhMucs as $danhMuc): ?>
                                    <option value="<?= $danhMuc['id'] ?>" <?= isset($_GET['danhmuc']) && $_GET['danhmuc'] == $danhMuc['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($danhMuc['tendanhmuc']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sắp xếp</label>
                            <select name="sort" class="form-select">
                                <option value="newest" <?= isset($_GET['sort']) && $_GET['sort'] == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                                <option value="price_asc" <?= isset($_GET['sort']) && $_GET['sort'] == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                                <option value="price_desc" <?= isset($_GET['sort']) && $_GET['sort'] == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Featured discounted products -->
            <?php if (!empty($discountedProducts)): ?>
            <div class="mb-4">
                <h4 class="mb-3">Sản phẩm giảm giá</h4>
                <div class="row">
                    <?php foreach ($discountedProducts as $product): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($product['hinhanh']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['tensanpham']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['tensanpham']) ?></h5>
                                <p class="card-text">
                                    <span class="text-decoration-line-through text-muted"><?= number_format($product['gia'], 0, ',', '.') ?>đ</span>
                                    <span class="text-danger fw-bold"><?= number_format($product['gia'] - $product['giagiam'], 0, ',', '.') ?>đ</span>
                                </p>
                                <a href="index.php?controller=sanpham&action=detail&id=<?= $product['id'] ?>" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Product list -->
            <?php if (!empty($products)): ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($product['hinhanh']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['tensanpham']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['tensanpham']) ?></h5>
                            <p class="card-text">
                                <span class="text-decoration-line-through text-muted"><?= number_format($product['gia'], 0, ',', '.') ?>đ</span>
                                <span class="text-danger fw-bold"><?= number_format($product['gia'] - $product['giagiam'], 0, ',', '.') ?>đ</span>
                            </p>
                            <a href="index.php?controller=sanpham&action=detail&id=<?= $product['id'] ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div> 