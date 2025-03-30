<?php
require_once 'model/banner.php';

class BannerController {
    private $bannerModel;

    public function __construct() {
        $this->bannerModel = new BannerModel();
    }

    public function showBanners() {
        $banners = $this->bannerModel->getAllBanners();
        include 'views/home/banner.php'; // Gọi view banner và truyền dữ liệu
    }
}
?>
