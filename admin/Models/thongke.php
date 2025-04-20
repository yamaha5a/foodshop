<?php
require_once "connection.php";

class ThongKe {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function demTongTaiKhoan() {
        $sql = "SELECT COUNT(*) AS total_users FROM nguoidung";
        $result = pdo_query_one($sql);
        return $result['total_users'];
    }

    public function demTongDonHang() {
        $sql = "SELECT COUNT(*) AS total_orders FROM hoadon";
        $result = pdo_query_one($sql);
        return $result['total_orders'];
    }
    
    public function tinhTongDoanhThu() {
        $sql = "SELECT SUM(tongtien) AS total_revenue FROM hoadon WHERE trangthai = 'Khách hàng đã nhận'";
        $result = pdo_query_one($sql);
        return $result['total_revenue'] ?? 0;
    }
    
    public function getDonHangMoiNhat() {
        $sql = "SELECT hd.*, nd.ten as ten_nguoidung, ptt.tenphuongthuc 
                FROM hoadon hd 
                JOIN nguoidung nd ON hd.id_nguoidung = nd.id 
                LEFT JOIN phuongthucthanhtoan ptt ON hd.id_phuongthucthanhtoan = ptt.id 
                ORDER BY hd.ngaytao DESC 
                LIMIT 5";
        return pdo_query($sql);
    }
    
    public function demTongSanPham() {
        $sql = "SELECT COUNT(*) AS total_products FROM sanpham";
        $result = pdo_query_one($sql);
        return $result['total_products'];
    }
}
?>
