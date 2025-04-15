<?php
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cập nhật Topping cho Sản phẩm</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?act=sanpham_topping&action=update&id=<?php echo $productTopping['id']; ?>" method="POST">
                        <div class="form-group">
                            <label for="sanpham_id">Sản phẩm</label>
                            <select class="form-control" id="sanpham_id" name="sanpham_id" required>
                                <option value="">Chọn sản phẩm</option>
                                <?php foreach ($products as $product): ?>
                                <option value="<?php echo $product['id']; ?>" 
                                    <?php echo ($product['id'] == $productTopping['sanpham_id']) ? 'selected' : ''; ?>>
                                    <?php echo $product['ten_sanpham']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="topping_id">Topping</label>
                            <select class="form-control" id="topping_id" name="topping_id" required>
                                <option value="">Chọn topping</option>
                                <?php foreach ($toppings as $topping): ?>
                                <option value="<?php echo $topping['id']; ?>"
                                    <?php echo ($topping['id'] == $productTopping['topping_id']) ? 'selected' : ''; ?>>
                                    <?php echo $topping['ten_topping']; ?> - 
                                    <?php echo number_format($topping['gia_topping'], 0, ',', '.'); ?> đ
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gia_topping">Giá topping</label>
                            <input type="number" class="form-control" id="gia_topping" name="gia_topping" 
                                   value="<?php echo $productTopping['gia_topping']; ?>"
                                   min="0" step="1000" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="index.php?act=sanpham_topping" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('topping_id').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        var price = selectedOption.text.split('-')[1].trim().replace(' đ', '').replace(/\./g, '');
        document.getElementById('gia_topping').value = price;
    }
});
</script> 