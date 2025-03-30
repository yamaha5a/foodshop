<style>
    .search-box {
        display: flex;
        gap: 10px;
        background: #f8f9fa;
        padding: 12px;
        border-radius: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        /* Thu nhỏ kích thước */
        margin-left: auto;
        margin: 10px;
        /* Đẩy sang bên phải */
    }


    .search-input,
    .search-select {
        padding: 1px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 16px;
        flex: 1;
    }

    .search-button {
        background: #007bff;
        color: white;
        padding: 7px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
    }

    .search-button:hover {
        background: #0056b3;
    }

    @media (max-width: 200px) {
        .search-box {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
<main class="main-content">

    <div class="container-fluid">
        <div class="page-title">
            <h2 class="title">Sản Phẩm</h2>
            <a href="index.php?act=addSanPham" class="btn btn-primary">
                <i class="fas fa-folder-plus"></i> Thêm mới
            </a>
        </div>
        <form action="index.php?act=sanpham" method="post" enctype="multipart/form-data">
            <div class="search-box">

                <input type="text" name="kyw" placeholder="Tìm Kiếm Tên Sản Phẩm ..." class="search-input">
                <select name="iddm" class="search-select">
                    <option value="0" selected>Tất cả</option>
                    <?php
                    foreach ($listdanhmuc as $danhmuc) {
                        extract($danhmuc);
                        echo '<option value="' . $id . '">' . $tendanhmuc . '</option>';
                    }
                    ?>
                </select>
                <input type="submit" name="listok" value="OK" class="search-button">
            </div>

        </form>
        <?php if (isset($thongbao)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $thongbao; ?>
            </div>
        <?php endif; ?>
        <div class="card-title">
            <form action="" method="post" enctype="multipart/form-data">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Hình ảnh 1</th>
                            <th scope="col">Hình ảnh 2</th>
                            <th scope="col">Hình ảnh 3</th>
                            <th scope="col">Thời gian tạo</th>
                            <th scope="col">Danh Mục</th>
                            <th scope="col">Loại sản phẩm</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($_SESSION['thongbao'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?php
                                echo $_SESSION['thongbao'];
                                unset($_SESSION['thongbao']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        foreach ($listSanPham as $list) :
                            extract($list);
                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $list['ten_san_pham'] ?></td>
                                <td><?= $list['mo_ta'] ?></td>
                                <td><?= number_format($gia, 0, ',', '.') ?> đ</td>
                                <td><?= $list['so_luong'] ?></td>
                                <?php
                                $adress_hinh1 = "../upload/" . $hinhanh1;
                                $adress_hinh2 = "../upload/" . $hinhanh2;
                                $adress_hinh3 = "../upload/" . $hinhanh3;

                                if (is_file($adress_hinh1)) {
                                    $hinhanh1 = '<img src="' . $adress_hinh1 . '" width=58" />';
                                } else {
                                    $hinhanh1 = "No image!";
                                }
                                if (is_file($adress_hinh2)) {
                                    $hinhanh2 = '<img src="' . $adress_hinh2 . '" width=58" />';
                                } else {
                                    $hinhanh2 = "No image!";
                                }
                                if (is_file($adress_hinh3)) {
                                    $hinhanh3 = '<img src="' . $adress_hinh3 . '" width=58" />';
                                } else {
                                    $hinhanh3 = "No image!";
                                }
                                ?>
                                <td><?= $hinhanh1 ?></td>
                                <td><?= $hinhanh2 ?></td>
                                <td><?= $hinhanh3 ?></td>

                                <td><?= date("d-m-Y", strtotime($thoi_gian_tao)) ?></td>
                                <td><?= $ten_danh_muc ?></td>
                                <td><?= $ma_loai_san_pham ?></td>
                                <td>
                                    <?= ($list['trang_thai'] == 'Còn hàng') ? '<span style="color: green;">Còn hàng</span>' : '<span style="color: red;">Hết hàng</span>' ?>
                                </td>
                                <td>
                                    <a href="index.php?act=suaSanPham&id=<?= $id ?>" class="btn btn-warning">Sửa</a>
                                    <a href="index.php?act=xoaSanPham&id=<?= $id ?>" class="btn btn-danger">xóa</a>
                            </tr>
                        <?php endforeach; ?>


        </div>
        </tbody>

        </table>
        <center>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?act=sanpham&page=<?= $page - 1 ?>&kyw=<?= urlencode($kyw) ?>&iddm=<?= $iddm ?>" class="btn btn-light">
                        Trang trước
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?act=sanpham&page=<?= $i ?>&kyw=<?= urlencode($kyw) ?>&iddm=<?= $iddm ?>"
                        class="btn <?= ($i == $page) ? 'btn-primary' : 'btn-light' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?act=sanpham&page=<?= $page + 1 ?>&kyw=<?= urlencode($kyw) ?>&iddm=<?= $iddm ?>" class="btn btn-light">
                        Trang sau
                    </a>
                <?php endif; ?>
            </div>
        </center>
        </form>
    </div>
    </div>
    </div>

</main>