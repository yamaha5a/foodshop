<style>
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
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Quản lý Banner</h1>

    <div class="card table-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="index.php?act=addbanner" class="btn btn-primary">
                <i class="fas fa-folder-plus"></i> Thêm Banner
            </a>
        </div>

        <?php if (isset($_SESSION['thongbao'])): ?>
            <div class="alert alert-success" role="alert">
                <?php 
                    echo $_SESSION['thongbao']; 
                    unset($_SESSION['thongbao']); 
                ?>
            </div>
        <?php endif; ?>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listBanner as $banner): ?>
                    <tr>
                        <td><?php echo $banner['id']; ?></td>
                        <?php 
                        $hinhanh = htmlspecialchars($banner['hinhanh']);
                        $linkHinh = "http://localhost/shopfood/admin/public/" . $hinhanh;
                        ?>
                        <td>
                            <img src="<?php echo $linkHinh; ?>" width="100" onclick="openModal('<?php echo $linkHinh; ?>')" style="cursor: pointer;">
                        </td>
                        <td>
                            <a href="index.php?act=editbanner&id=<?php echo $banner['id']; ?>" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="index.php?act=deletebanner&id=<?php echo $banner['id']; ?>" 
                               class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa banner này?')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal cho hình ảnh -->
<div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="fullImage">
</div>

<script>
function openModal(imageSrc) {
    document.getElementById("imageModal").style.display = "block";
    document.getElementById("fullImage").src = imageSrc;
}

function closeModal() {
    document.getElementById("imageModal").style.display = "none";
}
</script>
