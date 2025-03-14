<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../../public/css/css.css">
  </head>

  <body>
    <div class="container">
        <?php include('menu.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('header.php'); ?>

                <!-- Thêm nội dung chính vào đây -->
                <div class="main-content">
                    <div class="page-title">
                        <div class="title">Bảng điều khiển</div>
                        <div class="action-buttons">
                            <button class="btn btn-primary">Thêm mới</button>
                            <button class="btn btn-primary">Xuất dữ liệu</button>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <h1 class="h3 mb-2 text-gray-800">Thống kê</h1>
                        <div class="card">
                            <div class="card-body">
                                <?php
                                if (isset($_GET['act'])) { 
                                    $act = $_GET['act']; // Lấy giá trị của 'act' từ URL
                                    switch ($act) {
                                        case 'thongke':
                                            include "../thongke/thongke.php";  
                                            break;
                                        default:
                                            echo "<p>Chào mừng bạn đến với trang quản trị!</p>";
                                            break;
                                    }
                                } else {
                                    echo "<p>Chào mừng bạn đến với trang quản trị</p>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <?php include('footer.php'); ?>
</body>


</html>
