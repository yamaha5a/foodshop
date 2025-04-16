<?php
// Display success message from checkout process
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thành công!</strong> ' . $_SESSION['success'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['success']);
}

// Display error message if any
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi!</strong> ' . $_SESSION['error'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['error']);
}

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
                        <tr class="<?php echo (isset($_SESSION['order_id']) && $_SESSION['order_id'] == $order['id']) ? 'table-success fw-bold' : ''; ?>">
                            <td>
                                #<?php echo htmlspecialchars($order['id']); ?>
                                <?php if (isset($_SESSION['order_id']) && $_SESSION['order_id'] == $order['id']): ?>
                                    <span class="badge bg-success ms-2">Mới</span>
                                <?php endif; ?>
                            </td>
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

<?php if (isset($_SESSION['order_id'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find the newly placed order row
        const newOrderRow = document.querySelector('tr.table-success');
        if (newOrderRow) {
            // Scroll to the new order
            newOrderRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Add a subtle highlight effect
            newOrderRow.style.transition = 'background-color 0.5s';
            newOrderRow.style.backgroundColor = '#d4edda';
            setTimeout(function() {
                newOrderRow.style.backgroundColor = '';
            }, 2000);
        }
    });
</script>
<?php endif; ?> 