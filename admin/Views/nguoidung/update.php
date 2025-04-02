<?php if (isset($nguoiDung)): ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Người Dùng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Cập Nhật Người Dùng</h2>
    
    <!-- Thông báo lỗi nếu có -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-warning">
            <?= htmlspecialchars($_GET['msg']) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?act=capnhatnguoidung" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= htmlspecialchars($nguoiDung['id']) ?>">

        <div class="form-group">
            <label for="ten">Tên:</label>
            <input type="text" class="form-control" id="ten" name="ten" value="<?= htmlspecialchars($nguoiDung['ten']) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($nguoiDung['email']) ?>" required>
        </div>

        <div class="form-group">
            <label for="sodienthoai">Số Điện Thoại:</label>
            <input type="text" class="form-control" id="sodienthoai" name="sodienthoai" value="<?= htmlspecialchars($nguoiDung['sodienthoai']) ?>" required pattern="\d{10,15}" title="Số điện thoại phải từ 10 đến 15 chữ số">
        </div>

        <div class="form-group">
            <label for="id_phanquyen">Quyền:</label>
            <select class="form-control" id="id_phanquyen" name="id_phanquyen" required>
                <option value="1" <?= $nguoiDung['id_phanquyen'] == 1 ? 'selected' : '' ?>>Admin</option>
                <option value="2" <?= $nguoiDung['id_phanquyen'] == 2 ? 'selected' : '' ?>>Người Dùng</option>
            </select>
        </div>

        <div class="form-group">
            <label for="trangthai">Trạng Thái:</label>
            <select class="form-control" id="trangthai" name="trangthai" required>
                <option value="1" <?= $nguoiDung['trangthai'] == 1 ? 'selected' : '' ?>>Kích hoạt</option>
                <option value="0" <?= $nguoiDung['trangthai'] == 0 ? 'selected' : '' ?>>Khóa</option>
            </select>
        </div>

        <div class="form-group">
            <label for="hinhanh">Hình Ảnh:</label>
            <input type="file" class="form-control-file" id="hinhanh" name="hinhanh">
            <small class="form-text text-muted">Hình ảnh hiện tại:</small>
            <img src="<?= htmlspecialchars($nguoiDung['hinhanh']) ?>" alt="Hình ảnh người dùng" class="img-thumbnail" width="150">
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php?act=nguoidung" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php else: ?>
    <p>Không tìm thấy thông tin người dùng.</p>
<?php endif; ?>
