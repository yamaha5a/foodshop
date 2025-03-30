<style>
    /* Định dạng tổng thể */
    .container-fluid {
        width: 100%;
        max-width: 100%;
        padding: 20px;
        background: #ffffff;
    }

    /* Card chứa form */
    .card {
        width: 100%;
        max-width: 100%;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(99, 175, 76, 0.5);
    }

    /* Form input */
    .dm input,
    .dm textarea,
    .dm select {
        width: 100%;
        max-width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    /* Nút bấm */
    .nut {
        display: flex;
        gap: 10px;
    }

    /* Hình ảnh */
    .anh img {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    /* Tiêu đề */
    h1 {
        font-size: 40px;
        font-weight: bold;
        text-align: center;
        color: #333;
    }

    /* Các nhãn trong form */
    .dm p {
        font-size: 25px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    /* Các input và textarea */
    .dm input,
    .dm textarea,
    .dm select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 20px;
        transition: all 0.3s ease-in-out;
    }

    /* Hiệu ứng hover và focus */
    .dm input:focus,
    .dm textarea:focus,
    .dm select:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        outline: none;
    }

    /* Nút bấm */
    .nut input {
        padding: 12px 20px;
        border-radius: 5px;
        border: none;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .nut input[type="submit"] {
        width: 100%;
        color: #fff;
        background: #007bff;
    }

    .nut input[type="submit"]:hover {
        background: rgb(4, 52, 101);
    }

    .nut input[type="button"] {
        color: #fff;
        background: #dc3545;
    }

    .nut input[type="button"]:hover {
        background: #c82333;
    }

    .btn-outline:hover {
        background: rgb(4, 52, 101);
        color: white;
    }

    /* Hình ảnh */
    .anh img {
        margin-top: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>
<?php
 if (is_array($loaiSP)) {
    extract($loaiSP);
 }

?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Cập nhập loại sản phẩm</h1>

    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="index.php?act=Loai_sanPham" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <?php if (isset($thongbao)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $thongbao; ?>
                </div>
            <?php endif; ?>
            <br>
            <form action="index.php?act=updateLoaiSP" method="POST" enctype="multipart/form-data">
                <div class="dm">
                    <p>Mã loại sản phẩm</p> <br>
                    <input type="text" name="malsp" required placeholder="Nhập tên sản phẩm" style="background: white;" value="<?= $malsp ?>">
                </div><br>
                <div class="dm">
                    <p>Tên loại</p> <br>
                    <input type="text" name="tenloai" required placeholder="Nhập tên sản phẩm" style="background: white;" value="<?= $tenloai ?>">
                </div><br>
                <div class="dm">
                    <p>Hình Ảnh </p> <br>
                    <input type="file" name="hinhanh">
                    <input type="hidden" name="hinhanh_cu" value="<?= $hinhanh ?>">
                    <?php if (!empty($hinhanh)): ?>
                        <br>
                        <img src="../upload/<?= $hinhanh ?>" alt="Hình ảnh hiện tại" width="200">
                    <?php endif; ?>
                </div><br>
                <div class="dm">
                    <p>Mô tả </p> <br>
                    <textarea type="text" name="mota" required><?= $mota ?></textarea>
                </div><br>
                <div class="dm">
                    <p>Danh Mục </p> <br>
                    <select style="width: 30%; height: 50px;font-size: 20px;line-height: 40px;text-align: center;border-radius: 3px;" name="madm">
                        <?php
                        foreach ($listdanhmuc as $danhmuc) {
                            if ($madm == $danhmuc['id']) $s = "selected";
                            else $s = "";
                            echo '<option value="' . $danhmuc['id'] . '" ' . $s . '>' . $danhmuc['tendanhmuc'] . '</option>';
                        }
                        ?>
                    </select>
                </div> <br>
                <div class="nut">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="submit" name="capnhap" value="Cập nhập">
                </div>
            </form>
        </div>
    </div>
</div>