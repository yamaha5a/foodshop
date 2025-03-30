<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết người dùng</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
/* Modal nền mờ */
/* Bỏ căn giữa ảnh */
.avatar-container {
    padding: 15px; /* Tạo khoảng cách xung quanh ảnh */
    text-align: left; /* Căn trái ảnh */
}

/* Hiển thị ảnh lớn hơn, không bo tròn */
.avatar {
    width: 250px;  /* Tăng kích thước chiều rộng */
    height: 300px; /* Tăng kích thước chiều cao */
    border-radius: 10px; /* Bo góc nhẹ */
    border: 3px solid #bbb; /* Viền xám nhạt */
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2); /* Đổ bóng nhẹ */
    object-fit: cover; /* Giúp ảnh không bị méo */
    transition: transform 0.3s ease-in-out;
}

/* Hiệu ứng phóng to khi di chuột */
.avatar:hover {
    transform: scale(1.08); /* Phóng to nhẹ khi di chuột */
}
/* Modal nền mờ */
.modal {
    display: none; /* Ẩn mặc định */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.9);
    text-align: center;
}

/* Ảnh hiển thị trong modal (TO HƠN - Full màn hình) */
.modal-content {
    margin-top: 2%;
    width: 95%;  /* Ảnh chiếm 95% chiều rộng màn hình */
    max-width: 1200px; /* Giới hạn max width lớn hơn */
    height: auto;
    border-radius: 10px;
}

/* Nút đóng */
.close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 50px;
    color: white;
    cursor: pointer;
}

/* Hiệu ứng khi mở modal */
.modal-content {
    animation: zoomIn 0.3s ease-in-out;
}

/* Hiệu ứng phóng to */
@keyframes zoomIn {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}



</style>
<body>

    <main class="main-content">
        <div class="page-title">
            <h2 class="title">Chi tiết người dùng</h2>
        </div>

        <div class="table-card">
            <div class="card-title">
                <h3><i class="fas fa-user"></i> Thông tin người dùng</h3>
            </div>
            <table class="data-table">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td><?php echo htmlspecialchars($nguoiDung['id']); ?></td>
                    </tr>
                    <tr>
                        <th>Tên</th>
                        <td><?php echo htmlspecialchars($nguoiDung['ten']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($nguoiDung['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Số điện thoại</th>
                        <td><?php echo htmlspecialchars($nguoiDung['sodienthoai']); ?></td>
                    </tr>
                    <tr>
                        <th>Giới tính</th>
                        <td><?php echo htmlspecialchars($nguoiDung['gioitinh']); ?></td>
                    </tr>
                    <tr>
                            <th>Hình ảnh</th>
                            <td>
                                <?php 
                                    $hinhanh = htmlspecialchars($nguoiDung['hinhanh']);
                                    $linkHinh = "http://localhost/shopfood/admin/public/" . $hinhanh;
                                ?>
                                <img src="<?php echo $linkHinh; ?>" alt="Hình ảnh người dùng" class="avatar" onclick="openModal('<?php echo $linkHinh; ?>')">
                            </td>
                        </tr>

                        <!-- Modal xem ảnh -->
                        <div id="imageModal" class="modal">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <img class="modal-content" id="fullImage">
                        </div>


                    <tr>
                        <th>Quyền</th>
                        <td>
                            <?php 
                                $tenQuyen = $this->layTenQuyen($nguoiDung['id_phanquyen']); 
                                echo htmlspecialchars($tenQuyen); 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            <span class="status <?php echo ($nguoiDung['trangthai'] === 'Hoạt động') ? 'active' : 'cancelled'; ?>">
                                <i class="fas <?php echo ($nguoiDung['trangthai'] === 'Hoạt động') ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i> 
                                <?php echo htmlspecialchars($nguoiDung['trangthai']); ?>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

</body>
<script>
function openModal(imageSrc) {
    document.getElementById("imageModal").style.display = "block";
    document.getElementById("fullImage").src = imageSrc;
}

function closeModal() {
    document.getElementById("imageModal").style.display = "none";
}
</script>

</html>
