<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa mã giảm giá</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Sửa mã giảm giá</h2>
            <a href="index.php?act=khuyenmai" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="form-card">
            <form action="index.php?act=editkhuyenmai&id=<?= $discount['id'] ?>" method="POST" class="form">
                <div class="form-group">
                    <label for="tenkhuyenmai">Tên mã giảm giá:</label>
                    <input type="text" id="tenkhuyenmai" name="tenkhuyenmai" 
                           value="<?= htmlspecialchars($discount['tenkhuyenmai']) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="giatrigiam">Giá trị giảm (VNĐ):</label>
                    <input type="number" id="giatrigiam" name="giatrigiam" 
                           value="<?= htmlspecialchars($discount['giatrigiam']) ?>" min="0" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="ngaybatdau">Ngày bắt đầu:</label>
                    <input type="date" id="ngaybatdau" name="ngaybatdau" 
                           value="<?= date('Y-m-d', strtotime($discount['ngaybatdau'])) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="ngayketthuc">Ngày kết thúc:</label>
                    <input type="date" id="ngayketthuc" name="ngayketthuc" 
                           value="<?= date('Y-m-d', strtotime($discount['ngayketthuc'])) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="trangthai">Trạng thái:</label>
                    <select id="trangthai" name="trangthai" required class="form-control">
                        <option value="Hoạt động" <?= $discount['trangthai'] === 'Hoạt động' ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="Hết hạn" <?= $discount['trangthai'] === 'Hết hạn' ? 'selected' : '' ?>>Hết hạn</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <a href="index.php?act=khuyenmai" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
    // Kiểm tra ngày kết thúc phải lớn hơn ngày bắt đầu
    document.getElementById('ngayketthuc').addEventListener('change', function() {
        let startDate = new Date(document.getElementById('ngaybatdau').value);
        let endDate = new Date(this.value);
        
        if (endDate < startDate) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu');
            this.value = '';
        }
    });

    // Kiểm tra ngày bắt đầu không được nhỏ hơn ngày hiện tại
    document.getElementById('ngaybatdau').addEventListener('change', function() {
        let today = new Date();
        let startDate = new Date(this.value);
        
        if (startDate < today) {
            alert('Ngày bắt đầu không được nhỏ hơn ngày hiện tại');
            this.value = '';
        }
    });
    </script>
</body>
</html> 