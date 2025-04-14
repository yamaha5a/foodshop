CREATE DATABASE shopfood;
USE shopfood;

-- 1. Bảng phân quyền
CREATE TABLE phanquyen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tenquyen VARCHAR(50) NOT NULL,
    chitietquyen TEXT
) ENGINE=InnoDB;

-- 2. Bảng người dùng
CREATE TABLE nguoidung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL,

    email VARCHAR(100) UNIQUE NOT NULL, 
    matkhau VARCHAR(255) NOT NULL, -- Sẽ lưu mật khẩu đã mã hóa
    sodienthoai VARCHAR(15),
    diachi TEXT,
    hinhanh VARCHAR(255), -- Thêm hình ảnh đại diện
    gioitinh ENUM('Nam', 'Nữ', 'Khác') NOT NULL,
    trangthai ENUM('Hoạt động', 'Bị khóa') DEFAULT 'Hoạt động', -- Chuyển BOOLEAN thành ENUM
    id_phanquyen INT,
    FOREIGN KEY (id_phanquyen) REFERENCES phanquyen(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 3. Bảng danh mục sản phẩm
CREATE TABLE danhmuc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tendanhmuc VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- 4. Bảng loại sản phẩm
CREATE TABLE loaisanpham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    malsp VARCHAR(50) NOT NULL UNIQUE,
    tenloai VARCHAR(100) NOT NULL,
    hinhanh VARCHAR(255),
    mota TEXT,
    madm INT,
    FOREIGN KEY (madm) REFERENCES danhmuc(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Bảng sản phẩm
CREATE TABLE sanpham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tensanpham VARCHAR(100) NOT NULL,
    mota TEXT,
    gia DECIMAL(10,2) NOT NULL,
    soluong INT NOT NULL,
    hinhanh1 VARCHAR(255),
    hinhanh2 VARCHAR(255),
    hinhanh3 VARCHAR(255),
    thoigiantao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_danhmuc INT,
    id_loaisanpham INT,
    trangthai ENUM('Còn hàng', 'Hết hàng') DEFAULT 'Còn hàng',
    FOREIGN KEY (id_danhmuc) REFERENCES danhmuc(id) ON DELETE CASCADE,
    FOREIGN KEY (id_loaisanpham) REFERENCES loaisanpham(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Bảng topping
CREATE TABLE topping (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tentopping VARCHAR(100) NOT NULL,
    gia DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB;

-- 7. Bảng sản phẩm - topping
CREATE TABLE sanpham_topping (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sanpham INT,
    id_topping INT,
    gia_topping DECIMAL(10,2) NOT NULL DEFAULT 0, -- Thêm cột giá topping
    FOREIGN KEY (id_sanpham) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (id_topping) REFERENCES topping(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 8. Bảng khuyến mãi
CREATE TABLE khuyenmai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tenkhuyenmai VARCHAR(100) NOT NULL,
    giatrigiam DECIMAL(10,2),
    ngaybatdau DATE,
    ngayketthuc DATE,
    trangthai ENUM('Hoạt động', 'Hết hạn') DEFAULT 'Hoạt động' -- Thêm trạng thái
) ENGINE=InnoDB;

-- 9. Bảng phương thức thanh toán
CREATE TABLE phuongthucthanhtoan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tenphuongthuc VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- 10. Bảng hóa đơn
CREATE TABLE hoadon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoidung INT,
    ngaytao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tongtien DECIMAL(10,2),
    diachigiaohang TEXT,
    trangthai ENUM('Chờ xác nhận', 'Đang giao', 'Đã giao', 'Đã hủy') NOT NULL,
    ghichu TEXT NOT NULL,
    id_khuyenmai INT, 
    id_phuongthucthanhtoan INT,
    FOREIGN KEY (id_nguoidung) REFERENCES nguoidung(id) ON DELETE CASCADE,
    FOREIGN KEY (id_phuongthucthanhtoan) REFERENCES phuongthucthanhtoan(id) ON DELETE SET NULL,
    FOREIGN KEY (id_khuyenmai) REFERENCES khuyenmai(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 11. Bảng chi tiết hóa đơn
CREATE TABLE chitiethoadon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_hoadon INT,
    id_sanpham INT,
    soluong INT NOT NULL,
    gia DECIMAL(10,2) NOT NULL,
    id_topping INT,
    FOREIGN KEY (id_hoadon) REFERENCES hoadon(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sanpham) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (id_topping) REFERENCES topping(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 12. Bảng banner
    CREATE TABLE banner (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hinhanh VARCHAR(255) NOT NULL,
    lienket VARCHAR(255)
) ENGINE=InnoDB;

-- 13. Bảng bình luận
CREATE TABLE binhluan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoidung INT NOT NULL,
    id_sanpham INT NOT NULL,
    noidung TEXT NOT NULL,
    danhgia INT CHECK (danhgia BETWEEN 1 AND 5),
    ngaydang TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_nguoidung) REFERENCES nguoidung(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sanpham) REFERENCES sanpham(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 14. Bảng địa chỉ nhận hàng
CREATE TABLE diachinhanhang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoidung INT NOT NULL,
    diachi TEXT NOT NULL,
    macdinh BOOLEAN DEFAULT 0,
    FOREIGN KEY (id_nguoidung) REFERENCES nguoidung(id) ON DELETE CASCADE
) ENGINE=InnoDB;
<<<<<<< HEAD
=======
-- 15. Bảng giỏ hàng (chỉ tồn tại khi chưa đặt hàng)
CREATE TABLE giohang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_nguoidung INT NOT NULL,
    ngaytao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    trangthai ENUM('Chưa đặt', 'Đã đặt') DEFAULT 'Chưa đặt',
    FOREIGN KEY (id_nguoidung) REFERENCES nguoidung(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 16. Bảng chi tiết giỏ hàng
CREATE TABLE giohang_chitiet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_giohang INT NOT NULL,
    id_sanpham INT NOT NULL,
    soluong INT NOT NULL DEFAULT 1,
    id_topping INT, -- Nếu có topping
    gia DECIMAL(10,2), -- Ghi nhận giá tại thời điểm thêm
    FOREIGN KEY (id_giohang) REFERENCES giohang(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sanpham) REFERENCES sanpham(id) ON DELETE CASCADE,
    FOREIGN KEY (id_topping) REFERENCES topping(id) ON DELETE SET NULL
) ENGINE=InnoDB;
>>>>>>> a7d59a7e2a92323ccd2d45c445f86ba2254d47e2
