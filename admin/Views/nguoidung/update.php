<h2>Cập nhật người dùng</h2>
<form method="POST" action="">
    <input type="hidden" name="id" value="<?= $nguoiDung['id'] ?>">

    <label>Tên:</label>
    <input type="text" name="ten" value="<?= htmlspecialchars($nguoiDung['ten']) ?>"><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($nguoiDung['email']) ?>"><br>

    <label>Số điện thoại:</label>
    <input type="text" name="sodienthoai" value="<?= htmlspecialchars($nguoiDung['sodienthoai']) ?>"><br>

    <label>Hình ảnh:</label>
    <input type="text" name="hinhanh" value="<?= htmlspecialchars($nguoiDung['hinhanh']) ?>"><br>

    <label>Phân quyền:</label>
    <input type="text" name="id_phanquyen" value="<?= htmlspecialchars($nguoiDung['id_phanquyen']) ?>"><br>

    <label>Trạng thái:</label>
    <select name="trangthai">
        <option value="1" <?= $nguoiDung['trangthai'] == 1 ? 'selected' : '' ?>>Kích hoạt</option>
        <option value="0" <?= $nguoiDung['trangthai'] == 0 ? 'selected' : '' ?>>Khóa</option>
    </select><br>

    <button type="submit">Cập nhật</button>
</form>
