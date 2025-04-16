<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết hóa đơn</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .order-detail {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .customer-info, .order-info {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding: 10px;
            background: #fff;
            border-radius: 4px;
        }
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #495057;
        }
        .info-value {
            flex: 1;
            color: #212529;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .table-card {
            margin-top: 20px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th, .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .data-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .btn {
            padding: 8px 16px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-shipping {
            background-color: #cce5ff;
            color: #004085;
        }
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="order-detail">
            <div class="page-title">
                <h2 class="title">Chi tiết hóa đơn #<?php echo htmlspecialchars($order['id']); ?></h2>
                <a href="index.php?act=chitiethoadon" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Cập nhật trạng thái đơn hàng thành công!
            </div>
            <?php endif; ?>

            <!-- Thông tin khách hàng -->
            <div class="customer-info">
                <h3><i class="fas fa-user"></i> Thông tin khách hàng</h3>
                <div class="info-row">
                    <div class="info-label">Họ tên:</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['ten_nguoidung']); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['email']); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Số điện thoại:</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['sodienthoai']); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Địa chỉ giao hàng:</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['diachigiaohang']); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Ghi chú:</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['ghichu']); ?></div>
                </div>
            </div>

            <!-- Thông tin đơn hàng -->
            <div class="order-info">
                <h3><i class="fas fa-shopping-cart"></i> Thông tin đơn hàng</h3>
                <div class="info-row">
                    <div class="info-label">Ngày đặt:</div>
                    <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($order['ngaytao'])); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phương thức thanh toán:</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['tenphuongthuc'] ?? 'Chưa cập nhật'); ?></div>
                </div>
                <div class="info-row">
                <div class="info-label">Trạng thái:</div>
                <div class="info-value">
                    <form action="index.php?act=detailchitiethoadon" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <select name="trangthai" onchange="this.form.submit()">
                            <?php
                                $statuses = ['Chờ xác nhận', 'Đang giao', 'Đã giao', 'Đã hủy'];
                                foreach ($statuses as $status) {
                                    $selected = ($order['trangthai'] === $status) ? 'selected' : '';
                                    echo "<option value='$status' $selected>$status</option>";
                                }
                            ?>
                        </select>
                    </form>
                </div>
            </div>

            </div>

            <!-- Chi tiết sản phẩm -->
            <div class="table-card">
                <div class="card-title">
                    <h3><i class="fas fa-box"></i> Sản phẩm trong đơn hàng</h3>
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
                        <?php 
                        $total = 0;
                        foreach ($orderItems as $item): 
                            $subtotal = $item['gia'] * $item['soluong'];
                            $total += $subtotal;
                        ?>
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
                                <td><?php echo number_format($subtotal, 0, ',', '.') . ' VNĐ'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td><strong><?php echo number_format($total, 0, ',', '.') . ' VNĐ'; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html> 