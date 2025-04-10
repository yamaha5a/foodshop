<style>
    .ptt-container {
        padding: 2rem;
        font-family: Arial, sans-serif;
    }

    .ptt-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .ptt-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
    }

    .ptt-header a {
        padding: 0.5rem 1rem;
        background-color: #1d4ed8;
        color: #fff;
        text-decoration: none;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
    }

    .ptt-header a:hover {
        background-color: #2563eb;
    }

    .ptt-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .ptt-table th,
    .ptt-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    .ptt-table th {
        background-color: #f1f5f9;
        font-weight: 600;
    }

    .ptt-table tr:last-child td {
        border-bottom: none;
    }

    .ptt-actions a {
        margin-right: 0.5rem;
        color: #2563eb;
        text-decoration: none;
    }

    .ptt-actions a:hover {
        text-decoration: underline;
    }

    .ptt-empty {
        text-align: center;
        padding: 1rem;
        font-style: italic;
    }
</style>

<div class="ptt-container">
    <div class="ptt-header">
        <h2>Danh sách phương thức thanh toán</h2>
        <a href="index.php?act=phuongthucthanhtoan&action=add">Thêm mới</a>
    </div>

    <table class="ptt-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên phương thức</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($list) && is_array($list)) : ?>
                <?php foreach ($list as $pt) : ?>
                    <tr>
                        <td><?= $pt['id'] ?></td>
                        <td><?= $pt['tenphuongthuc'] ?></td>
                        <td class="ptt-actions">
                            <a href="index.php?act=phuongthucthanhtoan&action=edit&id=<?= $pt['id'] ?>">Sửa</a>
                            <a href="index.php?act=phuongthucthanhtoan&action=delete&id=<?= $pt['id'] ?>" onclick="return confirm('Xác nhận xoá?')">Xoá</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3" class="ptt-empty">Không có phương thức thanh toán nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
