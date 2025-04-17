<?php
require_once "connection.php";

class BieuDo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lấy dữ liệu doanh thu theo tháng trong 12 tháng gần nhất
     * @return array Mảng chứa dữ liệu doanh thu theo tháng
     */
    public function getDoanhThuTheoThang() {
        $sql = "SELECT 
                    DATE_FORMAT(ngaytao, '%Y-%m') as thang,
                    SUM(tongtien) as tongdoanhthu
                FROM hoadon 
                WHERE trangthai = 'Đã giao'
                AND ngaytao >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                GROUP BY DATE_FORMAT(ngaytao, '%Y-%m')
                ORDER BY thang ASC";
        
        $result = pdo_query($sql);
        
        // Tạo mảng kết quả với đầy đủ 12 tháng
        $doanhThuTheoThang = [];
        
        // Lấy tháng hiện tại
        $currentMonth = date('Y-m');
        
        // Tạo dữ liệu cho 12 tháng gần nhất
        for ($i = 11; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $doanhThuTheoThang[$month] = 0; // Mặc định là 0
        }
        
        // Cập nhật dữ liệu thực tế
        foreach ($result as $row) {
            $doanhThuTheoThang[$row['thang']] = (float)$row['tongdoanhthu'];
        }
        
        // Chuyển đổi thành định dạng phù hợp cho biểu đồ
        $labels = [];
        $data = [];
        
        foreach ($doanhThuTheoThang as $thang => $doanhthu) {
            $labels[] = date('m/Y', strtotime($thang . '-01'));
            $data[] = $doanhthu;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
?> 