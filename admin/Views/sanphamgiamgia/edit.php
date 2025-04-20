<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm giảm giá</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0,123,255,0.2);
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .product-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 5px;
            display: none;
        }
        .price-input {
            position: relative;
            display: flex;
            align-items: center;
        }
        .price-input input {
            padding-left: 10px;
            padding-right: 50px;
        }
        .currency-symbol {
            position: absolute;
            right: 10px;
            color: #666;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-title {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        .card-title h3 {
            margin: 0;
            color: #333;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="container-fluid">
            <?php
            // Kiểm tra xem sản phẩm có đơn hàng đang xử lý không
            if ($this->sanPhamGiamGiaModel->kiemTraSanPhamGiamGiaCoDonHang($_GET['id'])) {
                echo '<div style="padding: 20px; background-color: #f8d7da; color: #721c24; border-radius: 5px; margin: 20px 0;">
                    <h3><i class="fas fa-exclamation-triangle"></i> Không thể sửa sản phẩm</h3>
                    <p>Sản phẩm này đang có trong đơn hàng đang xử lý. Không thể sửa thông tin.</p>
                    <a href="index.php?act=sanphamgiamgia" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>';
                exit;
            }
            ?>

            <div class="card">
                <div class="card-title">
                    <h3><i class="fas fa-edit"></i> Sửa sản phẩm giảm giá</h3>
                </div>
                
                <div class="card-body">
                    <form action="index.php?act=suaSanPhamGiamGia&id=<?= $giamgia['id'] ?>" method="POST" class="form-container">
                        <div class="form-group">
                            <label for="id_sanpham">Sản phẩm:</label>
                            <select name="id_sanpham" id="id_sanpham" class="form-control" required>
                                <option value="">Chọn sản phẩm</option>
                                <?php foreach ($danhSachSanPham as $sp): ?>
                                    <option value="<?= $sp['id'] ?>" 
                                            data-gia="<?= $sp['gia'] ?>"
                                            data-hinhanh="../upload/<?= $sp['hinhanh1'] ?>"
                                            <?= ($sp['id'] == $giamgia['id_sanpham']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sp['tensanpham']) ?> - <?= number_format($sp['gia'], 0, ',', '.') ?> VNĐ
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <img id="productImage" class="product-image" src="" alt="Ảnh sản phẩm" onerror="this.style.display='none'">
                        </div>

                        <div class="form-group">
                            <label for="giagiam">Giá giảm:</label>
                            <div class="price-input">
                                <input type="text" name="giagiam" id="giagiam" class="form-control" 
                                       value="<?= number_format($giamgia['giagiam'], 0, ',', '.') ?>" required>
                                <span class="currency-symbol">VNĐ</span>
                            </div>
                            <small class="text-muted">Giá giảm phải nhỏ hơn giá gốc</small>
                        </div>

                        <div class="form-group">
                            <label for="ngay_giamgia">Ngày giảm giá:</label>
                            <input type="date" name="ngay_giamgia" id="ngay_giamgia" class="form-control" 
                                   value="<?= date('Y-m-d', strtotime($giamgia['ngay_giamgia'])) ?>" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu thay đổi
                            </button>
                            <a href="index.php?act=sanphamgiamgia" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Format số tiền khi nhập
        document.getElementById('giagiam').addEventListener('input', function(e) {
            let value = this.value.replace(/[^\d]/g, '');
            if (value) {
                value = parseInt(value).toLocaleString('vi-VN');
            }
            this.value = value;
        });

        // Hiển thị ảnh sản phẩm khi chọn
        document.getElementById('id_sanpham').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const imageUrl = selectedOption.dataset.hinhanh;
            const productImage = document.getElementById('productImage');
            
            if (imageUrl) {
                productImage.src = imageUrl;
                productImage.style.display = 'block';
            } else {
                productImage.style.display = 'none';
            }

            // Cập nhật giá tối đa cho input giá giảm
            const giaGoc = parseFloat(selectedOption.dataset.gia);
            const giaGiamInput = document.getElementById('giagiam');
            giaGiamInput.max = giaGoc;
        });

        // Kiểm tra giá giảm khi submit form
        document.querySelector('form').addEventListener('submit', function(e) {
            const selectedOption = document.getElementById('id_sanpham').options[document.getElementById('id_sanpham').selectedIndex];
            const giaGoc = parseFloat(selectedOption.dataset.gia);
            const giaGiam = parseFloat(document.getElementById('giagiam').value.replace(/[^\d]/g, ''));

            if (giaGiam >= giaGoc) {
                e.preventDefault();
                alert('Giá giảm phải nhỏ hơn giá gốc!');
            }
        });

        // Hiển thị ảnh sản phẩm ban đầu nếu có
        const initialOption = document.getElementById('id_sanpham').options[document.getElementById('id_sanpham').selectedIndex];
        if (initialOption && initialOption.dataset.hinhanh) {
            document.getElementById('productImage').src = initialOption.dataset.hinhanh;
            document.getElementById('productImage').style.display = 'block';
        }
    </script>
</body>
</html>