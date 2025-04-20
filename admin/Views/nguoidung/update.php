<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật người dùng</title>
    <style>
        .user-update {
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
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-label {
            display: block;
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
        }
        .form-control:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .action-buttons {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .form-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
            background-color: #fff;
        }
        .form-select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .file-upload-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .file-upload-btn:hover {
            background-color: #5a6268;
        }
        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        .file-name {
            margin-top: 5px;
            font-size: 14px;
            color: #6c757d;
        }
        .image-preview {
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<main class="main-content">
    <div class="container-fluid">
        <div class="user-update">
            <div class="user-info">
                <h2>Cập nhật người dùng</h2>
                
                <?php if (isset($_SESSION['thongbao'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php 
                            echo $_SESSION['thongbao']; 
                            unset($_SESSION['thongbao']);
                        ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $nguoiDung['id'] ?>">
                    
                    <?php 
                    $hinhanh = htmlspecialchars($nguoiDung['hinhanh']);
                    $linkHinh = "http://localhost/shopfood/admin/public/" . $hinhanh;
                    ?>
                    <img src="<?php echo $linkHinh; ?>" 
                         alt="Ảnh đại diện" 
                         class="user-avatar"
                         onclick="openModal('<?php echo $linkHinh; ?>')"
                         onerror="this.src='http://localhost/shopfood/admin/public/img/nguoidung/default-avatar.png'">

                    <div class="form-group">
                        <label for="ten" class="form-label">Họ tên:</label>
                        <input type="text" id="ten" name="ten" class="form-control" value="<?= htmlspecialchars($nguoiDung['ten']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($nguoiDung['email']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="sodienthoai" class="form-label">Số điện thoại:</label>
                        <input type="text" id="sodienthoai" name="sodienthoai" class="form-control" value="<?= htmlspecialchars($nguoiDung['sodienthoai'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="hinhanh" class="form-label">Hình ảnh:</label>
                        <input type="text" id="hinhanh" name="hinhanh" class="form-control" value="<?= htmlspecialchars($nguoiDung['hinhanh']) ?>" readonly>
                        
                        <div class="file-upload">
                            <div class="file-upload-btn">Chọn file hình ảnh</div>
                            <input type="file" id="fileInput" name="fileInput" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="file-name" id="fileName"></div>
                        
                        <div class="image-preview" id="imagePreview"></div>
                    </div>

                    <div class="form-group">
                        <label for="id_phanquyen" class="form-label">Phân quyền:</label>
                        <select id="id_phanquyen" name="id_phanquyen" class="form-select" required>
                            <option value="1" <?= $nguoiDung['id_phanquyen'] == 1 ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= $nguoiDung['id_phanquyen'] == 2 ? 'selected' : '' ?>>Nhân viên</option>
                            <option value="3" <?= $nguoiDung['id_phanquyen'] == 3 ? 'selected' : '' ?>>Khách hàng</option>
                        </select>
                    </div>

                    <input type="hidden" name="trangthai" value="1">

                    <div class="action-buttons">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Cập nhật
                        </button>
                        <a href="index.php?act=nguoidung" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
function openModal(imageSrc) {
    window.open(imageSrc, '_blank');
}

function previewImage(input) {
    const fileName = document.getElementById('fileName');
    const imagePreview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Hiển thị tên file
            fileName.textContent = 'File đã chọn: ' + input.files[0].name;
            
            // Hiển thị xem trước hình ảnh
            imagePreview.innerHTML = '<img src="' + e.target.result + '" class="user-avatar" style="max-width: 150px;">';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        fileName.textContent = '';
        imagePreview.innerHTML = '';
    }
}

// Hàm xử lý form submit
document.querySelector('form').addEventListener('submit', function(e) {
    // Không cần ngăn chặn hành vi mặc định vì chúng ta muốn form được gửi
    // Nếu có file được chọn, cập nhật giá trị của trường hinhanh
    const fileInput = document.getElementById('fileInput');
    if (fileInput.files && fileInput.files[0]) {
        // Tạo tên file mới dựa trên thời gian
        const timestamp = new Date().getTime();
        const fileName = 'img/nguoidung/' + timestamp + '_' + fileInput.files[0].name;
        document.getElementById('hinhanh').value = fileName;
    }
});
</script>
</body>
</html>
