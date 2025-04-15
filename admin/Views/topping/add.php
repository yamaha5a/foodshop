<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm topping mới</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Thêm topping mới</h2>
        </div>

        <div class="form-card">
            <form action="index.php?act=addtopping" method="POST">
                <div class="form-group">
                    <label for="tentopping">Tên topping:</label>
                    <input type="text" id="tentopping" name="tentopping" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="gia">Giá:</label>
                    <input type="number" id="gia" name="gia" step="0.01" min="0" required class="form-control">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                    <a href="index.php?act=topping" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html> 