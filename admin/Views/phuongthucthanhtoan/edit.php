
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chỉnh sửa phương thức thanh toán</h6>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <form action="index.php?act=editphuongthucthanhtoan" method="POST">
                <input type="hidden" name="id" value="<?php echo $paymentMethod['id']; ?>">
                <div class="form-group">
                    <label for="tenphuongthuc">Tên phương thức thanh toán</label>
                    <input type="text" class="form-control" id="tenphuongthuc" name="tenphuongthuc" 
                           value="<?php echo $paymentMethod['tenphuongthuc']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="index.php?act=listphuongthucthanhtoan" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div> 