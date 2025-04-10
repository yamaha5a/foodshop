<style>
    .detail-container {
        padding: 2rem;
        font-family: Arial, sans-serif;
    }

    .detail-card {
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .detail-table {
        width: 100%;
        min-width: 800px;
        border-collapse: collapse;
    }

    .detail-table th,
    .detail-table td {
        padding: 12px 16px;
        border: 1px solid #dee2e6;
        text-align: left;
        vertical-align: top;
    }

    .detail-table th {
        background-color: #f1f5f9;
        width: 200px;
        white-space: nowrap;
    }

    .detail-table td {
        word-break: break-word;
    }

    .back-btn {
        margin-top: 1rem;
    }
</style>

<div class="detail-container">
    <h2 class="text-center text-xl font-semibold mb-4">Chi tiết bình luận</h2>

    <div class="detail-card bg-white p-4">
        <table class="detail-table">
            <tbody>
                <tr>
                    <th scope="row">ID</th>
                    <td><?= $bl['id'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Người dùng</th>
                    <td><?= $bl['id_nguoidung'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Sản phẩm</th>
                    <td><?= $bl['id_sanpham'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Nội dung</th>
                    <td><?= $bl['noidung'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Đánh giá</th>
                    <td><?= $bl['danhgia'] ?>/5</td>
                </tr>
                <tr>
                    <th scope="row">Ngày đăng</th>
                    <td><?= $bl['ngaydang'] ?></td>
                </tr>
            </tbody>
        </table>

        <a href="index.php?act=binhluan&action=list" class="btn btn-secondary back-btn">← Quay lại danh sách</a>
    </div>
</div>
