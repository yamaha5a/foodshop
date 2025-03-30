<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng</title>
    <link rel="stylesheet" href="css.css"> <!-- Sử dụng file CSS từ dự án -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Thêm người dùng</h2>
            <a href="index.php?act=nguoidung" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>

        <!-- Form thêm người dùng -->
        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-user-plus"></i> Nhập thông tin người dùng</h3>
            </div>
            <form action="index.php?act=addnguoidung" method="POST" enctype="multipart/form-data" class="data-table">
                <div class="form-group">
                    <label for="ten">Tên:</label>
                    <input type="text" id="ten" name="ten" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="matkhau">Mật khẩu:</label>
                    <input type="password" id="matkhau" name="matkhau" required>
                </div>
                <div class="form-group">
                    <label for="hinhanh">Hình ảnh:</label>
                    <input type="file" id="hinhanh" name="hinhanh" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="id_phanquyen">Quyền:</label>
                    <select id="id_phanquyen" name="id_phanquyen" required>
                        <option value="">Chọn quyền</option>
                        <option value="1">Admin</option>
                        <option value="2">Người dùng</option>
                        <option value="3">Nhân viên</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Thêm người dùng</button>
            </form>
        </div>
    </main>
</body>
</html>
