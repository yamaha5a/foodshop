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
    <h1 class="text-center text-white display-6">Chi tiết đơn hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=orders">Đơn hàng</a></li>
        <li class="breadcrumb-item active text-white">Chi tiết đơn hàng</li>
    </ol>
</div>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Chi tiết đơn hàng #<?php echo htmlspecialchars($order['id']); ?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orderItems)): ?>
                                    <?php foreach ($orderItems as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="upload/<?php echo htmlspecialchars($item['hinhanh1']); ?>" 
                                                         alt="<?php echo htmlspecialchars($item['tensanpham']); ?>"
                                                         class="img-thumbnail" style="width: 50px; height: 50px;">
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
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Không có sản phẩm nào trong đơn hàng</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Thông tin đơn hàng</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Trạng thái:</strong>
                        <span class="badge bg-<?php 
                            echo $order['trangthai'] === 'Chờ xác nhận' ? 'warning' : 
                                ($order['trangthai'] === 'Đã giao' ? 'success' : 
                                ($order['trangthai'] === 'Đã hủy' ? 'danger' : 'info')); 
                        ?>">
                            <?php echo htmlspecialchars($order['trangthai']); ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Ngày đặt:</strong>
                        <?php echo htmlspecialchars($order['ngaytao']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Phương thức thanh toán:</strong>
                        <?php echo htmlspecialchars($order['tenphuongthuc']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Địa chỉ giao hàng:</strong>
                        <?php echo htmlspecialchars($order['diachigiaohang']); ?>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong>Tổng tiền:</strong>
                        <?php echo number_format($order['tongtien'], 0, ',', '.') . ' VNĐ'; ?>
                    </div>
                    <?php if (!empty($order['ghichu'])): ?>
                    <div class="mb-3">
                        <strong>Ghi chú:</strong>
                        <?php echo htmlspecialchars($order['ghichu']); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($order['trangthai'] === 'Chờ xác nhận'): ?>
                    <div class="mt-4">
                        <form action="index.php?page=cancelOrder" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-times-circle me-2"></i>Hủy đơn hàng
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 