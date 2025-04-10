<h2>Danh sách bình luận</h2>
<form method="get">
    <input type="hidden" name="ctrl" value="binhluan">
    <input type="hidden" name="act" value="list">
    <input type="text" name="keyword" placeholder="Tìm nội dung..." value="<?= $keyword ?>">
    <input type="submit" value="Tìm kiếm">
</form>

<table border="1">
    <tr>
        <th>ID</th><th>ID Người Dùng</th><th>ID Sản Phẩm</th>
        <th>Nội dung</th><th>Đánh giá</th><th>Ngày đăng</th><th>Hành động</th>
    </tr>
    <?php foreach ($dsbl as $bl): ?>
        <tr>
            <td><?= $bl['id'] ?></td>
            <td><?= $bl['idnguoidung'] ?></td>
            <td><?= $bl['idsanpham'] ?></td>
            <td><?= $bl['noidung'] ?></td>
            <td><?= $bl['danhgia'] ?> ⭐</td>
            <td><?= $bl['ngaydang'] ?></td>
            <td>
                <a href="index.php?ctrl=binhluan&act=detail&id=<?= $bl['id'] ?>">Chi tiết</a> |
                <a href="index.php?ctrl=binhluan&act=delete&id=<?= $bl['id'] ?>" onclick="return confirm('Xoá?')">Xoá</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="index.php?ctrl=binhluan&act=list&page=<?= $i ?>&keyword=<?= $keyword ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
