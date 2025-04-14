<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết hóa đơn</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Chi tiết hóa đơn #<?php echo htmlspecialchars($order['id']); ?></h2>
            <a href="index.php?act=chitiethoadon" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-shopping-cart"></i> Sản phẩm trong đơn hàng</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="http://localhost/shopfood/upload/<?php echo htmlspecialchars($item['hinhanh1']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['tensanpham']); ?>"
                                         class="product-image">
                                    <div class="ms-3">
                                        <?php echo htmlspecialchars($item['tensanpham']); ?>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo number_format($item['gia'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td><?php echo htmlspecialchars($item['soluong']); ?></td>
                            <td><?php echo number_format($item['gia'] * $item['soluong'], 0, ',', '.') . ' VNĐ'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <style>
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</body>
</html> 