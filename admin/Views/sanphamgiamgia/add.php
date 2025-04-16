<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm giảm giá</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
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
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: #545b62;
        }
        
        .product-preview {
            display: none;
            margin-top: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        
        .product-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        
        .product-info {
            margin-top: 10px;
        }
        
        .price-info {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            margin: 10px 0;
        }
        
        .discount-calculator {
            margin-top: 15px;
            padding: 10px;
            background-color: #f0f8ff;
            border-radius: 4px;
        }
        
        .discount-result {
            font-weight: bold;
            color: #dc3545;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-title">
                    <h3><i class="fas fa-plus"></i> Thêm sản phẩm giảm giá</h3>
                </div>
                
                <div class="card-body">
                    <div class="form-container">
                        <form action="index.php?act=addSanPhamGiamGia" method="POST">
                            <div class="form-group">
                                <label for="id_sanpham">Sản phẩm:</label>
                                <select name="id_sanpham" id="id_sanpham" class="form-control" required>
                                    <option value="">Chọn sản phẩm</option>
                                    <?php foreach ($danhSachSanPham as $sanpham): ?>
                                        <option value="<?= $sanpham['id'] ?>" 
                                                data-gia="<?= $sanpham['gia'] ?>"
                                                data-hinhanh="<?= $sanpham['hinhanh1'] ?>"
                                                data-mota="<?= $sanpham['mota'] ?>">
                                            <?= htmlspecialchars($sanpham['tensanpham']) ?> - 
                                            <?= number_format($sanpham['gia'], 0, ',', '.') ?> đ
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="product-preview" class="product-preview">
                                <h4>Thông tin sản phẩm</h4>
                                <div id="product-image-container">
                                    <img id="product-image" class="product-image" src="" alt="Hình ảnh sản phẩm">
                                </div>
                                <div class="product-info">
                                    <p id="product-description"></p>
                                    <div class="price-info">
                                        Giá gốc: <span id="original-price"></span> đ
                                    </div>
                                </div>
                                
                                <div class="discount-calculator">
                                    <label for="discount-percentage">Phần trăm giảm giá:</label>
                                    <input type="number" id="discount-percentage" min="1" max="99" value="10" class="form-control" style="width: 100px;">
                                    <div class="discount-result">
                                        Giá sau giảm: <span id="discounted-price"></span> đ
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="giagiam">Giá giảm:</label>
                                <input type="number" name="giagiam" id="giagiam" class="form-control" required min="0" step="1">
                                <small class="text-muted">Giá giảm phải nhỏ hơn giá gốc</small>
                            </div>

                            <div class="form-group">
                                <label for="ngay_giamgia">Ngày giảm giá:</label>
                                <input type="date" name="ngay_giamgia" id="ngay_giamgia" class="form-control" 
                                       value="<?= date('Y-m-d') ?>" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <a href="index.php?act=sanphamgiamgia" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('id_sanpham').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const productPreview = document.getElementById('product-preview');
            const productImage = document.getElementById('product-image');
            const productDescription = document.getElementById('product-description');
            const originalPrice = document.getElementById('original-price');
            const discountedPrice = document.getElementById('discounted-price');
            const giagiamInput = document.getElementById('giagiam');
            
            if (selectedOption.value) {
                // Hiển thị thông tin sản phẩm
                const giaGoc = parseFloat(selectedOption.dataset.gia);
                const hinhanh = selectedOption.dataset.hinhanh;
                const mota = selectedOption.dataset.mota;
                
                // Hiển thị hình ảnh
                if (hinhanh) {
                    productImage.src = '/shopfood/upload/' + hinhanh;
                    document.getElementById('product-image-container').style.display = 'block';
                } else {
                    document.getElementById('product-image-container').style.display = 'none';
                }
                
                // Hiển thị mô tả
                productDescription.textContent = mota || 'Không có mô tả';
                
                // Hiển thị giá gốc
                originalPrice.textContent = giaGoc.toLocaleString('vi-VN');
                
                // Tính giá sau giảm
                const discountPercentage = document.getElementById('discount-percentage').value;
                const giaSauGiam = giaGoc * (1 - discountPercentage / 100);
                discountedPrice.textContent = Math.round(giaSauGiam).toLocaleString('vi-VN');
                
                // Cập nhật giá giảm
                giagiamInput.value = Math.round(giaSauGiam);
                giagiamInput.max = giaGoc;
                
                // Hiển thị preview
                productPreview.style.display = 'block';
            } else {
                // Ẩn preview nếu không có sản phẩm nào được chọn
                productPreview.style.display = 'none';
            }
        });
        
        // Cập nhật giá giảm khi thay đổi phần trăm giảm giá
        document.getElementById('discount-percentage').addEventListener('input', function() {
            const selectedOption = document.getElementById('id_sanpham').options[document.getElementById('id_sanpham').selectedIndex];
            if (selectedOption.value) {
                const giaGoc = parseFloat(selectedOption.dataset.gia);
                const discountPercentage = parseFloat(this.value);
                
                if (discountPercentage > 0 && discountPercentage < 100) {
                    const giaSauGiam = giaGoc * (1 - discountPercentage / 100);
                    document.getElementById('discounted-price').textContent = Math.round(giaSauGiam).toLocaleString('vi-VN');
                    document.getElementById('giagiam').value = Math.round(giaSauGiam);
                }
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const selectedOption = document.getElementById('id_sanpham').options[document.getElementById('id_sanpham').selectedIndex];
            const giaGoc = parseFloat(selectedOption.dataset.gia);
            const giaGiam = parseFloat(document.getElementById('giagiam').value);

            if (giaGiam >= giaGoc) {
                e.preventDefault();
                alert('Giá giảm phải nhỏ hơn giá gốc!');
            }
        });
    </script>
</body>
</html>