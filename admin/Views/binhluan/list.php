<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bình luận</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Quản lý bình luận</h2>
        </div>

        <form action="index.php" method="get" enctype="multipart/form-data">
            <input type="hidden" name="act" value="binhluan">
            <div class="search-box">
                <input type="text" name="kyw" value="<?= $_GET['kyw'] ?? '' ?>" placeholder="Tìm kiếm theo tên người dùng, sản phẩm hoặc nội dung..." class="search-input">
                <input type="submit" name="listok" value="Tìm kiếm" class="search-button">
            </div>
        </form>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-comments"></i> Danh sách bình luận</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Sản phẩm</th>
                        <th>Nội dung</th>
                        <th>Đánh giá</th>
                        <th>Ngày đăng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td><?= htmlspecialchars($comment['id']) ?></td>
                            <td><?= htmlspecialchars($comment['ten_nguoidung']) ?></td>
                            <td><?= htmlspecialchars($comment['tensanpham']) ?></td>
                            <td><?= htmlspecialchars($comment['noidung']) ?></td>
                            <td>
                                <?php 
                                $rating = isset($comment['danhgia']) ? (int)$comment['danhgia'] : 0;
                                for ($i = 1; $i <= 5; $i++): 
                                ?>
                                    <i class="fas fa-star" style="color: <?= $i <= $rating ? '#ffc107' : '#6c757d' ?>"></i>
                                <?php endfor; ?>
                                <span class="ms-2">(<?= $rating ?>/5)</span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($comment['ngaydang'])) ?></td>
                            <td>
                                <a href="index.php?act=detailbinhluan&id=<?= $comment['id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                                <a href="index.php?act=deletebinhluan&id=<?= $comment['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Phân trang -->
            <?php if ($soTrang > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $soTrang; $i++): ?>
                        <a href="index.php?act=binhluan&kyw=<?= urlencode($kyw) ?>&page=<?= $i ?>" 
                           class="btn btn-light <?= ($i == $page) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <style>
        .search-box {
            display: flex;
            gap: 10px;
            background: #f8f9fa;
            padding: 12px;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
        }

        .search-input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-button {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .search-button:hover {
            background: #0056b3;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination .btn-light {
            padding: 5px 10px;
            border: 1px solid #ddd;
        }

        .pagination .btn-light.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
    </style>
</body>
</html> 