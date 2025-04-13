<?php
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Shop</li>
    </ol>
</div>
<div class="container mt-4">
    <h1 class="mb-4">Đơn hàng của tôi</h1>
    
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">
            Bạn chưa có đơn hàng nào.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['ngaytao']); ?></td>
                            <td><?php echo number_format($order['tongtien'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td><?php echo htmlspecialchars($order['phuongthucthanhtoan']); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $order['trangthai'] === 'Chờ xác nhận' ? 'warning' : 
                                        ($order['trangthai'] === 'Đã giao' ? 'success' : 
                                        ($order['trangthai'] === 'Đã hủy' ? 'danger' : 'info')); 
                                ?>">
                                    <?php echo htmlspecialchars($order['trangthai']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?page=orderDetails&id=<?php echo $order['id']; ?>" 
                                   class="btn btn-primary btn-sm">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div> 