<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách hóa đơn</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .search-form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .search-form input[type="text"] {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            flex: 1;
        }
        .search-form button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #45a049;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
        }
        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }
        .pagination a:hover {
            background-color: #f1f1f1;
        }
        .pagination .active {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }
        .pagination .disabled {
            color: #aaa;
            pointer-events: none;
        }
        
        /* Status styles */
        .status {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status i {
            margin-right: 5px;
        }
        .status-text {
            display: inline-block;
        }
        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status.confirmed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .status.preparing {
            background-color: #cce5ff;
            color: #004085;
        }
        .status.shipping {
            background-color: #e2e3e5;
            color: #383d41;
        }
        .status.delivered {
            background-color: #d4edda;
            color: #155724;
        }
        .status.cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        /* Sorting options styles */
        .sorting-options {
            margin-bottom: 15px;
        }
        .sort-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sort-form label {
            font-weight: 500;
        }
        .sort-form select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
        }
        .sort-form select:hover {
            border-color: #aaa;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Danh sách hóa đơn</h2>
        </div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-file-invoice"></i> Danh sách hóa đơn</h3>
            </div>
            
            <!-- Search Form -->
            <form class="search-form" method="GET" action="index.php">
                <input type="hidden" name="act" value="chitiethoadon">
                <input type="text" name="search" placeholder="Tìm kiếm theo mã đơn, tên khách hàng hoặc trạng thái..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <button type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
            </form>
            
            <!-- Sorting Options -->
            <div class="sorting-options">
                <form method="GET" action="index.php" class="sort-form">
                    <input type="hidden" name="act" value="chitiethoadon">
                    <?php if (!empty($search)): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <?php endif; ?>
                    
                    <label for="sort_by">Sắp xếp theo:</label>
                    <select name="sort_by" id="sort_by" onchange="this.form.submit()">
                        <option value="date_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'date_desc') ? 'selected' : ''; ?>>Đơn hàng mới nhất</option>
                        <option value="date_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'date_asc') ? 'selected' : ''; ?>>Đơn hàng cũ nhất</option>
                        <option value="amount_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'amount_desc') ? 'selected' : ''; ?>>Tổng tiền cao đến thấp</option>
                        <option value="amount_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'amount_asc') ? 'selected' : ''; ?>>Tổng tiền thấp đến cao</option>
                    </select>
                </form>
            </div>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Không tìm thấy hóa đơn nào</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['ten_nguoidung']); ?></td>
                                <td><?php echo htmlspecialchars($order['ngaytao']); ?></td>
                                <td><?php echo number_format($order['tongtien'], 0, ',', '.') . ' VNĐ'; ?></td>
                                <td><?php echo htmlspecialchars($order['tenphuongthuc']); ?></td>
                                <td>
                                    <span class="status <?php 
                                        echo $order['trangthai'] === 'Chờ xác nhận' ? 'pending' : 
                                            ($order['trangthai'] === 'Đang giao' ? 'shipping' :
                                            ($order['trangthai'] === 'Đã giao' ? 'delivered' :
                                            ($order['trangthai'] === 'Đã hủy' ? 'cancelled' : 'processing'))); 
                                    ?>">
                                        <?php echo htmlspecialchars($order['trangthai']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?act=detailchitiethoadon&id=<?php echo $order['id']; ?>" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="index.php?act=chitiethoadon&page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo isset($_GET['sort_by']) ? '&sort_by=' . htmlspecialchars($_GET['sort_by']) : ''; ?>">
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                        <a href="index.php?act=chitiethoadon&page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo isset($_GET['sort_by']) ? '&sort_by=' . htmlspecialchars($_GET['sort_by']) : ''; ?>">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    <?php else: ?>
                        <span class="disabled"><i class="fas fa-angle-double-left"></i></span>
                        <span class="disabled"><i class="fas fa-angle-left"></i></span>
                    <?php endif; ?>
                    
                    <?php
                    // Display page numbers
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);
                    
                    if ($startPage > 1) {
                        echo '<a href="index.php?act=chitiethoadon&page=1' . (!empty($search) ? '&search=' . urlencode($search) : '') . (isset($_GET['sort_by']) ? '&sort_by=' . htmlspecialchars($_GET['sort_by']) : '') . '">1</a>';
                        if ($startPage > 2) {
                            echo '<span>...</span>';
                        }
                    }
                    
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        if ($i == $page) {
                            echo '<span class="active">' . $i . '</span>';
                        } else {
                            echo '<a href="index.php?act=chitiethoadon&page=' . $i . (!empty($search) ? '&search=' . urlencode($search) : '') . (isset($_GET['sort_by']) ? '&sort_by=' . htmlspecialchars($_GET['sort_by']) : '') . '">' . $i . '</a>';
                        }
                    }
                    
                    if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1) {
                            echo '<span>...</span>';
                        }
                        echo '<a href="index.php?act=chitiethoadon&page=' . $totalPages . (!empty($search) ? '&search=' . urlencode($search) : '') . (isset($_GET['sort_by']) ? '&sort_by=' . htmlspecialchars($_GET['sort_by']) : '') . '">' . $totalPages . '</a>';
                    }
                    ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <a href="index.php?act=chitiethoadon&page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo isset($_GET['sort_by']) ? '&sort_by=' . htmlspecialchars($_GET['sort_by']) : ''; ?>">
                            <i class="fas fa-angle-right"></i>
                        </a>
                        <a href="index.php?act=chitiethoadon&page=<?php echo $totalPages; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo isset($_GET['sort_by']) ? '&sort_by=' . htmlspecialchars($_GET['sort_by']) : ''; ?>">
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="disabled"><i class="fas fa-angle-right"></i></span>
                        <span class="disabled"><i class="fas fa-angle-double-right"></i></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html> 