<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Topping của Sản phẩm</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .product-image:hover {
            transform: scale(1.1);
        }
        .table-image {
            width: 100px;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Quản lý Topping của Sản phẩm</h2>
        </div>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }

        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm sản phẩm hoặc topping..." onkeyup="showResults()" />
        </div>
        <div id="searchResults" class="search-results"></div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-list"></i> Danh sách Topping của Sản phẩm</h3>
                <a href="index.php?act=addsanpham_topping" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ảnh sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Tên topping</th>
                        <th>Giá topping</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productToppings as $pt): ?>
                        <tr>
                            <td><?php echo $pt['id']; ?></td>
                            <td class="table-image">
                                <img src="../upload/<?php echo $pt['hinhanh1']; ?>" 
                                     alt="<?php echo $pt['tensanpham']; ?>" 
                                     class="product-image">
                            </td>
                            <td><?php echo $pt['tensanpham']; ?></td>
                            <td><?php echo $pt['tentopping']; ?></td>
                            <td><?php echo number_format($pt['gia'], 0, ',', '.'); ?> đ</td>
                            <td>
                                <a href="index.php?act=editsanpham_topping&id=<?php echo $pt['id']; ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?act=deletesanpham_topping&id=<?php echo $pt['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
    function showResults() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let table = document.querySelector('.data-table');
        let rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            let row = rows[i];
            let cells = row.getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                let cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(input) > -1) {
                    found = true;
                    break;
                }
            }

            row.style.display = found ? '' : 'none';
        }
    }
    </script>
</body>
</html> 