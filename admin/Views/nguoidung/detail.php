<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <style>
        /* Container cho thanh cuộn */
        .scroll-container {
            overflow-x: auto; /* Cho phép cuộn ngang */
            border: 1px solid #ddd; /* Viền cho container */
            padding: 10px; /* Khoảng cách cho container */
            margin-top: 20px; /* Khoảng cách trên */
            max-width: 100%; /* Đảm bảo chiều rộng tối đa */
        }

        /* Bảng */
        .data-table {
            width: 100%; /* Chiều rộng của bảng */
            min-width: 1200px; /* Đặt chiều rộng tối thiểu cho bảng để không bị thu nhỏ */
            border-collapse: collapse; /* Xóa khoảng cách giữa các ô */
        }

        /* Đường viền cho các ô */
        .data-table th, .data-table td {
            border: 1px solid #ddd; /* Đường viền cho các ô */
            padding: 8px; /* Khoảng cách trong các ô */
            text-align: left; /* Căn trái nội dung */
        }

        /* Nút */
        .btn {
            text-decoration: none; /* Bỏ gạch chân */
            padding: 5px 10px; /* Padding cho nút */
            color: white; /* Màu chữ */
            border-radius: 4px; /* Bo góc */
        }

        .btn-warning {
            background-color: orange; /* Màu nền nút sửa */
        }

        .btn-danger {
            background-color: red; /* Màu nền nút xóa */
        }

        .btn-warning:hover, .btn-danger:hover {
            opacity: 0.8; /* Hiệu ứng khi hover */
        }
    </style>
</head>
<body>
<main class="main-content">
    <div class="container-fluid">
        <!-- Thông báo thành công -->
        <?php if (isset($thongbao)): ?>
            <div class="alert alert-success" role="alert">
                <?= $thongbao; ?>
            </div>
        <?php endif; ?>

        <div class="card-title">
            <h3><i class="fas fa-box"></i> Danh sách sản phẩm</h3>
            <a href="index.php?act=addSanPham" class="btn btn-primary">
                <i class="fas fa-folder-plus"></i> Thêm mới
            </a>
        </div>
        
        <div class="scroll-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Hình ảnh 1</th>
                        <th>Hành động</th>
                        <th>Hình ảnh 2</th>
                        <th>Hình ảnh 3</th>
                        <th>Hình ảnh 4</th>
                        <th>Hình ảnh 5</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($danhSachSanPham as $list): ?>
                        <tr>
                            <td><?= htmlspecialchars($list['id']) ?></td>
                            <td><?= htmlspecialchars($list['tensanpham']) ?></td>
                            <td><?= htmlspecialchars($list['mota']) ?></td>
                            <td><?= number_format($list['gia'], 0, ',', '.') ?> đ</td>
                            <td><?= htmlspecialchars($list['soluong']) ?></td>
                            <td>
                                <img src="../upload/<?= htmlspecialchars($list['hinhanh1']) ?>" width="50" alt="Hình ảnh sản phẩm">
                            </td>
                            <td>
                                <a href="index.php?act=suaSanPham&id=<?= $list['id'] ?>" class="btn btn-warning">Sửa</a>
                                <a href="index.php?act=xoaSanPham&id=<?= $list['id'] ?>" class="btn btn-danger">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
