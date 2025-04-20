<?php
require_once 'model/binhluan.php';

class CommentController {
    public function addComment() {
        // Debug information
        error_log("CommentController::addComment called");
        error_log("POST data: " . print_r($_POST, true));
        error_log("SESSION data: " . print_r($_SESSION, true));
        
        if (!isset($_SESSION['user'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để bình luận";
            echo '<script>window.location.href = "index.php?page=login";</script>';
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Validate required fields
                if (!isset($_POST['product_id']) || !isset($_POST['comment']) || !isset($_POST['rating'])) {
                    $_SESSION['error_message'] = "Vui lòng điền đầy đủ thông tin bình luận";
                    echo '<script>window.location.href = "index.php?page=detail&id=' . $_POST['product_id'] . '";</script>';
                    exit();
                }
                
                $user_id = $_SESSION['user']['id'];
                $product_id = $_POST['product_id'];
                $content = $_POST['comment'];
                $rating = $_POST['rating'];

                // Debug information
                error_log("User ID: $user_id, Product ID: $product_id, Rating: $rating");
                error_log("Comment content: $content");

                // Kiểm tra số lượng bình luận
                $comment_count = get_comment_count($user_id, $product_id);
                error_log("Comment count: $comment_count");
                
                if ($comment_count >= 5) {
                    $_SESSION['error_message'] = "Bạn đã đạt giới hạn 5 bình luận cho sản phẩm này";
                    echo '<script>window.location.href = "index.php?page=detail&id=' . $product_id . '";</script>';
                    exit();
                }

                // Thêm bình luận
                $result = add_comment($user_id, $product_id, $content, $rating);
                error_log("Add comment result: " . ($result ? "success" : "failed"));
                
                if ($result) {
                    $_SESSION['success_message'] = "Bình luận của bạn đã được gửi thành công";
                } else {
                    $_SESSION['error_message'] = "Có lỗi xảy ra khi gửi bình luận";
                    error_log("Comment submission failed for user_id: $user_id, product_id: $product_id");
                }
            } catch (Exception $e) {
                error_log("Exception in addComment: " . $e->getMessage());
                $_SESSION['error_message'] = "Có lỗi xảy ra: " . $e->getMessage();
            }

            // Chuyển hướng về trang chi tiết sản phẩm
            echo '<script>window.location.href = "index.php?page=detail&id=' . $product_id . '";</script>';
            exit();
        } else {
            // If not POST request, redirect to home
            echo '<script>window.location.href = "index.php";</script>';
            exit();
        }
    }
}
?> 