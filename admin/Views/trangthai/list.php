<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trạng thái vận chuyển</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Trạng thái vận chuyển</h2>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert <?php echo $_GET['message'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $_GET['message'] === 'success' ? 'Cập nhật trạng thái thành công!' : 'Có lỗi xảy ra!'; ?>
            </div>
        <?php endif; ?>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-truck"></i> Danh sách đơn hàng</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày tạo</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($danhSachDonHang as $donHang): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($donHang['id']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($donHang['ngaytao'])); ?></td>
                            <td><?php echo htmlspecialchars($donHang['ten_nguoidung']); ?></td>
                            <td><?php echo number_format($donHang['tongtien'], 0, ',', '.'); ?>đ</td>
                            <td>
                                <form method="POST" action="index.php?act=capnhattrangthai" class="status-form">
                                    <input type="hidden" name="id_hoadon" value="<?php echo $donHang['id']; ?>">
                                    <select name="trangthai" onchange="this.form.submit()" class="status-select <?php echo strtolower($donHang['trangthai']); ?>">
                                        <option value="Chờ xác nhận" <?php echo $donHang['trangthai'] === 'Chờ xác nhận' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                        <option value="Đang giao" <?php echo $donHang['trangthai'] === 'Đang giao' ? 'selected' : ''; ?>>Đang giao</option>
                                        <option value="Đã giao" <?php echo $donHang['trangthai'] === 'Đã giao' ? 'selected' : ''; ?>>Đã giao</option>
                                        <option value="Đã hủy" <?php echo $donHang['trangthai'] === 'Đã hủy' ? 'selected' : ''; ?>>Đã hủy</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="index.php?act=chitietdonhang&id=<?php echo $donHang['id']; ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <style>
        .status-select {
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .status-select.chờ-xác-nhận {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-select.đang-giao {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-select.đã-giao {
            background-color: #d4edda;
            color: #155724;
        }

        .status-select.đã-hủy {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-form {
            margin: 0;
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

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</body>
</html> 