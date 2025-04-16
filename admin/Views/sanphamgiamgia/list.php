<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm giảm giá</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .search-box {
            display: flex;
            gap: 10px;
            background: #f8f9fa;
            padding: 12px;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 10px;
        }

        .search-input,
        .search-select {
            padding: 1px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            flex: 1;
        }

        .search-button {
            background: #007bff;
            color: white;
            padding: 7px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .search-button:hover {
            background: #0056b3;
        }

        @media (max-width: 200px) {
            .search-box {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="container-fluid">
            <!-- Thông báo -->
            <?php if (isset($_SESSION['thongbao'])): ?>
                <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px;">
                    <?= $_SESSION['thongbao'] ?>
                </div>
                <?php unset($_SESSION['thongbao']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['thongbaoxoa'])): ?>
                <div style="padding: 10px; background-color: #d4edda; color: red; border-radius: 5px; margin-bottom: 15px;">
                    <?= $_SESSION['thongbaoxoa'] ?>
                </div>
                <?php unset($_SESSION['thongbaoxoa']); ?>
            <?php endif; ?>

            <div class="card-title">
                <h3><i class="fas fa-tags"></i> Danh sách sản phẩm giảm giá</h3>
                <a href="index.php?act=addSanPhamGiamGia" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá gốc</th>
                        <th scope="col">Giá giảm</th>
                        <th scope="col">Ngày giảm giá</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($danhSachGiamGia)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Không có sản phẩm giảm giá nào</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($danhSachGiamGia as $giamgia): ?>
                            <tr>
                                <td><?= htmlspecialchars($giamgia['id']) ?></td>
                                <td><?= htmlspecialchars($giamgia['tensanpham']) ?></td>
                                <td><?= number_format($giamgia['gia_goc'], 0, ',', '.') ?> đ</td>
                                <td><?= number_format($giamgia['giagiam'], 0, ',', '.') ?> đ</td>
                                <td><?= date("d-m-Y", strtotime($giamgia['ngay_giamgia'])) ?></td>
                                <td>
                                    <a href="index.php?act=suaSanPhamGiamGia&id=<?= $giamgia['id'] ?>" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="index.php?act=xoaSanPhamGiamGia&id=<?= $giamgia['id'] ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm giảm giá này?');">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Phân trang -->
            <?php if ($soTrang > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $soTrang; $i++): ?>
                        <a href="index.php?act=sanphamgiamgia&page=<?= $i ?>" 
                           class="btn btn-light <?= ($i == $page) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html> 