<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết liên hệ</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .title {
            font-size: 24px;
            color: #333;
            margin: 0;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        .card-header h3 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        .card-body {
            padding: 20px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
        }
        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 15px;
        }
        .message-content {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            border-left: 4px solid #4e73df;
            margin-top: 10px;
            line-height: 1.6;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #4e73df;
            outline: none;
            box-shadow: 0 0 0 3px rgba(78,115,223,0.1);
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }
        .btn-primary {
            background: #4e73df;
            color: white;
        }
        .btn-primary:hover {
            background: #2e59d9;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
        .bg-warning {
            background: #f6c23e;
            color: #fff;
        }
        .bg-success {
            background: #1cc88a;
            color: #fff;
        }
        .mt-3 {
            margin-top: 15px;
        }
        .mt-4 {
            margin-top: 20px;
        }
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .contact-info p {
            margin: 0;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .contact-info p:hover {
            background: #f0f0f0;
        }
        .contact-info strong {
            display: inline-block;
            width: 120px;
            color: #555;
        }
        .response-form {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
        }
        .response-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .response-header i {
            font-size: 20px;
            margin-right: 10px;
            color: #4e73df;
        }
        .response-header h3 {
            margin: 0;
            color: #333;
        }
        .response-content {
            margin-top: 15px;
            padding: 15px;
            background: #fff;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        .response-content textarea {
            min-height: 150px;
        }
        .response-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .response-actions .btn {
            margin-left: 10px;
        }
        .message-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .message-header i {
            font-size: 20px;
            margin-right: 10px;
            color: #4e73df;
        }
        .message-header h4 {
            margin: 0;
            color: #333;
        }
        .message-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #777;
            font-size: 14px;
        }
        .message-meta span {
            display: flex;
            align-items: center;
        }
        .message-meta i {
            margin-right: 5px;
        }
        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title"><i class="fas fa-envelope-open-text"></i> Chi tiết liên hệ</h2>
            <a href="index.php?act=lienhe" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Thông tin liên hệ</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-info">
                            <p><strong>ID:</strong> <?= htmlspecialchars($contact['id']) ?></p>
                            <p><strong>Người gửi:</strong> <?= htmlspecialchars($contact['ten_nguoidung']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($contact['email']) ?></p>
                            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($contact['sodienthoai'] ?? 'Không có') ?></p>
                            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($contact['diachi'] ?? 'Không có') ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info">
                            <p><strong>Tiêu đề:</strong> <?= htmlspecialchars($contact['tieude']) ?></p>
                            <p><strong>Ngày gửi:</strong> <?= date('d/m/Y H:i', strtotime($contact['ngaygui'])) ?></p>
                            <p><strong>Trạng thái:</strong> 
                                <?php if (empty($contact['traloi'])): ?>
                                    <span class="badge bg-warning">Chưa phản hồi</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Đã phản hồi</span>
                                    <br>
                                    <small>Ngày trả lời: <?= date('d/m/Y H:i', strtotime($contact['ngaytraloi'])) ?></small>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-comment-alt"></i> Nội dung liên hệ</h3>
            </div>
            <div class="card-body">
                <div class="message-meta">
                    <span><i class="fas fa-user"></i> <?= htmlspecialchars($contact['ten_nguoidung']) ?></span>
                    <span><i class="fas fa-clock"></i> <?= date('d/m/Y H:i', strtotime($contact['ngaygui'])) ?></span>
                </div>
                <div class="message-content">
                    <?= nl2br(htmlspecialchars($contact['noidung'])) ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-reply"></i> Phản hồi</h3>
            </div>
            <div class="card-body">
                <form action="index.php?act=updateLienHe" method="post">
                    <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                    <div class="response-form">
                        <div class="response-header">
                            <i class="fas fa-pen"></i>
                            <h3>Nội dung phản hồi</h3>
                        </div>
                        <div class="response-content">
                            <textarea name="phanhoi" id="phanhoi" class="form-control" rows="5" required placeholder="Nhập nội dung phản hồi..."><?= htmlspecialchars($contact['traloi'] ?? '') ?></textarea>
                        </div>
                        <div class="response-actions">
                            <a href="index.php?act=lienhe" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Gửi phản hồi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Thêm hiệu ứng khi trang tải
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        });
    </script>
</body>
</html> 