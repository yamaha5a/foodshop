<?php
function loadall_sanPham($kyw, $iddm = 0,$page = 1, $limit = 5)
{
    $offset = ($page - 1) * $limit; // Tính vị trí bắt đầu lấy dữ liệu
    $sql = "SELECT 
                sp.id, 
                sp.tensanpham AS ten_san_pham, 
                sp.mota AS mo_ta, 
                sp.gia, 
                sp.soluong AS so_luong, 
                sp.hinhanh1,
                sp.hinhanh2,
                sp.hinhanh3,
                sp.thoigiantao AS thoi_gian_tao, 
                dm.tendanhmuc AS ten_danh_muc, 
                lsp.malsp AS ma_loai_san_pham, 
                sp.trangthai AS trang_thai
            FROM sanpham AS sp
            JOIN danhmuc AS dm ON sp.id_danhmuc = dm.id
            JOIN loaisanpham AS lsp ON sp.id_loaisanpham = lsp.id";
    if ($kyw != "") {
        $sql .= " where sp.tensanpham like '%$kyw%'";
    }
    if ($iddm > 0) {
        $sql.= " AND sp.id_danhmuc = '$iddm'";
    }
    $sql .= " ORDER BY sp.id DESC LIMIT  $limit OFFSET $offset";

    $listSanPham = pdo_query($sql);
    return $listSanPham;
}
function get_total_pages($kyw, $iddm, $limit)
{
    $sql = "SELECT COUNT(*) as total FROM sanpham AS sp";

    // Thêm điều kiện JOIN danh mục nếu có lọc danh mục
    if ($iddm > 0) {
        $sql .= " JOIN danhmuc AS dm ON sp.id_danhmuc = dm.id";
    }

    $sql .= " WHERE 1"; // Điều kiện mặc định tránh lỗi SQL

    // Nếu có từ khóa tìm kiếm
    if ($kyw != "") {
        $sql .= " AND sp.tensanpham LIKE '%$kyw%'";
    }

    // Nếu có lọc theo danh mục
    if ($iddm > 0) {
        $sql .= " AND sp.id_danhmuc = '$iddm'";
    }

    $result = pdo_query_one($sql); // Lấy kết quả COUNT
    $total_records = $result['total']; // Tổng số sản phẩm

    return ceil($total_records / $limit); // Số trang cần hiển thị
}

function insert_sanpham($tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $thoigiantao)
{
    $trangthai = ($soluong > 0) ? 'Còn hàng' : 'Hết hàng';

    $sql = "INSERT INTO sanpham (tensanpham, mota, gia, soluong, hinhanh1, hinhanh2, hinhanh3, id_danhmuc, id_loaisanpham, trangthai, thoigiantao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    pdo_execute($sql, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $trangthai, $thoigiantao);
}
function deleteSanPham($id)
{
    $sql = "DELETE FROM sanpham WHERE id='$id'";
    pdo_execute($sql);
}
function suaSanPham($id)
{
    $sql = "SELECT * FROM sanpham WHERE id='$id'";
    return pdo_query_one($sql);
}
function update_sanPham($tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $thoigiantao, $id)
{
    $trangthai = ($soluong > 0) ? 'Còn hàng' : 'Hết hàng';
    $sql = "UPDATE sanpham SET tensanpham=?, mota=?, gia=?, soluong=?, hinhanh1=?, hinhanh2=?, hinhanh3=?, id_danhmuc=?, id_loaisanpham=?, trangthai=?, thoigiantao=? WHERE id=?";
    pdo_execute($sql, $tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $trangthai, $thoigiantao, $id);
}
