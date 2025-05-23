<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Danh mục </h1>
    
    <div class="card table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="index.php?act=adddanhmuc" class="btn btn-primary">
        <i class="fas fa-folder-plus"></i> Thêm mới
    </a>
</div>


            <?php if (isset($thongbao)): ?> 
                <div class="alert alert-success" role="alert">
                    <?php echo $thongbao; ?>
                </div>
            <?php endif; ?>

            <table class="data-table">
                <thead>
                    <tr>
                        <th scope="col">Mã danh mục</th>
                        <th scope="col">Tên danh mục</th>
                        <th scope="col">Tùy chọn</th>
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
                
                    foreach ($listDM as $danhmuc) {
                        $id = $danhmuc['id']; 
                        $tendanhmuc = $danhmuc['tendanhmuc'];
                        $suaDM = "index.php?act=editdanhmuc&id=" . $id;
                        $xoaDM = "index.php?act=deletedanhmuc&id=" . $id;
                        
                        // Kiểm tra xem danh mục có sản phẩm không
                        $coSanPham = $this->danhMucModel->kiemTraDanhMucCoSanPham($id);
                    
                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>$tendanhmuc</td>";
                        echo "<td>
                                <a href='$suaDM' class='btn btn-sm btn-outline-info'>
                                    <i class='fas fa-edit'></i> Sửa
                                </a>";
                        
                        if ($coSanPham) {
                            echo "<button class='btn btn-sm btn-outline-danger' disabled title='Không thể xóa danh mục này vì đã có sản phẩm liên quan'>
                                    <i class='fas fa-trash-alt'></i> Xóa
                                </button>";
                        } else {
                            echo "<a href='$xoaDM' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa danh mục này?\")'>
                                    <i class='fas fa-trash-alt'></i> Xóa
                                </a>";
                        }
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                    
?>

            </tbody>

            </table>
        </div>
    </div>
</div>