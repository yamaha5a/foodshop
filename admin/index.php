<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /shopfood/admin/Views/login/login.php");
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
                            $id = intval($_GET['id']); 
                            pdo_execute("DELETE FROM danhmuc WHERE id = ?", $id);
                            $_SESSION['thongbao'] = "Xóa danh mục thành công!";
                            header("Location: index.php?act=danhmuc");
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
