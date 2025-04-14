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
                        <input type="file" class="form-control" name="hinhanh" id="previewInput" accept="image/*" required>
                        <img id="previewImage" src="#" alt="Ảnh sẽ hiển thị ở đây" style="display:none; margin-top:10px; max-height: 200px; border: 1px solid #ccc; padding: 5px;">
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

<script>
document.getElementById('previewInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewImage');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});
</script>
