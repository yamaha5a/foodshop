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
                                <?php foreach ($orderItems as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                     class="img-thumbnail" style="width: 50px; height: 50px;">
                                                <div class="ms-3">
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo number_format($item['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.') . ' VNĐ'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
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
                            echo $order['status'] === 'pending' ? 'warning' : 
                                ($order['status'] === 'completed' ? 'success' : 'danger'); 
                        ?>">
                            <?php 
                            echo $order['status'] === 'pending' ? 'Đang xử lý' : 
                                ($order['status'] === 'completed' ? 'Hoàn thành' : 'Đã hủy'); 
                            ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Ngày đặt:</strong>
                        <?php echo htmlspecialchars($order['created_at']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Phương thức thanh toán:</strong>
                        <?php echo htmlspecialchars($order['payment_method']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Địa chỉ giao hàng:</strong>
                        <?php echo htmlspecialchars($order['shipping_address']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Số điện thoại:</strong>
                        <?php echo htmlspecialchars($order['phone']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong>
                        <?php echo htmlspecialchars($order['email']); ?>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong>Tổng tiền hàng:</strong>
                        <?php echo number_format($order['subtotal'], 0, ',', '.') . ' VNĐ'; ?>
                    </div>
                    <div class="mb-3">
                        <strong>Phí vận chuyển:</strong>
                        <?php echo number_format($order['shipping_fee'], 0, ',', '.') . ' VNĐ'; ?>
                    </div>
                    <div class="mb-3">
                        <strong>Tổng cộng:</strong>
                        <?php echo number_format($order['total'], 0, ',', '.') . ' VNĐ'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 