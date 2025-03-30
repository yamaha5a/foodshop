<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['tenquyen'] !== 'admin') {
    header("Location: /shopfood/admin/Views/login/login.php"); // Chuyển hướng người dùng không phải admin
    exit();
}
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
    <?php include __DIR__ . "/Views/admin/header.php"; ?>

        <?php include __DIR__ . "/Views/admin/menu.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
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
                                $id = intval($_GET['id']); 
                            
                                // Kiểm tra danh mục có tồn tại không
                                $check = pdo_query_one("SELECT * FROM danhmuc WHERE id = ?", $id);
                            
                                if ($check) {
                                    // Xóa danh mục trong database
                                    pdo_execute("DELETE FROM danhmuc WHERE id = ?", $id);
                                    $_SESSION['thongbao'] = "Xóa danh mục thành công!";
                                } else {
                                    $_SESSION['thongbao'] = "Danh mục không tồn tại hoặc đã bị xóa!";
                                }
                                echo '<meta http-equiv="refresh" content="0;url=index.php?act=danhmuc">';
                                exit();

                                break;
                                                     
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
                                            case 'capnhatNguoiDung':
                                                require_once 'controllers/nguoidung.php'; // Đảm bảo đường dẫn đúng
                                                $nguoiDungController = new NguoiDungController();
                                            
                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                    // Nếu form cập nhật được gửi đi thì xử lý cập nhật
                                                    $nguoiDungController->capNhatNguoiDung();
                                                } elseif (isset($_GET['id'])) {
                                                    // Nếu chỉ vào trang này với id, thì hiển thị form cập nhật
                                                    include "Views/nguoidung/update.php";
                                                } else {
                                                    echo "ID người dùng không hợp lệ!";
                                                }
                                                break;
                                                case 'thongke':
                                                    $total_users = $thongKeModel->demTongTaiKhoan();
                                                    include "Views/thongke/thongke.php";
                                                    break;
                                                case 'banner':
                                                    require_once 'controllers/banner.php'; // Đảm bảo file controller được include
                                                    $controller = new BannerController(); // Khởi tạo controller trước khi gọi method
                                                    $controller->index();
                                                    break;
                                                case 'addbanner':
                                                    require_once 'controllers/banner.php'; 
                                                    $bannerController = new BannerController(); 
                                                    $bannerController->addBanner();
                                                    break;
                                                case 'deletebanner':
                                                    require_once 'controllers/banner.php'; 
                                                    $bannerController = new BannerController(); 
                                                    $bannerController->delete();
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
