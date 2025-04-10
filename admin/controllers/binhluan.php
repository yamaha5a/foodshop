<?php
require_once 'models/binhluan.php';

class BinhLuanController
{
    public function handleRequest()
    {
        $action = $_GET['action'] ?? 'list';

        switch ($action) {
            case 'list':
                $this->index();
                break;
            case 'detail':
                $this->detail();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                echo "Không tìm thấy action: " . $action;
                break;
        }
    }

    public function index()
    {
        $model = new BinhLuanModel();
        $keyword = $_GET['keyword'] ?? '';
        $page = $_GET['page'] ?? 1;
        $limit = 10;

        $dsbl = $model->getAllPaginated($page, $limit, $keyword);
        $totalPages = $model->getTotalPages($limit, $keyword);

        include './views/binhluan/list.php';
    }

    public function detail()
    {
        $id = $_GET['id'] ?? 0;
        $model = new BinhLuanModel();
        $bl = $model->getOne($id);
        include './views/binhluan/detail.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        $model = new BinhLuanModel();
        $model->delete($id);
   
        echo "<script>window.location.href = 'index.php?act=binhluan&action=list';</script>";
        exit;
    }
}
