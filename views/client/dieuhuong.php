<?php
require_once 'controller/banner.php';
require_once 'controller/sanpham.php';

$bannerController = new BannerController();
$bannerController->showBanners();
include 'views/home/sliderbar.php'; 
$sanphamController = new SanPhamController();
$sanphamController->list();
?>