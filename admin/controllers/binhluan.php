<?php
require_once __DIR__ . '/../Models/binhluan.php';

class BinhluanController {
    public function index() {
        $comments = get_all_comments();
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