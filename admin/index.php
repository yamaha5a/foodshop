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
                            require_once 'controllers/thongke.php';
                            $controller = new ThongKeController();
                            $data = $controller->index();
                            include "Views/thongke/thongke.php";
                            break;

                        case 'bieudo':
                            require_once 'controllers/bieudo.php';
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
                        case 'listnguoidung':
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
                        case 'addSanPham':
                            require_once 'controllers/sanpham.php';
                            $controller = new SanPhamController();
                            $controller->add();
                            break;
                        case 'suaSanPham':
                            require_once 'controllers/sanpham.php';
                            $UpdateController = new SanPhamController();
                            $UpdateController->edit();
                            break;
                        case 'xoaSP':
                            require_once 'controllers/sanpham.php';
                            $xoaController = new SanPhamController();
                            $xoaController->delete();
                            break;
                        case 'chiTietSanPham':
                            require_once 'controllers/sanpham.php';
                            $controller = new SanPhamController();
                            $controller->chiTietSanPham();
                            break;
                        case 'phuongthucthanhtoan':
                            require_once 'controllers/phuongthucthanhtoan.php';
                            $controller = new PaymentMethodController();
                            $controller->index();
                            break;
                        
                        case 'addphuongthucthanhtoan':
                            require_once 'controllers/phuongthucthanhtoan.php';
                            $controller = new PaymentMethodController();
                            $controller->add();
                            break;
                        
                        case 'editphuongthucthanhtoan':
                            require_once 'controllers/phuongthucthanhtoan.php';
                            $controller = new PaymentMethodController();
                            $controller->edit();
                            break;
                        
                        case 'deletephuongthucthanhtoan':
                            require_once 'controllers/phuongthucthanhtoan.php';
                            $controller = new PaymentMethodController();
                            $controller->delete();
                            break;
                        case 'chitiethoadon':
                            require_once 'controllers/chitiethoadon.php';
                            $controller = new OrderDetailController();
                            $controller->index();
                            break;
                        
                        case 'detailchitiethoadon':
                            require_once 'controllers/chitiethoadon.php';
                            $controller = new OrderDetailController();
                            $controller->updateStatus();

                            $controller->detail();

                            break;
                        case 'binhluan':
                            require_once 'controllers/binhluan.php';
                            $controller = new BinhluanController();
                            $controller->index();
                            break;
                        case 'deletebinhluan':
                            require_once 'controllers/binhluan.php';
                            $controller = new BinhluanController();
                            $controller->delete();
                            break;
                        case 'detailbinhluan':
                            require_once 'controllers/binhluan.php';
                            $controller = new BinhluanController();
                            $controller->detail();
                            break;
                        case 'khuyenmai':
                            require_once 'controllers/khuyenmai.php';
                            $controller = new KhuyenMaiController();
                            $controller->index();
                            break;
                        case 'addkhuyenmai':
                            require_once 'controllers/khuyenmai.php';
                            $controller = new KhuyenMaiController();
                            $controller->add();
                            break;
                        case 'editkhuyenmai':
                            require_once 'controllers/khuyenmai.php';
                            $controller = new KhuyenMaiController();
                            $controller->edit();
                            break;
                        case 'deletekhuyenmai':
                            require_once 'controllers/khuyenmai.php';
                            $controller = new KhuyenMaiController();
                            $controller->delete();
                            break;

                        case 'topping':
                            require_once 'controllers/topping.php';
                            $controller = new ToppingController();
                            $controller->index();
                            break;

                        case 'addtopping':
                            require_once 'controllers/topping.php';
                            $controller = new ToppingController();
                            $controller->add();
                            break;

                        case 'edittopping':
                            require_once 'controllers/topping.php';
                            $controller = new ToppingController();
                            $controller->edit();
                            break;

                        case 'deletetopping':
                            require_once 'controllers/topping.php';
                            $controller = new ToppingController();
                            $controller->delete();
                            break;

                        case 'detailtopping':
                            require_once 'controllers/topping.php';
                            $controller = new ToppingController();
                            $controller->detail();
                            break;

                        case 'sanpham_topping':
                            require_once 'controllers/sanpham_topping.php';
                            $controller = new SanPhamToppingController();
                            $controller->index();
                            break;

                        case 'addsanpham_topping':
                            require_once 'controllers/sanpham_topping.php';
                            $controller = new SanPhamToppingController();
                            $controller->add();
                            break;

                        case 'editsanpham_topping':
                            require_once 'controllers/sanpham_topping.php';
                            $controller = new SanPhamToppingController();
                            $controller->edit();
                            break;

                        case 'deletesanpham_topping':
                            require_once 'controllers/sanpham_topping.php';
                            $controller = new SanPhamToppingController();
                            $controller->delete();
                            break;
                            
                        case 'sanphamgiamgia':
                            require_once 'controllers/sanphamgiamgia.php';
                            $controller = new SanPhamGiamGiaController();
                            $controller->index();
                            break;
                            
                        case 'addSanPhamGiamGia':
                            require_once 'controllers/sanphamgiamgia.php';
                            $controller = new SanPhamGiamGiaController();
                            $controller->add();
                            break;
                            
                        case 'suaSanPhamGiamGia':
                            require_once 'controllers/sanphamgiamgia.php';
                            $controller = new SanPhamGiamGiaController();
                            $controller->edit();
                            break;
                            
                        case 'xoaSanPhamGiamGia':
                            require_once 'controllers/sanphamgiamgia.php';
                            $controller = new SanPhamGiamGiaController();
                            $controller->delete();
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
