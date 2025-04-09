<?php
require_once 'model/danhmuc.php';

class DanhMucController {
    public function index() {
        $listDM = getAllDanhMuc();
    }
}

?>