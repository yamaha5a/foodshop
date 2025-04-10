<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thêm Banner</h1>
    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="index.php?act=banner" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
            <form action="index.php?act=addbanner" method="POST" enctype="multipart/form-data">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="file" class="form-control" name="hinhanh" required>
                            </td>
                            <td>
                                <button type="submit" name="thembanner" class="btn btn-primary">
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
