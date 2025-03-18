<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thêm danh mục</h1>

    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="index.php?act=danhmuc" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <?php if (isset($thongbao)): ?> 
                <div class="alert alert-success" role="alert">
                    <?php echo $thongbao; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?act=addDM" method="POST">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="tenDM" placeholder="Nhập tên danh mục" required>
                            </td>
                            <td>
                                <button type="submit" name="themmoi" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm mới
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
