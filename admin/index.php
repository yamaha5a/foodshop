<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['tenquyen'] !== 'admin') {
    header("Location: /shopfood/admin/Views/login/login.php"); 
    exit();
}
include 'Models/sanpham.php';

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
                    $act = htmlspecialchars($_GET['act']); 
                    switch ($act) {
                        case 'thongke':
                            include "Views/thongke/thongke.php";  
                            break;

                            case 'danhmuc':
                                require_once 'controllers/danhmuc.php';
                                $controller = new DanhMucController();
                                $controller->index();
                                break;
                        
                            case 'adddanhmuc':
                                require_once 'controllers/danhmuc.php';
                                $controller = new DanhMucController();
                                $controller->add();
                                break;
                        
                            case 'editdanhmuc':
                                require_once 'controllers/danhmuc.php';
                                $controller = new DanhMucController();
                                $controller->edit();
                                break;
                        
                            case 'deletedanhmuc':
                                require_once 'controllers/danhmuc.php';
                                $controller = new DanhMucController();
                                $controller->delete();
                                break;                    
                            case 'nguoidung':
                                require_once 'controllers/nguoidung.php'; 
                                $nguoiDungController = new NguoiDungController(); 
                                $nguoiDungController->danhSach();
                                break;
                            case 'addnguoidung':
                                require_once 'controllers/nguoidung.php';
                                $nguoiDungController = new NguoiDungController();
                                $nguoiDungController->addUser(); 
                                break;
                            case 'detailnguoidung':
                                    require_once 'controllers/nguoidung.php';
                                    $nguoiDungController = new NguoiDungController();
                                    $nguoiDungController->chiTietNguoiDung(); 
                                    
                                    break;
                            case 'capnhatNguoiDung':
                                require_once 'controllers/nguoidung.php'; 
                                $nguoiDungController = new NguoiDungController();
                                $nguoiDungController->capNhatNguoiDung();

                                break;
                            case 'thongke':
                                $total_users = $thongKeModel->demTongTaiKhoan();
                                include "Views/thongke/thongke.php";
                                break;
                            case 'banner':
                                require_once 'controllers/banner.php';
                                $controller = new BannerController(); 
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
                            case 'sanpham':
                                require_once 'controllers/sanpham.php';
                                $controller = new SanPhamController();
                                $controller->list();
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
