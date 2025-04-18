<?php
// Kiểm tra quyền truy cập
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: /admin/login');
    exit;
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Quản lý người dùng</h1>

    <!-- Form tìm kiếm -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tìm kiếm người dùng</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <input type="hidden" name="page" value="nguoidung">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" placeholder="Nhập tên hoặc email..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách người dùng -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($danhSachNguoiDung as $nguoiDung): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($nguoiDung['id']); ?></td>
                            <td><?php echo htmlspecialchars($nguoiDung['hoten']); ?></td>
                            <td><?php echo htmlspecialchars($nguoiDung['email']); ?></td>
                            <td><?php echo htmlspecialchars($nguoiDung['ngaytao']); ?></td>
                            <td>
                                <a href="?page=nguoidung&action=sua&id=<?php echo $nguoiDung['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="?page=nguoidung&action=xoa&id=<?php echo $nguoiDung['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <?php if ($tongSoTrang > 1): ?>
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($trangHienTai > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=nguoidung&trang=<?php echo $trangHienTai - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $tongSoTrang; $i++): ?>
                        <li class="page-item <?php echo $i == $trangHienTai ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=nguoidung&trang=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>

                        <?php if ($trangHienTai < $tongSoTrang): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=nguoidung&trang=<?php echo $trangHienTai + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div> 