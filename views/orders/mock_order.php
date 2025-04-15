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
                <tr>
                    <td>#ORD123456</td>
                    <td><?= date('d/m/Y H:i:s') ?></td>
                    <td>44.97 VNĐ</td>
                    <td>Thanh toán khi nhận hàng (COD)</td>
                    <td>
                        <span class="badge bg-warning">Chờ xác nhận</span>
                    </td>
                    <td>
                        <a href="index.php?page=orderDetails&id=ORD123456" class="btn btn-primary btn-sm">
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div> 