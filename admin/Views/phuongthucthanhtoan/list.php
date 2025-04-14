
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phương thức thanh toán</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    .table-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }

    .card-title {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .card-title h3 {
        color: #333;
        font-size: 1.5rem;
        margin: 0;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background-color: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .data-table td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
        color: #6c757d;
    }

    .data-table tr:hover {
        background-color: #f8f9fa;
    }

    .btn {
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        margin-right: 5px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-info {
        background-color: #17a2b8;
        color: white;
        border: none;
    }

    .btn-info:hover {
        background-color: #138496;
    }

    .btn-outline {
        background-color: transparent;
        color: #6c757d;
        border: 1px solid #6c757d;
    }

    .btn-outline:hover {
        background-color: #6c757d;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .page-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .title {
        font-size: 24px;
        color: #333;
        margin: 0;
    }

    .search-bar {
        display: flex;
        align-items: center;
        background: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .search-bar i {
        color: #6c757d;
        margin-right: 10px;
    }

    .search-bar input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 14px;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Danh sách phương thức thanh toán</h2>
            <a href="index.php?act=addphuongthucthanhtoan" class="btn btn-primary">
                <i class="fas fa-folder-plus"></i> Thêm mới
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm phương thức thanh toán..." onkeyup="showResults()" />
        </div>
        <div id="searchResults" class="search-results"></div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-credit-card"></i> Danh sách phương thức thanh toán</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên phương thức</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paymentMethods as $method): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($method['id']); ?></td>
                            <td><?php echo htmlspecialchars($method['tenphuongthuc']); ?></td>
                            <td>
                                <a href="index.php?act=editphuongthucthanhtoan&id=<?php echo $method['id']; ?>" class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index.php?act=deletephuongthucthanhtoan&id=<?php echo $method['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa phương thức thanh toán này?')">
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
            let name = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            if (name.includes(input)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
    </script>
</body>
</html> 
