<div class="container mt-4">
    <h3>Cập Nhật Danh Mục</h3>
    
    <?php if (isset($thongbao)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $thongbao; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="tendanhmuc">Tên danh mục</label>
            <input type="text" name="tendanhmuc" class="form-control" value="<?php echo htmlspecialchars($dm['tendanhmuc']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
        <a href="index.php?act=danhmuc" class="btn btn-secondary mt-2">Hủy</a>
    </form>
</div>
