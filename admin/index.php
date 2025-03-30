<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['user_id']) || $_SESSION['tenquyen'] !== 'admin') {
    header("Location: /shopfood/admin/Views/login/login.php"); // Chuyển hướng người dùng không phải admin
    exit();
}
include '.././admin/Models/loaiSanPham.php';
include '.././admin/Models/danhmuc.php';
include '.././admin/Models/sanPham.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="public/css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <?php include __DIR__ . "/Views/admin/menu.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __DIR__ . "/Views/admin/header.php"; ?>
                <?php include_once("Models/connection.php"); ?>

                <?php

                if (isset($_GET['act'])) {
                    $act = htmlspecialchars($_GET['act']); // Ngăn chặn XSS
                    switch ($act) {
                        case 'thongke':
                            include "Views/thongke/thongke.php";
                            break;

                        case 'danhmuc':
                            $sql = "SELECT * FROM danhmuc ORDER BY id ASC";
                            $listDM = pdo_query($sql);
                            include "Views/danhmuc/danhmuc.php";
                            break;

                        case 'delete':
                            if (!headers_sent()) { // Kiểm tra nếu chưa gửi header
                                $id = intval($_GET['id']);
                                pdo_execute("DELETE FROM danhmuc WHERE id = ?", $id);
                                $_SESSION['thongbao'] = "Xóa danh mục thành công!";
                                header("Location: index.php?act=danhmuc");
                                exit();
                            } else {
                                echo "<script>window.location.href='index.php?act=danhmuc';</script>";
                            }


                        case 'addDM':
                            if (isset($_POST['themmoi']) && !empty($_POST['tenDM'])) {
                                $tenloai = trim($_POST['tenDM']);
                                $sql = "INSERT INTO danhmuc (tendanhmuc) VALUES (?)";
                                pdo_execute($sql, $tenloai);

                                // Gán thông báo và chuyển hướng để tránh reload gây lỗi
                                $_SESSION['thongbao'] = "Thêm danh mục thành công!";
                                header("Location: index.php?act=danhmuc");
                                exit();
                            }
                            include "Views/danhmuc/add.php";
                            break;
                        case 'updateDM':
                            if (isset($_POST['capnhat'])) {
                                $id = intval($_POST['idDM']);
                                $tenDM = trim($_POST['tenDM']);

                                if (!empty($tenDM)) {
                                    pdo_execute("UPDATE danhmuc SET tendanhmuc = ? WHERE id = ?", $tenDM, $id);
                                    $_SESSION['thongbao'] = "Cập nhật danh mục thành công!";
                                    header("Location: index.php?act=danhmuc");
                                    exit();
                                }
                            }
                            include "Views/danhmuc/update.php";
                            break;
                        case 'Loai_sanPham':
                            $listSP = loadall_loaiSP();
                            include "Views/loaiSanPham/list.php";
                            break;
                        case 'addLoaiSP':
                            if (isset($_POST['themmoi']) && ($_POST['themmoi'])) {
                                $madm = $_POST['madm'];
                                $malsp = $_POST['malsp'];
                                $tenloai = $_POST['tenloai'];
                                $mota = $_POST['mota'];
                                $hinhanh = $_FILES['hinhanh']['name'];
                                $target_dir = "../upload/";
                                $target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);
                                if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
                                    // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                                } else {
                                    // echo "Sorry, there was an error uploading your file.";
                                }

                                insert_loaisanpham($malsp, $tenloai, $hinhanh, $mota, $madm);
                                $thongbao = "Them thanh cong";
                            }
                            $listdanhmuc = loadall_danhmuc();
                            include "Views/loaiSanPham/add.php";
                            break;
                        case 'deleteLoaisp':
                            if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                                $id = $_GET['id'];
                                delete_loaisanpham($id);
                                $thongbao = "Xoa thanh cong";
                            }
                            $listSP = loadall_loaiSP();
                            include "Views/loaiSanPham/list.php";
                            break;
                        case 'sualoaiSP':
                            if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                                $loaiSP = suaLoaiSP($_GET['id']);
                            }
                            $listdanhmuc = loadall_danhmuc();

                            include "Views/loaiSanPham/update.php";
                            break;
                        case 'updateLoaiSP':
                            if (isset($_POST['capnhap']) && ($_POST['capnhap'])) {
                                $id = $_POST['id'];
                                $madm = $_POST['madm'];
                                $malsp = $_POST['malsp'];
                                $tenloai = $_POST['tenloai'];
                                $mota = $_POST['mota'];
                                $hinhanh_cu = $_POST['hinhanh_cu']; // Lấy ảnh cũ từ form

                                // Kiểm tra xem có ảnh mới không
                                if ($_FILES['hinhanh']['name'] != "") {
                                    $hinhanh = $_FILES['hinhanh']['name'];
                                    $target_dir = "../upload/"; // Thư mục lưu ảnh
                                    $target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);

                                    // Di chuyển ảnh mới vào thư mục upload
                                    if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
                                        // Ảnh mới đã tải lên thành công
                                    }
                                } else {
                                    // Nếu không có ảnh mới, giữ nguyên ảnh cũ
                                    $hinhanh = $hinhanh_cu;
                                }
                                update_loaisanpham($id, $malsp, $tenloai, $hinhanh, $mota, $madm);
                                $thongbao = "cập nhập thanh cong";
                            }
                            $listdanhmuc = loadall_danhmuc();
                            $listSP = loadall_loaiSP();
                            include "Views/loaiSanPham/list.php";
                            break;
                        case 'sanpham':
                            $listdanhmuc = loadall_danhmuc();
                            $kyw = "";
                            $iddm = 0;
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $limit = 5; // Số sản phẩm mỗi trang
                            if (isset($_POST['listok']) && ($_POST['listok'])) {
                                $kyw = $_POST['kyw'];
                                $iddm = $_POST['iddm'];
                                $page = 1;
                            }
                            // Lấy tổng số trang
                            $total_pages = get_total_pages($kyw, $iddm, $limit);

                            // Lấy danh sách sản phẩm theo trang hiện tại
                            $listSanPham = loadall_sanPham($kyw, $iddm, $page, $limit);
                            include "Views/sanpham/list.php";
                            break;
                        case 'addSanPham':
                            if (isset($_POST['themmoi']) && ($_POST['themmoi'])) {
                                $tensanpham = $_POST['tensanpham'];
                                $mota = $_POST['mota'];
                                $gia = $_POST['gia'];
                                $soluong = $_POST['soluong'];
                                $id_danhmuc = $_POST['id_danhmuc'];
                                $id_loaisanpham = $_POST['id_loaisanpham'];
                                $thoigiantao = $_POST['thoigiantao'];
                                // Upload ảnh an toàn
                                $target_dir = "../upload/";
                                $hinhanh1 = (!empty($_FILES['hinhanh1']['name'])) ? $_FILES['hinhanh1']['name'] : "";
                                $hinhanh2 = (!empty($_FILES['hinhanh2']['name'])) ? $_FILES['hinhanh2']['name'] : "";
                                $hinhanh3 = (!empty($_FILES['hinhanh3']['name'])) ? $_FILES['hinhanh3']['name'] : "";

                                if (!empty($hinhanh1)) move_uploaded_file($_FILES["hinhanh1"]["tmp_name"], $target_dir . $hinhanh1);
                                if (!empty($hinhanh2)) move_uploaded_file($_FILES["hinhanh2"]["tmp_name"], $target_dir . $hinhanh2);
                                if (!empty($hinhanh3)) move_uploaded_file($_FILES["hinhanh3"]["tmp_name"], $target_dir . $hinhanh3);


                                // Gọi hàm thêm sản phẩm (trạng thái sẽ tự xác định trong SQL)
                                $result = insert_sanpham($tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $thoigiantao);

                                if (!$result) {
                                    $thongbao = " Thêm sản phẩm thành công!";
                                } else {
                                    $thongbao = "Lỗi! Không thể thêm sản phẩm.";
                                }
                            }


                            $listdanhmuc = loadall_danhmuc();
                            $listloaisp = loadall_loaiSP();
                            include "Views/sanpham/add.php";
                            break;
                        case 'xoaSanPham':
                            if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                                deleteSanPham($_GET['id']);
                            }
                            // Lấy dữ liệu tìm kiếm và phân trang từ $_GET (nếu có)
                            $kyw = isset($_GET['kyw']) ? $_GET['kyw'] : "";
                            $iddm = isset($_GET['iddm']) ? $_GET['iddm'] : 0;
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $limit = 5;
                            $listdanhmuc = loadall_danhmuc();
                            $total_pages = get_total_pages("", 0, $limit);
                            $listSanPham = loadall_sanPham("", 0, $page, $limit);
                            include "Views/sanpham/list.php";
                            break;
                        case 'suaSanPham':
                            if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                                $sanPham = suaSanPham($_GET['id']);
                            }
                            $listdanhmuc = loadall_danhmuc();
                            $listloaisp = loadall_loaiSP();
                            include "Views/sanpham/update.php";
                            break;
                        case 'updateSanPham':
                            if (isset($_POST['capnhap']) && ($_POST['capnhap'])) {
                                $id = $_POST['id'];
                                $tensanpham = $_POST['tensanpham'];
                                $mota = $_POST['mota'];
                                $gia = $_POST['gia'];
                                $soluong = $_POST['soluong'];
                                $id_danhmuc = $_POST['id_danhmuc'];
                                $id_loaisanpham = $_POST['id_loaisanpham'];
                                $thoigiantao = $_POST['thoigiantao'];
                                // Lấy ảnh cũ từ form
                                $hinhanh1 = $_POST['hinhanh_cu1'];
                                $hinhanh2 = $_POST['hinhanh_cu2'];
                                $hinhanh3 = $_POST['hinhanh_cu3'];

                                // Thư mục lưu ảnh
                                $target_dir = "../upload/";

                                // Kiểm tra và cập nhật ảnh mới nếu có
                                if (!empty($_FILES['hinhanh1']['name'])) {
                                    $hinhanh1 = $_FILES['hinhanh1']['name'];
                                    move_uploaded_file($_FILES["hinhanh1"]["tmp_name"], $target_dir . $hinhanh1);
                                }

                                if (!empty($_FILES['hinhanh2']['name'])) {
                                    $hinhanh2 = $_FILES['hinhanh2']['name'];
                                    move_uploaded_file($_FILES["hinhanh2"]["tmp_name"], $target_dir . $hinhanh2);
                                }

                                if (!empty($_FILES['hinhanh3']['name'])) {
                                    $hinhanh3 = $_FILES['hinhanh3']['name'];
                                    move_uploaded_file($_FILES["hinhanh3"]["tmp_name"], $target_dir . $hinhanh3);
                                }

                                // Tiếp tục xử lý cập nhật vào CSDL...


                                // Gọi hàm thêm sản phẩm (trạng thái sẽ tự xác định trong SQL)
                                $result = update_sanPham($tensanpham, $mota, $gia, $soluong, $hinhanh1, $hinhanh2, $hinhanh3, $id_danhmuc, $id_loaisanpham, $thoigiantao, $id);

                                if (!$result) {
                                    $thongbao = " cập nhập phẩm thành công!";
                                } else {
                                    $thongbao = "Lỗi! Không thể thêm sản phẩm.";
                                }
                            }


                            // Lấy dữ liệu tìm kiếm và phân trang từ $_GET (nếu có)
                            $kyw = isset($_GET['kyw']) ? $_GET['kyw'] : "";
                            $iddm = isset($_GET['iddm']) ? $_GET['iddm'] : 0;
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $limit = 5;
                            $listdanhmuc = loadall_danhmuc();
                            $total_pages = get_total_pages("", 0, $limit);
                            $listSanPham = loadall_sanPham("", 0, $page, $limit);
                            include "Views/sanpham/list.php";
                            break;
                        case 'nguoidung':
                            require_once 'controllers/nguoidung.php'; // Đảm bảo đường dẫn đúng
                            $nguoiDungController = new NguoiDungController(); // Tạo đối tượng controller
                            $nguoiDungController->danhSach(); // Gọi phương thức để hiển thị danh sách người dùng
                            break;
                        case 'addnguoidung': // Xử lý thêm người dùng
                            require_once 'controllers/nguoidung.php';
                            $nguoiDungController = new NguoiDungController();
                            $nguoiDungController->addUser(); // Gọi phương thức để thêm người dùng
                            break;
                        case 'detailnguoidung': // Hiển thị chi tiết người dùng
                            require_once 'controllers/nguoidung.php';
                            $nguoiDungController = new NguoiDungController();

                            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                                $id = $_GET['id'];
                                $nguoiDungController->chiTietNguoiDung($id); // Gọi phương thức lấy chi tiết người dùng
                            } else {
                                echo "ID người dùng không hợp lệ!";
                            }
                            break;
                        case 'xoaNguoiDung':
                            require_once 'controllers/nguoidung.php'; // Đảm bảo đường dẫn đúng
                            $nguoiDungController = new NguoiDungController();

                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                echo "ID nhận được: " . htmlspecialchars($id); // Kiểm tra xem ID có được truyền không
                                $nguoiDungController->xoaNguoiDung($id); // Gọi phương thức xóa
                            } else {
                                echo "ID người dùng không hợp lệ!";
                            }
                            break;
                        case 'capnhatNguoiDung':
                            require_once 'controllers/nguoidung.php'; // Đảm bảo đường dẫn đúng
                            $nguoiDungController = new NguoiDungController();

                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $nguoiDungController->capNhatNguoiDung(); // Gọi phương thức cập nhật
                            } elseif (isset($_GET['id'])) {
                                $nguoiDungController->chiTietNguoiDung($_GET['id']); // Lấy thông tin để hiển thị form cập nhật
                            } else {
                                echo "ID người dùng không hợp lệ!";
                            }
                            break;
                        default:
                            echo "<p>Chào mừng bạn đến với trang quản trị!</p>";
                            break;
                    }
                } else {
                    echo "<p>Chào mừng bạn đến với trang quản trị!</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>