<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật người dùng</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Cập nhật người dùng</h2>
            <a href="index.php?act=nguoidung" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-edit"></i> Sửa thông tin người dùng</h3>
            </div>
            <form action="index.php?act=updateNguoiDung" method="POST" enctype="multipart/form-data" class="data-table">
                <input type="hidden" name="id" value="<?php echo $nguoiDung['id']; ?>">
                
                <div class="form-group">
                    <label for="ten">Tên:</label>
                    <input type="text" id="ten" name="ten" value="<?php echo htmlspecialchars($nguoiDung['ten']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($nguoiDung['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="sdt">Số điện thoại:</label>
                    <input type="text" id="sdt" name="sdt" value="<?php echo htmlspecialchars($nguoiDung['sdt']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="hinhanh">Hình ảnh:</label>
                    <input type="file" id="hinhanh" name="hinhanh" accept="image/*">
                    <br>
                    <img src="http://localhost/shopfood/admin/public/<?php echo htmlspecialchars($nguoiDung['hinhanh']); ?>" class="avatar" alt="Ảnh người dùng">
                </div>
                
                <div class="form-group">
                    <label for="id_phanquyen">Quyền:</label>
                    <select id="id_phanquyen" name="id_phanquyen" required>
                        <option value="1" <?php echo ($nguoiDung['id_phanquyen'] == 1) ? 'selected' : ''; ?>>Admin</option>
                        <option value="2" <?php echo ($nguoiDung['id_phanquyen'] == 2) ? 'selected' : ''; ?>>Người dùng</option>
                        <option value="3" <?php echo ($nguoiDung['id_phanquyen'] == 3) ? 'selected' : ''; ?>>Nhân viên</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="trangthai">Trạng thái:</label>
                    <select id="trangthai" name="trangthai" required>
                        <option value="Hoạt động" <?php echo ($nguoiDung['trangthai'] == 'Hoạt động') ? 'selected' : ''; ?>>Hoạt động</option>
                        <option value="Không hoạt động" <?php echo ($nguoiDung['trangthai'] == 'Không hoạt động') ? 'selected' : ''; ?>>Không hoạt động</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
            </form>
        </div>
    </main>
</body>
</html>
