<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fruitables - Vegetable Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="public/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="public/css/style.css" rel="stylesheet">
</head>
<?php
include 'views/client/header.php'; // Load header

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($page === 'home') {
    include 'views/client/dieuhuong.php'; 
} else {
    switch ($page) {
        case 'about':
            include 'views/about.php';
            break;
        case 'contact':
            include 'views/contact/contact.php';
            break;
        case 'product':
            include 'views/product/product.php';
            break;
        case 'cart':
            include 'views/cart/cart.php';
            break;
        case 'checkout':
            include 'views/checkout/checkout.php';
            break;
        default:
            include 'views/404.php';
            break;
    }
}

include 'views/client/footer.php'; // Load footer
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="public/lib/easing/easing.min.js"></script>
    <script src="public/lib/waypoints/waypoints.min.js"></script>
    <script src="public/lib/lightbox/js/lightbox.min.js"></script>
    <script src="public/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="public/js/main.js"></script>

    <?php
        include 'views/client/footer.php';
    ?>
</body>
</html>
