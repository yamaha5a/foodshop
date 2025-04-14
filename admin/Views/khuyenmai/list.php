<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý mã giảm giá</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Quản lý mã giảm giá</h2>
            <a href="index.php?act=addkhuyenmai" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm mã giảm giá
            </a>
        </div>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm mã giảm giá..." onkeyup="showResults()" />
        </div>
        <div id="searchResults" class="search-results"></div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-tags"></i> Danh sách mã giảm giá</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên mã</th>
                        <th>Giá trị giảm</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($discounts as $discount): ?>
                        <tr>
                            <td><?= htmlspecialchars($discount['id']) ?></td>
                            <td><?= htmlspecialchars($discount['tenkhuyenmai']) ?></td>
                            <td><?= number_format($discount['giatrigiam'], 0, ',', '.') ?> VNĐ</td>
                            <td><?= date('d/m/Y', strtotime($discount['ngaybatdau'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($discount['ngayketthuc'])) ?></td>
                            <td>
                                <span class="status <?= $discount['trangthai'] === 'Hoạt động' ? 'active' : 'cancelled' ?>">
                                    <i class="fas <?= $discount['trangthai'] === 'Hoạt động' ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                                    <?= htmlspecialchars($discount['trangthai']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?act=editkhuyenmai&id=<?= $discount['id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?act=deletekhuyenmai&id=<?= $discount['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?')">
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