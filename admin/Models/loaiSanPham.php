<?php 
function loadall_loaiSP(){
    $sql = "select
    loaiDM.*, loaiDM.madm from loaisanpham as loaiDM
     inner join danhmuc as dm on dm.id=loaiDM.madm ";
     $listLoaiDM = pdo_query($sql);
     return $listLoaiDM;
}
function insert_loaisanpham($malsp, $tenloai,$hinhanh ,$mota, $madm)
{
    $sql = "insert into loaisanpham(malsp,tenloai,hinhanh,mota,madm) values('$malsp','$tenloai','$hinhanh','$mota','$madm')";
    pdo_execute($sql);
}
function delete_loaisanpham($id){
    $sql = "delete from loaisanpham where id='$id'";
    pdo_execute($sql);
}
function suaLoaiSP($id){
    $sql = "select * from loaisanpham where id='$id'";
    return pdo_query_one($sql);
}

function update_loaisanpham($id,$malsp, $tenloai,$hinhanh ,$mota, $madm){
    $sql = "update loaisanpham set malsp='$malsp',tenloai='$tenloai',hinhanh='$hinhanh',mota='$mota',madm='$madm' where id='$id'";
    pdo_execute($sql);
}