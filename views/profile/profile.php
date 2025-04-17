<?php
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo '<script>window.location.href = "index.php?page=home";</script>';
    exit();
}
$comments = isset($GLOBALS['comments']) ? $GLOBALS['comments'] : [];
?>
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Thông tin cá nhân</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
        <li class="breadcrumb-item active text-white">Profile</li>
    </ol>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <?php 
                    // Check if user has an avatar in the database
                    if (isset($_SESSION['user']['hinhanh']) && !empty($_SESSION['user']['hinhanh'])) {
                        // Use the same path structure as in list.php
                        $avatarPath = "http://localhost/shopfood/admin/public/" . htmlspecialchars($_SESSION['user']['hinhanh']);
                    } else {
                        // Default avatar if user doesn't have one
                        $avatarPath = 'public/img/default-avatar.png';
                    }
                    ?>
                    <img src="<?php echo $avatarPath; ?>" 
                         alt="avatar" 
                         class="rounded-circle img-fluid" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                    <h5 class="my-3"><?php echo htmlspecialchars($_SESSION['user']['ten']); ?></h5>
                    <p class="text-muted mb-1"><?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                    <div class="d-flex justify-content-center mb-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeAvatarModal">
                            Thay đổi ảnh đại diện
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Details and Password Change -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Họ tên</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($_SESSION['user']['ten']); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Số điện thoại</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($_SESSION['user']['sodienthoai'] ?? 'Chưa cập nhật'); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Địa chỉ</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($_SESSION['user']['diachi'] ?? 'Chưa cập nhật'); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Giới tính</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($_SESSION['user']['gioitinh'] ?? 'Khác'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Change Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thay đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <form action="index.php?page=changePassword" method="POST">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Comment History -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Lịch sử bình luận</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th>Sản phẩm</th>
                                    <th>Nội dung</th>
                                    <th>Đánh giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($comments)): ?>
                                    <?php foreach ($comments as $comment): ?>
                                        <tr style="cursor: pointer;" onclick="window.location.href='index.php?page=detail&id=<?php echo $comment['id_sanpham']; ?>'">
                                            <td><?php echo date('d/m/Y H:i', strtotime($comment['ngaydang'])); ?></td>
                                            <td>
                                                <a href="index.php?page=detail&id=<?php echo $comment['id_sanpham']; ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($comment['tensanpham']); ?>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($comment['noidung']); ?></td>
                                            <td>
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star <?php echo $i <= $comment['danhgia'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                                <?php endfor; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Chưa có bình luận nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Avatar Modal -->
<div class="modal fade" id="changeAvatarModal" tabindex="-1" aria-labelledby="changeAvatarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeAvatarModalLabel">Thay đổi ảnh đại diện</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?page=changeAvatar" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Chọn ảnh (không bắt buộc)</label>
                        <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
                        <small class="text-muted">Chỉ chấp nhận file ảnh (JPEG, PNG, GIF)</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Tải lên</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    }
    .card-header {
        font-weight: 500;
    }
    .card-body {
        padding: 1.5rem;
    }
    .table th {
        font-weight: 600;
    }
</style> 