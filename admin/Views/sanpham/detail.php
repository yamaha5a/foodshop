<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết sản phẩm</title>
    <style>
        .product-detail {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .product-title {
            font-size: 24px;
            color: #333;
        }
        
        .product-images {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        
        .product-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-item {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #333;
        }
        
        .product-description {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        .status-available {
            color: green;
            font-weight: bold;
        }
        
        .status-unavailable {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="product-detail">
        <div class="product-header">
            <h1 class="product-title">Chi tiết sản phẩm: <?= htmlspecialchars($sanPham['tensanpham']) ?></h1>
            <div class="product-actions">
                <a href="index.php?act=sanpham" class="btn btn-primary">Quay lại danh sách</a>
                <a href="index.php?act=suaSanPham&id=<?= $sanPham['id'] ?>" class="btn btn-warning">Sửa</a>
                <a href="index.php?act=xoaSP&id=<?= $sanPham['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
            </div>
        </div>
        
        <div class="product-images">
            <?php
            $adress_hinh1 = "../upload/" . $sanPham['hinhanh1'];
            $adress_hinh2 = "../upload/" . $sanPham['hinhanh2'];
            $adress_hinh3 = "../upload/" . $sanPham['hinhanh3'];
            
            if (is_file($adress_hinh1)) {
                echo '<img src="' . $adress_hinh1 . '" alt="Hình ảnh 1" class="product-image">';
            } else {
                echo '<div class="product-image" style="display: flex; align-items: center; justify-content: center; background-color: #f0f0f0;">Không có hình ảnh</div>';
            }
            
            if (is_file($adress_hinh2)) {
                echo '<img src="' . $adress_hinh2 . '" alt="Hình ảnh 2" class="product-image">';
            }
            
            if (is_file($adress_hinh3)) {
                echo '<img src="' . $adress_hinh3 . '" alt="Hình ảnh 3" class="product-image">';
            }
            ?>
        </div>
        
        <div class="product-info">
            <div class="info-item">
                <div class="info-label">ID Sản phẩm:</div>
                <div class="info-value"><?= htmlspecialchars($sanPham['id']) ?></div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Tên sản phẩm:</div>
                <div class="info-value"><?= htmlspecialchars($sanPham['tensanpham']) ?></div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Giá:</div>
                <div class="info-value"><?= number_format($sanPham['gia'], 0, ',', '.') ?> đ</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Số lượng:</div>
                <div class="info-value"><?= htmlspecialchars($sanPham['soluong']) ?></div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Danh mục:</div>
                <div class="info-value">
                    <?php
                    // Lấy tên danh mục từ model
                    $danhMucModel = new danhMucModel();
                    $danhMuc = $danhMucModel->getOneDanhMuc($sanPham['id_danhmuc']);
                    echo htmlspecialchars($danhMuc['tendanhmuc'] ?? 'Không xác định');
                    ?>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Loại sản phẩm:</div>
                <div class="info-value">
                    <?php
                    // Lấy tên loại sản phẩm từ model nếu có
                    if (isset($sanPham['id_loaisanpham']) && $sanPham['id_loaisanpham']) {
                        // Giả sử có model loại sản phẩm
                        // $loaiSanPhamModel = new LoaiSanPhamModel();
                        // $loaiSanPham = $loaiSanPhamModel->getLoaiSanPhamById($sanPham['id_loaisanpham']);
                        // echo htmlspecialchars($loaiSanPham['tenloaisanpham'] ?? 'Không xác định');
                        echo htmlspecialchars($sanPham['id_loaisanpham']);
                    } else {
                        echo 'Không xác định';
                    }
                    ?>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Trạng thái:</div>
                <div class="info-value">
                    <?php if ($sanPham['trangthai'] == 'Còn hàng'): ?>
                        <span class="status-available">Còn hàng</span>
                    <?php else: ?>
                        <span class="status-unavailable">Hết hàng</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Thời gian tạo:</div>
                <div class="info-value"><?= date("d-m-Y H:i:s", strtotime($sanPham['thoigiantao'])) ?></div>
            </div>
        </div>
        
        <div class="product-description">
            <h3>Mô tả sản phẩm:</h3>
            <p><?= nl2br(htmlspecialchars($sanPham['mota'])) ?></p>
        </div>
        
        <?php if (!empty($sanPham['chitiet'])): ?>
        <div class="product-description">
            <h3>Chi tiết sản phẩm:</h3>
            <p><?= nl2br(htmlspecialchars($sanPham['chitiet'])) ?></p>
        </div>
        <?php endif; ?>
    </div>
</body>

</html> 