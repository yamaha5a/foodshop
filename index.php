<?php
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
        default:
            include 'views/404.php';
            break;
    }
}

?>
