<?php
ob_start();
require_once __DIR__ . '/../Models/phuongthucthanhtoan.php';
class PhuongThucThanhToanController
{
    private $model;
    public function __construct()
    {
        $this->model = new PhuongThucThanhToanModel();
    }
    public function handleRequest()
    {
        $action = $_GET['action'] ?? 'list';

        switch ($action) {
            case 'list':
                $list = $this->model->getAll();
                include __DIR__ . '/../Views/phuongthucthanhtoan/list.php';
                break;

                case 'add':
                    if (isset($_POST['add'])) {
                        $ten = $_POST['tenpt'];
                        $this->model->insert($ten);
                        echo "<script>window.location.href = 'index.php?act=phuongthucthanhtoan';</script>";
                        exit;
                    } else {
                        include __DIR__ . '/../Views/phuongthucthanhtoan/add.php';
                    }
                    break;
                

            case 'edit':
                $id = $_GET['id'];
                $pt = $this->model->getOne($id);
                include __DIR__ . '/../Views/phuongthucthanhtoan/edit.php';
                break;

            case 'update':
                if (isset($_POST['capnhat'])) {
                    $id = $_POST['id'];
                    $ten = $_POST['tenpt'];
                    $this->model->update($id, $ten);
                    header("Location: index.php?act=phuongthucthanhtoan&action=list");
                    exit;
                }
                break;

            case 'delete':
                if (isset($_GET['id'])) {
                    $this->model->delete($_GET['id']);
                    echo "<script>window.location.href = 'index.php?act=phuongthucthanhtoan';</script>";
                    exit;

                }
                break;
        }
    }
}
ob_end_flush();

