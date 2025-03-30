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
                        <td><img src="<?php echo $linkHinh; ?>" width="100"></td>

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
