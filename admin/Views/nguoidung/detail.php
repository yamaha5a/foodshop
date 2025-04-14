<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết người dùng</title>
    <style>
        .user-detail {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .user-info {
            margin-bottom: 20px;
        }
        .user-info h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #495057;
        }
        .info-value {
            flex: 1;
            color: #212529;
        }
        .user-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            cursor: pointer;
        }
        .action-buttons {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            padding: 8px 16px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
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

        <div class="user-detail">
            <div class="user-info">
                <h2>Thông tin chi tiết người dùng</h2>
                
                <?php 
                $hinhanh = htmlspecialchars($nguoiDung['hinhanh']);
                $linkHinh = "http://localhost/shopfood/admin/public/" . $hinhanh;
                ?>
                <img src="<?php echo $linkHinh; ?>" 
                     alt="Ảnh đại diện" 
                     class="user-avatar"
                     onclick="openModal('<?php echo $linkHinh; ?>')"
                     onerror="this.src='http://localhost/shopfood/admin/public/img/nguoidung/default-avatar.png'">

                <div class="info-row">
                    <div class="info-label">ID:</div>
                    <div class="info-value"><?= htmlspecialchars($nguoiDung['id']) ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Họ tên:</div>
                    <div class="info-value"><?= htmlspecialchars($nguoiDung['ten']) ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?= htmlspecialchars($nguoiDung['email']) ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Số điện thoại:</div>
                    <div class="info-value"><?= htmlspecialchars($nguoiDung['sodienthoai'] ?? 'Chưa cập nhật') ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Địa chỉ:</div>
                    <div class="info-value"><?= htmlspecialchars($nguoiDung['diachi'] ?? 'Chưa cập nhật') ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Giới tính:</div>
                    <div class="info-value"><?= htmlspecialchars($nguoiDung['gioitinh'] ?? 'Khác') ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Trạng thái:</div>
                    <div class="info-value"><?= htmlspecialchars($nguoiDung['trangthai']) ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Quyền hạn:</div>
                    <div class="info-value">
                        <?php 
                        $tenQuyen = $this->layTenQuyen($nguoiDung['id_phanquyen']);
                        echo htmlspecialchars($tenQuyen);
                        ?>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="index.php?act=capnhatNguoiDung&id=<?= $nguoiDung['id'] ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Cập nhật
                </a>
                <a href="index.php?act=nguoidung" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</main>

<script>
function openModal(imageSrc) {
    window.open(imageSrc, '_blank');
}
</script>
</body>
</html>
