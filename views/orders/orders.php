<?php
// Debug: Kiểm tra dữ liệu đơn hàng
error_log("Orders in view: " . print_r($orders, true));

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
    <h1 class="text-center text-white display-6">Đơn hàng của tôi</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="index.php?page=home">Trang chủ</a></li>
        <li class="breadcrumb-item active text-white">Đơn hàng</li>
    </ol>
</div>
<div class="container-fluid py-5">
    <div class="container py-5">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (empty($orders)): ?>
            <div class="text-center">
                <h2 class="mb-4">Bạn chưa có đơn hàng nào</h2>
                <p class="mb-4">Hãy tiếp tục mua sắm và tạo đơn hàng mới</p>
                <a href="index.php?page=product" class="btn btn-primary">Tiếp tục mua sắm</a>
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
                        <?php 
                        $firstOrder = true; // Flag to identify the newest order
                        foreach ($orders as $order): 
                        ?>
                            <tr class="<?php echo $firstOrder ? 'table-success' : ''; ?>">
                                <td>
                                    #<?php echo $order['id']; ?>
                                    <?php if ($firstOrder): ?>
                                        <span class="fire-badge">Mới Nhất</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['ngaytao'])); ?></td>
                                <td><?php echo number_format($order['tongtien'], 0, ',', '.') . ' VNĐ'; ?></td>
                                <td><?php echo htmlspecialchars($order['tenphuongthuc']); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $order['trangthai'] === 'Chờ xác nhận' ? 'warning' : 
                                            ($order['trangthai'] === 'Đang xử lý' ? 'info' :
                                            ($order['trangthai'] === 'Đang vận chuyển' ? 'primary' :
                                            ($order['trangthai'] === 'Đã giao hàng' ? 'success' :
                                            ($order['trangthai'] === 'Đã hủy' ? 'danger' : 'secondary')))); 
                                    ?>">
                                        <?php echo $order['trangthai']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?page=orderDetails&id=<?php echo $order['id']; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        <?php 
                        $firstOrder = false; // Reset flag after first order
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.table-success {
    background-color: #d4edda !important;
    position: relative;
}

.fire-badge {
    display: inline-block;
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    background: linear-gradient(45deg, #ff0000, #ff8c00, #ffd700);
    background-size: 200% 200%;
    animation: gradient 2s ease infinite;
    margin-left: 5px;
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.fire-badge::after {
    content: '🔥';
    margin-left: 3px;
    display: inline-block;
    animation: fire 1s infinite;
}

@keyframes fire {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newOrderRow = document.querySelector('tr.table-success');
    if (newOrderRow) {
        // Scroll to the new order
        newOrderRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script> 