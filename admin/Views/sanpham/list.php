<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <style>
        .search-box {
            display: flex;
            gap: 10px;
            background: #f8f9fa;
            padding: 12px;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            /* Thu nhỏ kích thước */
            margin-left: auto;
            margin: 10px;
            /* Đẩy sang bên phải */
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
            <!-- Thông báo thành công -->
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
            <form action="index.php" method="get" enctype="multipart/form-data">
                <input type="hidden" name="act" value="sanpham">
                <div class="search-box">

                    <input type="text" name="kyw" value="<?= $_GET['kyw'] ?? '' ?>" placeholder="Tìm Kiếm Tên Sản Phẩm ..." class="search-input">
                    <select name="iddm" class="search-select">
                        <option value="0">Tất cả</option>
                        <?php foreach ($dsDanhmuc as $dm): ?>
                            <option value="<?= $dm['id'] ?>" <?= ($_GET['iddm'] ?? 0) == $dm['id'] ? 'selected' : '' ?>>
                                <?= $dm['tendanhmuc'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" name="listok" value="OK" class="search-button">
                </div>

            </form>
            <div class="card-title">
                <h3><i class="fas fa-box"></i> Danh sách sản phẩm</h3>
                <a href="index.php?act=addSanPham" class="btn btn-primary">
                    <i class="fas fa-folder-plus"></i> Thêm mới
                </a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Hình ảnh 1</th>
                        <th scope="col">Hình ảnh 2</th>
                        <th scope="col">Hình ảnh 3</th>
                        <th scope="col">Thời gian tạo</th>
                        <th scope="col">Danh Mục</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">hoạt động</th>

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

                            <?php
                            $adress_hinh1 = "../upload/" . $list['hinhanh1'];
                            $adress_hinh2 = "../upload/" . $list['hinhanh2'];
                            $adress_hinh3 = "../upload/" . $list['hinhanh3'];

                            if (is_file($adress_hinh1)) {
                                $list['hinhanh1'] = '<img src="' . $adress_hinh1 . '" width=58" />';
                            } else {
                                $list['hinhanh1'] = "No image!";
                            }
                            if (is_file($adress_hinh2)) {
                                $list['hinhanh2'] = '<img src="' . $adress_hinh2 . '" width=58" />';
                            } else {
                                $list['hinhanh2'] = "No image!";
                            }
                            if (is_file($adress_hinh3)) {
                                $list['hinhanh3'] = '<img src="' . $adress_hinh3 . '" width=58" />';
                            } else {
                                $list['hinhanh3'] = "No image!";
                            }
                            ?>
                            <td><?= $list['hinhanh1'] ?></td>
                            <td><?= $list['hinhanh2'] ?></td>
                            <td><?= $list['hinhanh3'] ?></td>
                            <td><?= date("d-m-Y", strtotime($list['thoigiantao'])) ?></td>
                            <td><?= $list['tendanhmuc'] ?></td>
                            <td>
                                <?= ($list['trangthai'] == 'Còn hàng') ? '<span style="color: green;">Còn hàng</span>' : '<span style="color: red;">Hết hàng</span>' ?>
                            </td>
                            <td>
                                <a href="index.php?act=suaSanPham&id=<?= $list['id'] ?>" class="btn btn-warning">Sửa</a>
                                <a href="index.php?act=xoaSP&id=<?= $list['id'] ?>" class="btn btn-danger">Xóa</a>
                            </td>
                        </tr> 
                    <?php endforeach; ?>
                </tbody>

            </table>
            <center>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $soTrang; $i++): ?>
                        <a
                            href="index.php?act=sanpham&kyw=<?= urlencode($kyw) ?>&iddm=<?= $iddm ?>&page=<?= $i ?>" class="btn btn-light"
                            class="<?= ($i == $page) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>

            </center>
        </div>
        </div>
    </main>
</body>
</html>
