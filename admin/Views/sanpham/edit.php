<?php
if (is_array($sanPham)) {
    extract($sanPham);
}

?>
<style>
   /* Định dạng tổng thể */
.container-fluid {
    width: 100%;
    max-width: 100%;
    margin: auto;
    padding: 30px;
    background: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
}

/* Định dạng tiêu đề */
h1 {
    text-align: center;
    font-size: 40px;
    color: #333;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Định dạng card */
.card {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Định dạng input, textarea, select */
form label {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
    color: #555;
}

form input,
form textarea,
form select {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
    background: #fff;
    margin-bottom: 15px;
}

form input:focus,
form textarea:focus,
form select:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
    outline: none;
}

/* Định dạng textarea */
form textarea {
    height: 120px;
    resize: vertical;
}

/* Định dạng select */
form select {
    cursor: pointer;
}

/* Định dạng nút */
.nut {
    text-align: center;
    margin-top: 20px;
}

form input[type="submit"] {
    width: 100%;
    padding: 12px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    background: #007bff;
    color: white;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
}

form input[type="submit"]:hover {
    background: #0056b3;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* Định dạng nút quay lại */
.btn-outline {
    display: inline-block;
    padding: 10px 15px;
    font-size: 16px;
    border: 2px solid #007bff;
    border-radius: 6px;
    text-decoration: none;
    color: #007bff;
    font-weight: 600;
    transition: all 0.3s ease-in-out;
}

.btn-outline:hover {
    background: #007bff;
    color: white;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
}

/* Định dạng thông báo */
.alert {
    text-align: center;
    font-size: 16px;
    padding: 12px;
    border-radius: 6px;
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

</style>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Cập nhập sản phẩm</h1>

    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="index.php?act=sanpham" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>Quay Lại
                </a>
            </div>

            <?php if (isset($thongbao)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $thongbao; ?>
                </div>
            <?php endif; ?>


            <form action="index.php?act=suaSanPham" method="POST" enctype="multipart/form-data">
                <label for="tensanpham">Tên sản phẩm:</label>
                <input type="text" name="tensanpham" id="tensanpham" required value="<?= $tensanpham ?>"><br>

                <label for="mota">Mô tả:</label>
                <textarea name="chitiet" id="chitiet" rows="4"><?= $mota ?></textarea><br>

                <label for="chitiet">Chi tiết sản phẩm:</label>
                <textarea name="mota" id="mota" rows="4"><?= $chitiet ?? '' ?></textarea><br>

                <label for="gia">Giá sản phẩm:</label>
                <input type="number" name="gia" id="gia" required value="<?= $gia ?>"><br>

                <label for="soluong">Số lượng:</label>
                <input type="number" name="soluong" id="soluong" required value="<?= $soluong ?>"><br>
                <label for="thoigiantao">Thời gian tạo:</label>
                <input type="date" name="thoigiantao" id="thoigiantao" required
                    value="<?= date('Y-m-d', strtotime($thoigiantao)) ?>"><br>

                <label for="id_danhmuc">Danh mục:</label>
                <select name="id_danhmuc" id="id_danhmuc">
                    <?php
                    foreach ($dsDanhmuc as $danhmuc) {
                        if ($id_danhmuc == $danhmuc['id']) $s = "selected";
                        else $s = "";
                        echo '<option value="' . $danhmuc['id'] . '" ' . $s . '>' . $danhmuc['tendanhmuc'] . '</option>';
                    }
                    ?>
                </select><br>
                <div>
                    <label for="hinhanh1">Hình ảnh 1:</label>
                    <input type="file" name="hinhanh1"><br>
                    <input type="hidden" name="hinhanh_cu1" value="<?= $hinhanh1 ?>">
                    <?php if (!empty($hinhanh1)): ?>
                        <br>
                        <img src="../upload/<?= $hinhanh1 ?>" alt="Hình ảnh hiện tại" width="200">
                    <?php endif; ?>
                </div>
                <div>
                    <label for="hinhanh2">Hình ảnh 2:</label>
                    <input type="file" name="hinhanh2"><br>
                    <input type="hidden" name="hinhanh_cu2" value="<?= $hinhanh2 ?>">
                    <?php if (!empty($hinhanh2)): ?>
                        <br>
                        <img src="../upload/<?= $hinhanh2 ?>" alt="Hình ảnh hiện tại" width="200">
                    <?php endif; ?>
                </div>
                <div>
                    <label for="hinhanh3">Hình ảnh 3:</label>
                    <input type="file" name="hinhanh3"><br>
                    <input type="hidden" name="hinhanh_cu3" value="<?= $hinhanh3 ?>">
                    <?php if (!empty($hinhanh3)): ?>
                        <br>
                        <img src="../upload/<?= $hinhanh3 ?>" alt="Hình ảnh hiện tại" width="200">
                    <?php endif; ?>
                </div>

                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" name="capnhap" value="Cập nhập">
            </form>
        </div>
    </div>

</div>