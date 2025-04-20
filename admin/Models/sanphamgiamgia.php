<?php
require_once 'connection.php';

class SanPhamGiamGiaModel {
    public function getAllSanPhamGiamGia($page = 1, $limit = 10, $kyw = '') {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT spg.*, sp.tensanpham, sp.gia as gia_goc, sp.hinhanh1 
                FROM sanphamgiamgia spg 
                JOIN sanpham sp ON spg.id_sanpham = sp.id 
                WHERE 1";
        
        $params = [];
        
        if (!empty($kyw)) {
            $sql .= " AND sp.tensanpham LIKE ?";
            $params[] = "%$kyw%";
        }
        
        $sql .= " ORDER BY spg.ngay_giamgia DESC LIMIT ? OFFSET ?";
        $params[] = (int)$limit;
        $params[] = (int)$offset;
                
        return pdo_query($sql, ...$params);
    }

    public function getTotalSanPhamGiamGia($kyw = '') {
        $sql = "SELECT COUNT(*) as total 
                FROM sanphamgiamgia spg 
                JOIN sanpham sp ON spg.id_sanpham = sp.id 
                WHERE 1";
        
        $params = [];
        
        if (!empty($kyw)) {
            $sql .= " AND sp.tensanpham LIKE ?";
            $params[] = "%$kyw%";
        }
        
        $result = pdo_query_one($sql, ...$params);
        return $result['total'];
    }

    public function getSanPhamGiamGiaById($id) {
        $sql = "SELECT spg.*, sp.tensanpham, sp.gia as gia_goc 
                FROM sanphamgiamgia spg 
                JOIN sanpham sp ON spg.id_sanpham = sp.id 
                WHERE spg.id = ?";
        $result = pdo_query($sql, $id);
        return $result ? $result[0] : null;
    }

    public function addSanPhamGiamGia($id_sanpham, $giagiam, $ngay_giamgia) {
        $sql = "INSERT INTO sanphamgiamgia (id_sanpham, giagiam, ngay_giamgia) VALUES (?, ?, ?)";
        return pdo_execute($sql, $id_sanpham, $giagiam, $ngay_giamgia);
    }

    public function updateSanPhamGiamGia($id, $id_sanpham, $giagiam, $ngay_giamgia) {
        // Kiểm tra xem sản phẩm có đơn hàng đang xử lý không
        if ($this->kiemTraSanPhamGiamGiaCoDonHang($id)) {
            return false;
        }
        
        $sql = "UPDATE sanphamgiamgia SET id_sanpham = ?, giagiam = ?, ngay_giamgia = ? WHERE id = ?";
        return pdo_execute($sql, $id_sanpham, $giagiam, $ngay_giamgia, $id);
    }

    public function deleteSanPhamGiamGia($id) {
        // Kiểm tra xem sản phẩm giảm giá có đơn hàng đang hoạt động không
        if ($this->kiemTraSanPhamGiamGiaCoDonHang($id)) {
            return false;
        }
        $sql = "DELETE FROM sanphamgiamgia WHERE id = ?";
        return pdo_execute($sql, $id);
    }
    
    public function kiemTraSanPhamGiamGiaCoDonHang($id) {
        // Lấy id_sanpham từ bảng sanphamgiamgia
        $sql_get_product = "SELECT id_sanpham FROM sanphamgiamgia WHERE id = ?";
        $result = pdo_query_one($sql_get_product, $id);
        
        if (!$result) {
            return false;
        }
        
        $id_sanpham = $result['id_sanpham'];
        
        // Kiểm tra xem sản phẩm có đơn hàng đang hoạt động không
        $sql = "SELECT COUNT(*) as count 
                FROM chitiethoadon cth 
                JOIN hoadon hd ON cth.id_hoadon = hd.id 
                WHERE cth.id_sanpham = ? 
                AND hd.trangthai NOT IN ('Khách hàng đã nhận', 'Đã giao', 'Đã hủy')";
        $result = pdo_query_one($sql, $id_sanpham);
        return $result['count'] > 0;
    }
    
    public function getAllSanPham() {
        $sql = "SELECT id, tensanpham, gia, hinhanh1, mota FROM sanpham ORDER BY tensanpham ASC";
        return pdo_query($sql);
    }
}