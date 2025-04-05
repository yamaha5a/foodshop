<?php
require_once 'Models/danhmuc.php';

class DanhMucController {
    public function index() {
        $listDM = getAllDanhMuc();
        include 'views/danhmuc/danhmuc.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tendanhmuc = $_POST['tendanhmuc'];
            addDanhMuc($tendanhmuc);
            $_SESSION['thongbao'] = "Thêm thành công!";
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=danhmuc">';
            exit();        }
        include 'views/danhmuc/add.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        $dm = getOneDanhMuc($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tendanhmuc = $_POST['tendanhmuc'];
            updateDanhMuc($id, $tendanhmuc);
            $_SESSION['thongbao'] = "Cập nhật thành công!";
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=danhmuc">';
        exit(); 
        }
        include 'views/danhmuc/update.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        deleteDanhMuc($id);
        $_SESSION['thongbao'] = "Xoá thành công!";
        echo '<meta http-equiv="refresh" content="0;url=index.php?act=danhmuc">';
        exit(); 
    }
}
