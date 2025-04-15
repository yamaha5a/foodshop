<?php
require_once 'Models/topping.php';

class ToppingController {
    private $toppingModel;

    public function __construct() {
        $this->toppingModel = new ToppingModel();
    }

    public function index() {
        $toppings = $this->toppingModel->getAllToppings();
        include 'Views/topping/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'tentopping' => $_POST['tentopping'],
                'gia' => $_POST['gia']
            ];

            if ($this->toppingModel->addTopping($data)) {
                $_SESSION['success_message'] = "Thêm topping thành công";
                header("Location: index.php?act=topping");
                exit;
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi thêm topping";
            }
        }
        include 'Views/topping/add.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?act=topping");
            exit;
        }

        $id = $_GET['id'];
        $topping = $this->toppingModel->getToppingById($id);

        if (!$topping) {
            $_SESSION['error_message'] = "Topping không tồn tại";
            header("Location: index.php?act=topping");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'tentopping' => $_POST['tentopping'],
                'gia' => $_POST['gia']
            ];

            if ($this->toppingModel->updateTopping($id, $data)) {
                $_SESSION['success_message'] = "Cập nhật topping thành công";
                header("Location: index.php?act=topping");
                exit;
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi cập nhật topping";
            }
        }

        include 'Views/topping/edit.php';
    }

    public function delete() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?act=topping");
            exit;
        }

        $id = $_GET['id'];
        
        if ($this->toppingModel->deleteTopping($id)) {
            $_SESSION['success_message'] = "Xóa topping thành công";
        } else {
            $_SESSION['error_message'] = "Không thể xóa topping vì đang được sử dụng trong sản phẩm";
        }

        header("Location: index.php?act=topping");
        exit;
    }

    public function detail() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?act=topping");
            exit;
        }

        $id = $_GET['id'];
        $topping = $this->toppingModel->getToppingById($id);

        if (!$topping) {
            $_SESSION['error_message'] = "Topping không tồn tại";
            header("Location: index.php?act=topping");
            exit;
        }

        $relatedProducts = $this->toppingModel->getRelatedProducts($id);
        include 'Views/topping/detail.php';
    }
} 