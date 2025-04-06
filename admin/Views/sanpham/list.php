<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <style>
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
                    <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Hình ảnh 1</th>
                        
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
