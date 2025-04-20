<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng</title>
    <link rel="stylesheet" href="css.css"> <!-- Đường dẫn tới file CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<style>
    /* Ảnh trong danh sách người dùng (thu nhỏ) */
.avatar {
    width: 50px;  /* Chiều rộng nhỏ hơn */
    height: 50px; /* Chiều cao nhỏ hơn */
    border-radius: 5px; /* Bo góc nhẹ */
    object-fit: cover; /* Giữ tỉ lệ ảnh, không bị méo */
    cursor: pointer; /* Hiển thị con trỏ khi hover */
    transition: transform 0.2s ease-in-out;
}

/* Khi di chuột vào ảnh, hiển thị hiệu ứng */
.avatar:hover {
    transform: scale(1.1); /* Phóng to nhẹ khi hover */
}

/* CSS cho phân trang */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 20px;
}

.pagination a, .pagination span {
    color: #333;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    margin: 0 4px;
    border-radius: 4px;
}

.pagination a:hover {
    background-color: #f1f1f1;
}

.pagination .active {
    background-color: #4CAF50;
    color: white;
    border: 1px solid #4CAF50;
}

.pagination .disabled {
    color: #aaa;
    pointer-events: none;
}

/* CSS cho thanh tìm kiếm */
.search-container {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.search-bar {
    position: relative;
    width: 300px;
}

.search-bar input {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.search-bar i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
}

.search-results {
    margin-top: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    max-height: 300px;
    overflow-y: auto;
    display: none;
}

.search-results div {
    padding: 10px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
}

.search-results div:hover {
    background-color: #f5f5f5;
}
</style>
<body>
        <!-- Thanh tìm kiếm -->
        <div class="search-container">
            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="act" value="nguoidung">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Tìm kiếm theo tên hoặc email..." 
                           value="<?php echo htmlspecialchars($search ?? ''); ?>" />
                </div>
                <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </form>
        </div>

        <!-- Bảng danh sách người dùng -->
        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-user"></i> Danh sách người dùng</h3>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Hình ảnh</th>
                        <th>Quyền</th>
                        <th>Trạng thái</th> 
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($danhSachNguoiDung)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Không tìm thấy người dùng nào</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($danhSachNguoiDung as $nguoiDung): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($nguoiDung['id']); ?></td>
                                <td><?php echo htmlspecialchars($nguoiDung['ten']); ?></td>
                                <td><?php echo htmlspecialchars($nguoiDung['email']); ?></td>
                                <td>
                                <?php 
                                    $hinhanh = htmlspecialchars($nguoiDung['hinhanh']);
                                    $linkHinh = "http://localhost/shopfood/admin/public/" . $hinhanh;
                                ?>      
                                <img src="<?php echo $linkHinh; ?>" alt="Hình ảnh người dùng" class="avatar" onclick="openModal('<?php echo $linkHinh; ?>')">
                                </td>

                                <td>
                                    <?php
                                    $controller = new NguoiDungController();
                                    $tenQuyen = $controller->layTenQuyen($nguoiDung['id_phanquyen']); // Gọi hàm từ controller
                                    echo htmlspecialchars($tenQuyen);
                                    ?>
                                </td>
                                <td>
                                    <span class="status active">
                                        <i class="fas fa-check-circle"></i> Hoạt động
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?act=detailnguoidung&id=<?php echo $nguoiDung['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                    <a href="index.php?act=capnhatNguoiDung&id=<?php echo $nguoiDung['id']; ?>" class="btn btn-outline btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="index.php?act=nguoidung&page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                    <i class="fas fa-angle-double-left"></i>
                </a>
                <a href="index.php?act=nguoidung&page=<?php echo $currentPage - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                    <i class="fas fa-angle-left"></i>
                </a>
            <?php else: ?>
                <span class="disabled"><i class="fas fa-angle-double-left"></i></span>
                <span class="disabled"><i class="fas fa-angle-left"></i></span>
            <?php endif; ?>

            <?php
            // Hiển thị các trang
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);

            if ($startPage > 1) {
                echo '<a href="index.php?act=nguoidung&page=1' . (!empty($search) ? '&search=' . urlencode($search) : '') . '">1</a>';
                if ($startPage > 2) {
                    echo '<span>...</span>';
                }
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $currentPage) {
                    echo '<span class="active">' . $i . '</span>';
                } else {
                    echo '<a href="index.php?act=nguoidung&page=' . $i . (!empty($search) ? '&search=' . urlencode($search) : '') . '">' . $i . '</a>';
                }
            }

            if ($endPage < $totalPages) {
                if ($endPage < $totalPages - 1) {
                    echo '<span>...</span>';
                }
                echo '<a href="index.php?act=nguoidung&page=' . $totalPages . (!empty($search) ? '&search=' . urlencode($search) : '') . '">' . $totalPages . '</a>';
            }
            ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="index.php?act=nguoidung&page=<?php echo $currentPage + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                    <i class="fas fa-angle-right"></i>
                </a>
                <a href="index.php?act=nguoidung&page=<?php echo $totalPages; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            <?php else: ?>
                <span class="disabled"><i class="fas fa-angle-right"></i></span>
                <span class="disabled"><i class="fas fa-angle-double-right"></i></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </main>

    <script>
        // Hàm mở modal xem ảnh
        function openModal(imageUrl) {
            // Tạo modal
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.zIndex = '1000';
            modal.style.left = '0';
            modal.style.top = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0,0,0,0.7)';
            modal.style.display = 'flex';
            modal.style.justifyContent = 'center';
            modal.style.alignItems = 'center';
            modal.style.cursor = 'pointer';

            // Tạo ảnh
            const img = document.createElement('img');
            img.src = imageUrl;
            img.style.maxWidth = '80%';
            img.style.maxHeight = '80%';
            img.style.borderRadius = '5px';
            img.style.boxShadow = '0 0 10px rgba(0,0,0,0.5)';

            // Thêm ảnh vào modal
            modal.appendChild(img);

            // Thêm modal vào body
            document.body.appendChild(modal);

            // Đóng modal khi click
            modal.onclick = function() {
                document.body.removeChild(modal);
            };
        }
    </script>
</body>
</html>