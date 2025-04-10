<style>
    .binhluan-admin-wrapper {
        max-width: 100%;
        margin: 30px auto;
        font-family: Arial, sans-serif;
    }

    .binhluan-admin-wrapper h2 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .binhluan-admin-wrapper .search-form {
        text-align: right;
        margin-bottom: 15px;
    }

    .binhluan-admin-wrapper .search-form input[type="text"] {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .binhluan-admin-wrapper .search-form button {
        padding: 8px 16px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        margin-left: 5px;
        cursor: pointer;
    }

    .binhluan-admin-wrapper .search-form button:hover {
        background-color: #0056b3;
    }

    .binhluan-admin-wrapper table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .binhluan-admin-wrapper th,
    .binhluan-admin-wrapper td {
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .binhluan-admin-wrapper th {
        background-color: #333;
        color: white;
    }

    .binhluan-admin-wrapper tr:hover {
        background-color: #f5f5f5;
    }

    .binhluan-admin-wrapper .stars {
        color: #ccc;
    }

    .binhluan-admin-wrapper .stars .filled {
        color: gold;
    }

    .binhluan-admin-wrapper .action-buttons a {
        display: inline-block;
        margin-right: 5px;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
    }

    .binhluan-admin-wrapper .detail-btn {
        background-color: #28a745;
    }

    .binhluan-admin-wrapper .detail-btn:hover {
        background-color: #218838;
    }

    .binhluan-admin-wrapper .delete-btn {
        background-color: #dc3545;
    }

    .binhluan-admin-wrapper .delete-btn:hover {
        background-color: #c82333;
    }

    .binhluan-admin-wrapper .no-data {
        text-align: center;
        color: #777;
        padding: 20px;
    }
</style>

<div class="binhluan-admin-wrapper">
    <h2>Danh sách bình luận</h2>

    <form method="GET" action="" class="search-form">
        <input type="hidden" name="act" value="binhluan">
        <input type="text" name="keyword" placeholder="Tìm nội dung..." value="<?= $keyword ?? '' ?>">
        <button type="submit">Tìm</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Người Dùng</th>
                <th>ID Sản Phẩm</th>
                <th>Nội dung</th>
                <th>Đánh giá</th>
                <th>Ngày đăng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dsbl)) : ?>
                <?php foreach ($dsbl as $bl) : ?>
                    <tr>
                        <td><?= $bl['id'] ?></td>
                        <td><?= $bl['id_nguoidung'] ?></td>
                        <td><?= $bl['id_sanpham'] ?></td>
                        <td><?= htmlspecialchars($bl['noidung']) ?></td>
                        <td>
                            <span class="stars">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="<?= $i <= $bl['danhgia'] ? 'filled' : '' ?>">★</span>
                                <?php endfor; ?>
                            </span>
                        </td>
                        <td><?= $bl['ngaydang'] ?></td>
                        <td class="action-buttons">
                            <a href="index.php?act=binhluan&action=detail&id=<?= $bl['id'] ?>" class="detail-btn">Chi Tiết</a>
                            <a href="index.php?act=binhluan&action=delete&id=<?= $bl['id'] ?>" class="delete-btn" onclick="return confirm('Xoá bình luận này?')">Xoá</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="no-data">Không có bình luận nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
