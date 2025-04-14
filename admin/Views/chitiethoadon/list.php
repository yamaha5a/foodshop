<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách hóa đơn</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Danh sách hóa đơn</h2>
        </div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-file-invoice"></i> Danh sách hóa đơn</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['ten_nguoidung']); ?></td>
                            <td><?php echo htmlspecialchars($order['ngaytao']); ?></td>
                            <td><?php echo number_format($order['tongtien'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td><?php echo htmlspecialchars($order['tenphuongthuc']); ?></td>
                            <td>
                                <span class="status <?php 
                                    echo $order['trangthai'] === 'Chờ xác nhận' ? 'pending' : 
                                        ($order['trangthai'] === 'Đã giao' ? 'completed' : 
                                        ($order['trangthai'] === 'Đã hủy' ? 'cancelled' : 'processing')); 
                                ?>">
                                    <i class="fas <?php 
                                        echo $order['trangthai'] === 'Chờ xác nhận' ? 'fa-clock' : 
                                            ($order['trangthai'] === 'Đã giao' ? 'fa-check-circle' : 
                                            ($order['trangthai'] === 'Đã hủy' ? 'fa-times-circle' : 'fa-truck')); 
                                    ?>"></i>
                                    <?php echo htmlspecialchars($order['trangthai']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?act=detailchitiethoadon&id=<?php echo $order['id']; ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html> 