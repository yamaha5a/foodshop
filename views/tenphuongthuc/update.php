<h2>Cập nhật phương thức thanh toán</h2>
<form method="post">
    <input type="hidden" name="id" value="<?= $pt['id'] ?>">
    <input type="text" name="tenphuongthuc" value="<?= $pt['tenphuongthuc'] ?>" required>
    <input type="submit" name="submit" value="Cập nhật">
</form>
<?= isset($thongbao) ? $thongbao : "" ?>
