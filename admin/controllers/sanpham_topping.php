<?php
require_once 'Models/sanpham_topping.php';
require_once 'Models/sanpham.php';
require_once 'Models/topping.php';

class SanPhamToppingController {
    private $sanPhamToppingModel;
    private $sanPhamModel;
    private $toppingModel;

    public function __construct() {
        $this->sanPhamToppingModel = new SanPhamToppingModel();
        $this->sanPhamModel = new SanPhamModel();
        $this->toppingModel = new ToppingModel();
    }

    public function index() {
        $productToppings = $this->sanPhamToppingModel->getAllProductToppings();
        include 'Views/sanpham_topping/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sanpham_id = $_POST['sanpham_id'];
            $topping_id = $_POST['topping_id'];

            // Kiểm tra xem sản phẩm và topping đã tồn tại chưa
            if ($this->sanPhamToppingModel->checkProductToppingExists($sanpham_id, $topping_id)) {
                $_SESSION['error_message'] = "Sản phẩm và topping này đã tồn tại!";
                header("Location: index.php?act=addsanpham_topping");
                exit();
            }

            if ($this->sanPhamToppingModel->addProductTopping($sanpham_id, $topping_id)) {
                header("Location: index.php?act=sanpham_topping");
                exit();
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi thêm sản phẩm - topping!";
            }
        }

        // Lấy danh sách sản phẩm và topping
        $products = $this->sanPhamModel->layTatCaSanPham();
        $toppings = $this->toppingModel->getAllToppings();
        
        include 'Views/sanpham_topping/add.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?act=sanpham_topping");
            exit();
        }

        $id = $_GET['id'];
        $productTopping = $this->sanPhamToppingModel->getProductToppingById($id);

        if (!$productTopping) {
            header("Location: index.php?act=sanpham_topping");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sanpham_id = $_POST['sanpham_id'];
            $topping_id = $_POST['topping_id'];

            // Kiểm tra xem sản phẩm và topping đã tồn tại chưa (trừ bản ghi hiện tại)
            if ($this->sanPhamToppingModel->checkProductToppingExists($sanpham_id, $topping_id, $id)) {
                $_SESSION['error_message'] = "Sản phẩm và topping này đã tồn tại!";
                header("Location: index.php?act=editsanpham_topping&id=" . $id);
                exit();
            }

            if ($this->sanPhamToppingModel->updateProductTopping($id, $sanpham_id, $topping_id)) {
                header("Location: index.php?act=sanpham_topping");
                exit();
            } else {
                $_SESSION['error_message'] = "Có lỗi xảy ra khi cập nhật sản phẩm - topping!";
            }
        }

        // Lấy danh sách sản phẩm và topping
        $products = $this->sanPhamModel->layTatCaSanPham();
        $toppings = $this->toppingModel->getAllToppings();
        
        include 'Views/sanpham_topping/update.php';
    }

    public function delete() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?act=sanpham_topping");
            exit();
        }

        $id = $_GET['id'];
        if ($this->sanPhamToppingModel->deleteProductTopping($id)) {
            header("Location: index.php?act=sanpham_topping");
            exit();
        } else {
            $_SESSION['error_message'] = "Có lỗi xảy ra khi xóa sản phẩm - topping!";
            header("Location: index.php?act=sanpham_topping");
            exit();
        }
    }
} 