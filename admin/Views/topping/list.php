<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý topping</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Quản lý topping</h2>
        </div>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm topping..." onkeyup="showResults()" />
        </div>
        <div id="searchResults" class="search-results"></div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-list"></i> Danh sách topping</h3>
                <a href="index.php?act=addtopping" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm topping mới
                </a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên topping</th>
                        <th>Giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($toppings as $topping): ?>
                        <tr>
                            <td><?= htmlspecialchars($topping['id']) ?></td>
                            <td><?= htmlspecialchars($topping['tentopping']) ?></td>
                            <td>$<?= number_format($topping['gia'], 2) ?></td>
                            <td>
                                <a href="index.php?act=edittopping&id=<?= $topping['id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?act=deletetopping&id=<?= $topping['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa topping này?')">
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