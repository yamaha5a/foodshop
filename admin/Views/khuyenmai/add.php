<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mã giảm giá</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Thêm mã giảm giá mới</h2>
            <a href="index.php?act=khuyenmai" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="form-card">
            <form action="index.php?act=addkhuyenmai" method="POST" class="form">
                <div class="form-group">
                    <label for="tenkhuyenmai">Tên mã giảm giá:</label>
                    <input type="text" id="tenkhuyenmai" name="tenkhuyenmai" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="giatrigiam">Giá trị giảm (VNĐ):</label>
                    <input type="number" id="giatrigiam" name="giatrigiam" min="0" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="ngaybatdau">Ngày bắt đầu:</label>
                    <input type="date" id="ngaybatdau" name="ngaybatdau" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="ngayketthuc">Ngày kết thúc:</label>
                    <input type="date" id="ngayketthuc" name="ngayketthuc" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="trangthai">Trạng thái:</label>
                    <select id="trangthai" name="trangthai" required class="form-control">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Hết hạn">Hết hạn</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                    <a href="index.php?act=khuyenmai" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
    // Kiểm tra ngày kết thúc phải lớnơn ngày bắt đầu
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
        // Lấy ngày hiện tại và đặt giờ về 00:00:00
        let today = new Date();
        today.setHours(0, 0, 0, 0);
        
        // Lấy ngày được chọn và đặt giờ về 00:00:00
        let startDate = new Date(this.value);
        startDate.setHours(0, 0, 0, 0);
        
        if (startDate < today) {
            alert('Ngày bắt đầu không được nhỏ hơn ngày hiện tại');
            this.value = '';
        }
    });
    </script>
</body>
</html>