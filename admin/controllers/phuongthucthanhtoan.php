<?php
require_once __DIR__ . '/../check_auth.php';
require_once __DIR__ . '/../Models/phuongthucthanhtoan.php';

class PaymentMethodController {
    private $model;

    public function __construct() {
        $this->model = new PaymentMethodModel();
    }

    public function index() {
        $paymentMethods = $this->model->getAll();
        include __DIR__ . '/../Views/phuongthucthanhtoan/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenphuongthuc = $_POST['tenphuongthuc'];
            
            if (empty($tenphuongthuc)) {
                $_SESSION['error'] = "Vui lòng nhập tên phương thức thanh toán";
                echo '<meta http-equiv="refresh" content="0;url=index.php?act=addphuongthucthanhtoan">';
                exit();
            }

            $result = $this->model->add($tenphuongthuc);
            if ($result) {
                $_SESSION['success'] = "Thêm phương thức thanh toán thành công";
                echo '<meta http-equiv="refresh" content="0;url=index.php?act=phuongthucthanhtoan">';
                exit();
            } else {
                $_SESSION['error'] = "Thêm phương thức thanh toán thất bại";
                echo '<meta http-equiv="refresh" content="0;url=index.php?act=addphuongthucthanhtoan">';
                exit();
            }
        }
        include __DIR__ . '/../Views/phuongthucthanhtoan/add.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=phuongthucthanhtoan">';
            exit();
        }

        $id = $_GET['id'];
        $paymentMethod = $this->model->getById($id);

        if (!$paymentMethod) {
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=phuongthucthanhtoan">';
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenphuongthuc = $_POST['tenphuongthuc'];
            
            if (empty($tenphuongthuc)) {
                $_SESSION['error'] = "Vui lòng nhập tên phương thức thanh toán";
                echo '<meta http-equiv="refresh" content="0;url=index.php?act=editphuongthucthanhtoan&id=' . $id . '">';
                exit();
            }

            $result = $this->model->update($id, $tenphuongthuc);
            if ($result) {
                $_SESSION['success'] = "Cập nhật phương thức thanh toán thành công";
                echo '<meta http-equiv="refresh" content="0;url=index.php?act=phuongthucthanhtoan">';
                exit();
            } else {
                $_SESSION['error'] = "Cập nhật phương thức thanh toán thất bại";
                echo '<meta http-equiv="refresh" content="0;url=index.php?act=editphuongthucthanhtoan&id=' . $id . '">';
                exit();
            }
        }
        include __DIR__ . '/../Views/phuongthucthanhtoan/edit.php';
    }

    public function delete() {
        if (!isset($_GET['id'])) {
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=phuongthucthanhtoan">';
            exit();
        }

        $id = $_GET['id'];
        $result = $this->model->delete($id);

        if ($result) {
            $_SESSION['success'] = "Xóa phương thức thanh toán thành công";
        } else {
            $_SESSION['error'] = "Xóa phương thức thanh toán thất bại";
        }

        echo '<meta http-equiv="refresh" content="0;url=index.php?act=phuongthucthanhtoan">';
        exit();
    }
} 