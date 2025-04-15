<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Topping cho Sản phẩm</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .product-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .product-image {
            text-align: center;
            margin: 20px 0;
        }
        .product-image img {
            max-width: 250px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .product-image img:hover {
            transform: scale(1.05);
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn i {
            font-size: 16px;
        }
        .btn-primary {
            background: #4CAF50;
            border: none;
            color: white;
        }
        .btn-primary:hover {
            background: #45a049;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #f8f9fa;
            border: 1px solid #ddd;
            color: #333;
        }
        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title"><i class="fas fa-plus-circle"></i> Thêm Topping cho Sản phẩm</h2>
        </div>

        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <div class="product-card">
            <form action="index.php?act=addsanpham_topping" method="POST">
                <div class="form-group">
                    <label for="sanpham_id"><i class="fas fa-box"></i> Sản phẩm</label>
                    <select class="form-control" id="sanpham_id" name="sanpham_id" required onchange="showProductImage(this.value)">
                        <option value="">-- Chọn sản phẩm --</option>
                        <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product['id']; ?>" 
                                data-image="<?php echo $product['hinhanh1']; ?>">
                            <?php echo $product['tensanpham']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="productImage" class="product-image" style="display: none;">
                        <img src="" alt="Hình ảnh sản phẩm" class="img-fluid">
                    </div>
                </div>
                <div class="form-group">
                    <label for="topping_id"><i class="fas fa-utensils"></i> Topping</label>
                    <select class="form-control" id="topping_id" name="topping_id" required>
                        <option value="">-- Chọn topping --</option>
                        <?php foreach ($toppings as $topping): ?>
                        <option value="<?php echo $topping['id']; ?>">
                            <?php echo $topping['tentopping']; ?> - 
                            <span class="text-success"><?php echo number_format($topping['gia'], 0, ',', '.'); ?> đ</span>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Thêm mới
                    </button>
                    <a href="index.php?act=sanpham_topping" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
    function showProductImage(productId) {
        const select = document.getElementById('sanpham_id');
        const selectedOption = select.options[select.selectedIndex];
        const imageContainer = document.getElementById('productImage');
        const productImage = imageContainer.querySelector('img');

        if (productId) {
            const imagePath = selectedOption.getAttribute('data-image');
            productImage.src = '../upload/' + imagePath;
            imageContainer.style.display = 'block';
            // Thêm hiệu ứng fade in
            imageContainer.style.opacity = '0';
            setTimeout(() => {
                imageContainer.style.opacity = '1';
                imageContainer.style.transition = 'opacity 0.5s ease';
            }, 100);
        } else {
            imageContainer.style.display = 'none';
        }
    }
    </script>
</body>
</html> 