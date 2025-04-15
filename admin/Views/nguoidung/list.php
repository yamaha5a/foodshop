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
</style>
<body>

    <!-- Nội dung chính -->
    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Danh sách người dùng</h2>
            <a href="index.php?act=addnguoidung" class="btn btn-primary">
        <i class="fas fa-folder-plus"></i> Thêm mới
        </a></div>


             <div>
    <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="showResults()" />
    </div>
    <div id="searchResults" class="search-results"></div> <!-- Khu vực hiển thị kết quả -->
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
                                <span class="status <?php echo ($nguoiDung['trangthai'] === 'Hoạt động') ? 'active' : 'cancelled'; ?>">
                                    <i class="fas <?php echo ($nguoiDung['trangthai'] === 'Hoạt động') ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i> 
                                    <?php echo htmlspecialchars($nguoiDung['trangthai']); ?>
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
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>