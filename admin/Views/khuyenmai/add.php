<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mã giảm giá</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .main-content {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .title {
            color: #333;
            font-size: 24px;
            margin: 0;
        }
        .form-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(76,175,80,0.2);
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-primary {
            background: #4CAF50;
            color: white;
        }
        .btn-success {
            background: #4CAF50;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .price-input-container {
            position: relative;
        }
        .price-input-container::after {
            content: "VNĐ";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 14px;
        }
    </style>
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
                    <label for="giatrigiam">Giá trị giảm:</label>
                    <div class="price-input-container">
                        <input type="text" id="giatrigiam" name="giatrigiam" required class="form-control" placeholder="0">
                    </div>
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
    // Format số tiền với dấu chấm
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Xử lý input số tiền
    document.getElementById('giatrigiam').addEventListener('input', function(e) {
        // Lấy giá trị và loại bỏ tất cả các ký tự không phải số
        let value = this.value.replace(/[^\d]/g, '');
        
        // Format số với dấu chấm
        this.value = formatNumber(value);
    });

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
        today.setHours(0, 0, 0, 0);
        
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