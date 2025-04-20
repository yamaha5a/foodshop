<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý liên hệ</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Quản lý liên hệ</h2>
        </div>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm liên hệ..." onkeyup="showResults()" />
        </div>
        <div id="searchResults" class="search-results"></div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-envelope"></i> Danh sách liên hệ</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Người gửi</th>
                        <th>Email</th>
                        <th>Tiêu đề</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lienHeList as $lienHe): ?>
                        <tr>
                            <td><?= htmlspecialchars($lienHe['id']) ?></td>
                            <td><?= htmlspecialchars($lienHe['ten_nguoidung']) ?></td>
                            <td><?= htmlspecialchars($lienHe['email']) ?></td>
                            <td><?= htmlspecialchars($lienHe['tieude']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($lienHe['ngaygui'])) ?></td>
                            <td>
                                <?php if (empty($lienHe['traloi'])): ?>
                                    <span class="badge bg-warning">Chưa phản hồi</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Đã phản hồi</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?act=detailLienHe&id=<?= $lienHe['id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                                <a href="index.php?act=deleteLienHe&id=<?= $lienHe['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')">
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