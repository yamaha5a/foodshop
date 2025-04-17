<?php
require_once 'connection.php';

class SanPham
{
    private $conn;

    public function __construct()
    {
        $this->conn = pdo_get_connection();
    }

    public function get8sp()
    {
        $stmt = $this->conn->prepare("
            SELECT sp.* 
            FROM sanpham sp 
            WHERE sp.trangthai = 'Còn hàng' 
            AND sp.id NOT IN (SELECT id_sanpham FROM sanphamgiamgia)
            ORDER BY sp.id DESC 
            LIMIT 8
        ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll()
    {
        $stmt = $this->conn->prepare("
            SELECT sp.* 
            FROM sanpham sp 
            WHERE sp.trangthai = 'Còn hàng'
            AND sp.id NOT IN (SELECT id_sanpham FROM sanphamgiamgia)
        ");

        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  // Lấy sản phẩm theo phân trang
public function getSanPhamByPage($start, $limit)
{
    $stmt = $this->conn->prepare("
        SELECT sp.* 
        FROM sanpham sp 
        WHERE sp.trangthai = 'Còn hàng' 
        AND sp.id NOT IN (SELECT id_sanpham FROM sanphamgiamgia)
        ORDER BY sp.id DESC 
        LIMIT :start, :limit
    ");
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Đếm tổng số sản phẩm
public function countAllSanPham()
{
    $stmt = $this->conn->prepare("
        SELECT COUNT(*) 
        FROM sanpham sp 
        WHERE sp.trangthai = 'Còn hàng'
        AND sp.id NOT IN (SELECT id_sanpham FROM sanphamgiamgia)
    ");
    $stmt->execute();
    return $stmt->fetchColumn();
}
public function getSanPhamByDanhMuc($idDanhMuc, $start, $limit)
{
    $stmt = $this->conn->prepare("
        SELECT sp.* 
        FROM sanpham sp 
        WHERE sp.trangthai = 'Còn hàng' 
        AND sp.id_danhmuc = :id_danhmuc
        AND sp.id NOT IN (SELECT id_sanpham FROM sanphamgiamgia)
        ORDER BY sp.id DESC 
        LIMIT :start, :limit
    ");
    $stmt->bindValue(':id_danhmuc', (int)$idDanhMuc, PDO::PARAM_INT);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countSanPhamByDanhMuc($idDanhMuc)
{
    $stmt = $this->conn->prepare("
        SELECT COUNT(*) 
        FROM sanpham sp 
        WHERE sp.trangthai = 'Còn hàng' 
        AND sp.id_danhmuc = :id_danhmuc
        AND sp.id NOT IN (SELECT id_sanpham FROM sanphamgiamgia)
    ");
    $stmt->bindValue(':id_danhmuc', (int)$idDanhMuc, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

public function searchSanPham($keyword, $start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' AND (tensanpham LIKE :keyword OR mota LIKE :keyword) ORDER BY id DESC LIMIT :start, :limit");
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countSearchSanPham($keyword)
{
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM sanpham WHERE trangthai = 'Còn hàng' AND (tensanpham LIKE :keyword OR mota LIKE :keyword)");
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
}

public function filterByPrice($minPrice, $maxPrice, $start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' AND gia >= :minPrice AND gia <= :maxPrice ORDER BY id DESC LIMIT :start, :limit");
    $stmt->bindValue(':minPrice', (float)$minPrice, PDO::PARAM_STR);
    $stmt->bindValue(':maxPrice', (float)$maxPrice, PDO::PARAM_STR);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countFilterByPrice($minPrice, $maxPrice)
{
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM sanpham WHERE trangthai = 'Còn hàng' AND gia >= :minPrice AND gia <= :maxPrice");
    $stmt->bindValue(':minPrice', (float)$minPrice, PDO::PARAM_STR);
    $stmt->bindValue(':maxPrice', (float)$maxPrice, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
}

public function searchAndFilterByPrice($keyword, $minPrice, $maxPrice, $start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' AND (tensanpham LIKE :keyword OR mota LIKE :keyword) AND gia >= :minPrice AND gia <= :maxPrice ORDER BY id DESC LIMIT :start, :limit");
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue(':minPrice', (float)$minPrice, PDO::PARAM_STR);
    $stmt->bindValue(':maxPrice', (float)$maxPrice, PDO::PARAM_STR);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countSearchAndFilterByPrice($keyword, $minPrice, $maxPrice)
{
    $stmt = $this->conn->prepare("SELECT COUNT(*) FROM sanpham WHERE trangthai = 'Còn hàng' AND (tensanpham LIKE :keyword OR mota LIKE :keyword) AND gia >= :minPrice AND gia <= :maxPrice");
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue(':minPrice', (float)$minPrice, PDO::PARAM_STR);
    $stmt->bindValue(':maxPrice', (float)$maxPrice, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Thêm phương thức sắp xếp sản phẩm theo giá tăng dần
public function getSanPhamByPriceAsc($start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' ORDER BY gia ASC LIMIT :start, :limit");
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Thêm phương thức sắp xếp sản phẩm theo giá giảm dần
public function getSanPhamByPriceDesc($start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' ORDER BY gia DESC LIMIT :start, :limit");
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Thêm phương thức sắp xếp sản phẩm theo danh mục và giá tăng dần
public function getSanPhamByDanhMucAndPriceAsc($idDanhMuc, $start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' AND id_danhmuc = :id_danhmuc ORDER BY gia ASC LIMIT :start, :limit");
    $stmt->bindValue(':id_danhmuc', (int)$idDanhMuc, PDO::PARAM_INT);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Thêm phương thức sắp xếp sản phẩm theo danh mục và giá giảm dần
public function getSanPhamByDanhMucAndPriceDesc($idDanhMuc, $start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' AND id_danhmuc = :id_danhmuc ORDER BY gia DESC LIMIT :start, :limit");
    $stmt->bindValue(':id_danhmuc', (int)$idDanhMuc, PDO::PARAM_INT);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Thêm phương thức sắp xếp sản phẩm theo tìm kiếm và giá tăng dần
public function searchSanPhamByPriceAsc($keyword, $start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' AND (tensanpham LIKE :keyword OR mota LIKE :keyword) ORDER BY gia ASC LIMIT :start, :limit");
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Thêm phương thức sắp xếp sản phẩm theo tìm kiếm và giá giảm dần
public function searchSanPhamByPriceDesc($keyword, $start, $limit)
{
    $stmt = $this->conn->prepare("SELECT * FROM sanpham WHERE trangthai = 'Còn hàng' AND (tensanpham LIKE :keyword OR mota LIKE :keyword) ORDER BY gia DESC LIMIT :start, :limit");
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
