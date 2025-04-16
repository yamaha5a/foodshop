<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm giảm giá</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="container-fluid">
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
                                            <?= ($sp['id'] == $giamgia['id_sanpham']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sp['tensanpham']) ?> - <?= number_format($sp['gia'], 0, ',', '.') ?> đ
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="giagiam">Giá giảm:</label>
                            <input type="number" name="giagiam" id="giagiam" class="form-control" 
                                   value="<?= $giamgia['giagiam'] ?>" required min="0" step="1000">
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
        document.getElementById('id_sanpham').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const giaGoc = parseFloat(selectedOption.dataset.gia);
            const giaGiamInput = document.getElementById('giagiam');
            
            giaGiamInput.max = giaGoc;
            giaGiamInput.placeholder = `Tối đa ${giaGoc.toLocaleString('vi-VN')} đ`;
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