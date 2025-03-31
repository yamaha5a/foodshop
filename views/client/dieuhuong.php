<?php
require_once 'controller/banner.php';
$bannerController = new BannerController();
$bannerController->showBanners();
include 'views/home/sliderbar.php'; 
include 'views/home/home.php'; 
?>