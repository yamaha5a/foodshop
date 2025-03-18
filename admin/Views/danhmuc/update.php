<?php
if (!isset($danhmuc) || empty($danhmuc)) {
    echo "<div class='alert alert-danger'>Không tìm thấy danh mục!</div>";
    exit;
}
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<style>
.alert {
    padding: 15px;
    border-radius: 5px;
    font-size: 16px;
}
.alert i {
    margin-right: 8px;
}
</style>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Cập nhật danh mục</h1>

    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="index.php?act=danhmuc" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <?php if (isset($thongbao)): ?> 
                <div class="alert alert-success" role="alert">
                    <?php echo $thongbao; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?act=updateDM" method="POST">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">Mã danh mục</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>
    <input type="hidden" name="idDM" value="<?php echo $danhmuc['id']; ?>">
    <span><?php echo $danhmuc['id']; ?></span>
</td>

                            <td>
                                <input type="text" class="form-control" name="tenDM" value="<?php echo $danhmuc['tendanhmuc']; ?>" required>
                            </td>
                            <td>
                                <button type="submit" name="capnhat" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
