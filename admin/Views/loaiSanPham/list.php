<main class="main-content">
    <div class="container-fluid">
        <div class="page-title">
            <h2 class="title">Loại sản Phẩm</h2>
            <a href="index.php?act=addLoaiSP" class="btn btn-primary">
                <i class="fas fa-folder-plus"></i> Thêm mới
            </a>
        </div>
        <div class="card table-card">
            <?php if (isset($thongbao)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $thongbao; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Mã loại sản phẩm</th>
                            <th scope="col">Tên Loại</th>
                            <th scope="col">hình ảnh</th>
                            <th scope="col">mô tả</th>
                            <th scope="col">mã danh mục</th>
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
                        foreach ($listSP as $list) :
                            extract($list);
                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $malsp ?></td>
                                <td><?= $tenloai ?></td>
                                <?php
                                $adress_hinh = "../upload/" . $hinhanh;
                                if (is_file($adress_hinh)) {
                                    $hinhanh = '<img src="' . $adress_hinh . '" width=58" />';
                                } else {
                                    $hinhanh = "No image!";
                                }
                                ?>
                                <td><?= $hinhanh ?></td>

                                <td><?= $mota ?></td>
                                <td><?= $madm ?></td>
                                <td>
                                    <a href="index.php?act=sualoaiSP&id=<?php echo $id; ?>" class="btn btn-warning">Sửa</a>
                                    <a href="index.php?act=deleteLoaisp&id=<?php echo $id; ?>" class="btn btn-danger">xóa</a>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>
            </form>
        </div>
    </div>
    </div>
</main>