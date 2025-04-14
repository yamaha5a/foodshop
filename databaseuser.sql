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