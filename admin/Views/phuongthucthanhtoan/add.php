<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm phương thức thanh toán mới</h6>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <form action="index.php?act=addphuongthucthanhtoan" method="POST">
                <div class="form-group">
                    <label for="tenphuongthuc">Tên phương thức thanh toán</label>
                    <input type="text" class="form-control" id="tenphuongthuc" name="tenphuongthuc" required>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <a href="index.php?act=listphuongthucthanhtoan" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div> 