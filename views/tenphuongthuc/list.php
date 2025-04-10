<h2>Danh sách phương thức thanh toán</h2>
<a href="index.php?ctrl=tenphuongthuc&act=add">Thêm mới</a>
<table style="border: 1px solid black;">
    <tr><th>ID</th><th>Tên phương thức</th><th>Hành động</th></tr>
    <?php foreach ($dspt as $pt): ?>
        <tr>
            <td><?= $pt['id'] ?></td>
            <td><?= $pt['tenphuongthuc'] ?></td>
            <td>
                <a href="index.php?ctrl=tenphuongthuc&act=update&id=<?= $pt['id'] ?>">Sửa</a> | 
                <a href="index.php?ctrl=tenphuongthuc&act=delete&id=<?= $pt['id'] ?>" onclick="return confirm('Xoá?')">Xoá</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
