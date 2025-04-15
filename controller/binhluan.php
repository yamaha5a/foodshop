<?php
require_once 'model/binhluan.php';

class CommentController {
    public function addComment() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để bình luận";
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user_id = $_SESSION['user']['id'];
                $product_id = $_POST['product_id'];
                $content = $_POST['comment'];
                $rating = $_POST['rating'];

                // Kiểm tra số lượng bình luận
                $comment_count = get_comment_count($user_id, $product_id);
                if ($comment_count >= 5) {
                    $_SESSION['error_message'] = "Bạn đã đạt giới hạn 5 bình luận cho sản phẩm này";
                    header("Location: index.php?page=detail&id=" . $product_id);
                }

                // Thêm bình luận
                if (add_comment($user_id, $product_id, $content, $rating)) {
                    $_SESSION['success_message'] = "Bình luận của bạn đã được gửi thành công";
                } else {
                    $_SESSION['error_message'] = "Có lỗi xảy ra khi gửi bình luận";
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Có lỗi xảy ra: " . $e->getMessage();
            }

            header("Location: index.php?page=detail&id=" . $product_id);
        }
    }
}
?> 