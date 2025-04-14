<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bình luận</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Chi tiết bình luận</h2>
            <a href="index.php?act=binhluan" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="detail-card">
            <div class="card-body">
                <div class="detail-row">
                    <label>ID bình luận:</label>
                    <span><?= htmlspecialchars($comment['id']) ?></span>
                </div>
                <div class="detail-row">
                    <label>Người dùng:</label>
                    <span><?= htmlspecialchars($comment['ten_nguoidung']) ?></span>
                </div>
                <div class="detail-row">
                    <label>Sản phẩm:</label>
                    <span><?= htmlspecialchars($comment['tensanpham']) ?></span>
                </div>
                <div class="detail-row">
                    <label>Nội dung:</label>
                    <p class="comment-content"><?= htmlspecialchars($comment['noidung']) ?></p>
                </div>
                <div class="detail-row">
                    <label>Đánh giá:</label>
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= $comment['danhgia'] ? 'text-warning' : 'text-muted' ?>"></i>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="detail-row">
                    <label>Ngày đăng:</label>
                    <span><?= date('d/m/Y H:i', strtotime($comment['ngaydang'])) ?></span>
                </div>
            </div>
            <div class="card-footer">
                <a href="index.php?act=deletebinhluan&id=<?= $comment['id'] ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                    <i class="fas fa-trash"></i> Xóa bình luận
                </a>
            </div>
        </div>
    </main>
</body>
</html> 