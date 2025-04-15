<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết topping</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Chi tiết topping</h2>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <h3>Thông tin topping</h3>
                <div class="action-buttons">
                    <a href="index.php?act=edittopping&id=<?= $topping['id'] ?>" class="btn btn-info">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="index.php?act=topping" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="detail-content">
                <div class="detail-item">
                    <label>ID:</label>
                    <span><?= htmlspecialchars($topping['id']) ?></span>
                </div>
                <div class="detail-item">
                    <label>Tên topping:</label>
                    <span><?= htmlspecialchars($topping['tentopping']) ?></span>
                </div>
                <div class="detail-item">
                    <label>Giá:</label>
                    <span>$<?= number_format($topping['gia'], 2) ?></span>
                </div>
            </div>

            <div class="related-products">
                <h4>Sản phẩm sử dụng topping này</h4>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID Sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá topping</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($relatedProducts as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id_sanpham']) ?></td>
                                <td><?= htmlspecialchars($product['tensanpham']) ?></td>
                                <td>$<?= number_format($product['gia_topping'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html> 