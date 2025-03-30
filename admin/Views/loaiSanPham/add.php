<style>
    /* Định dạng tổng thể */
    .container-fluid {
        width: 100%;
        max-width: 100%;
        padding: 20px;
        background: #ffffff;
    }

    .card {
        width: 100%;
        max-width: 100%;
        padding: 10px 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        font-size: 40px;
        color: #333;
    }

    .dm {
        margin-bottom: 15px;
    }

    .dm p {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .dm input,
    .dm textarea,
    .dm select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: 0.3s;
    }

    .dm input:focus,
    .dm textarea:focus,
    .dm select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .dm textarea {
        height: 100px;
        resize: vertical;
    }

    .dm select {
        cursor: pointer;
    }

    .anh input {
        font-size: 16px;
    }

    .nut {
        text-align: center;
        margin-top: 20px;
    }

    .nut input {
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .nut input[type="submit"] {
        width: 100%;
        background: #007bff;
        color: white;
    }

    .nut input[type="submit"]:hover {
        background: rgb(4, 52, 101);
    }

    .alert {
        text-align: center;
        font-size: 16px;
        padding: 10px;
        border-radius: 5px;
    }

    .btn-outline {
        display: inline-block;
        padding: 8px 12px;
        font-size: 16px;
        border: 2px solid #007bff;
        border-radius: 5px;
        text-decoration: none;
        color: #007bff;
        transition: 0.3s;
    }

    .btn-outline:hover {
        background: rgb(4, 52, 101);
        color: white;
    }
</style>


<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thêm loại sản phẩm</h1>

    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="index.php?act=Loai_sanPham" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>Quay Lại
                </a>
            </div>

            <?php if (isset($thongbao)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $thongbao; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?act=addLoaiSP" method="POST" enctype="multipart/form-data">
                <div class="dm">
                    <p>Mã loại sản phẩm</p> <br>
                    <input type="text" name="malsp" required placeholder="Nhập tên sản phẩm" style="background: white;">
                    <?php if (isset($errors['malsp'])): ?>
                        <span class=" -danger"><?= $errors['malsp']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="dm">
                    <p>Tên loại</p> <br>
                    <input type="text" name="tenloai" required placeholder="Nhập tên sản phẩm" style="background: white;">
                </div>
                <div class="dm">
                    <p>Hình Ảnh </p> <br>
                    <input type="file" name="hinhanh" required>
                </div>
                <div class="dm">
                    <p>Mô tả </p> <br>
                    <textarea type="text" name="mota" required></textarea>
                </div>
                <div class="dm">
                    <p>Danh Mục </p> <br>
                    <select style="width: 30%; height: 50px;font-size: 20px;line-height: 40px;text-align: center;border-radius: 3px;" name="madm">
                        <option>Tất cả</option>
                        <?php
                        foreach ($listdanhmuc as $danhmuc) {
                            extract($danhmuc);
                            echo '<option value=' . $id . '>' . $tendanhmuc . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="nut">
                    <input type="submit" name="themmoi" value="Thêm mới">
                </div>
            </form>
        </div>
    </div>

</div>