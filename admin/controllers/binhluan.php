<?php
require_once __DIR__ . '/../check_auth.php';
require_once __DIR__ . '/../Models/binhluan.php';

class BinhluanController {
    public function index() {
        // Xử lý phân trang và tìm kiếm
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $kyw = isset($_GET['kyw']) ? $_GET['kyw'] : '';
        $limit = 10;

        $comments = get_all_comments($page, $limit, $kyw);
        $totalItems = get_total_comments($kyw);
        $soTrang = ceil($totalItems / $limit);

        include 'Views/binhluan/list.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if (delete_comment($id)) {
                $_SESSION['success'] = "Xóa bình luận thành công";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi xóa bình luận";
            }
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=binhluan">';
            exit();
        }
    }

    public function detail() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $comment = get_comment_by_id($id);
            if ($comment) {
                include 'Views/binhluan/detail.php';
            } else {
                $_SESSION['error'] = "Không tìm thấy bình luận";
                header("Location: index.php?act=binhluan");
                exit();
            }
        }
    }
}
?> 