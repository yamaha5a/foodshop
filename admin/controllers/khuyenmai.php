<?php
require_once __DIR__ . '/../check_auth.php';
require_once __DIR__ . '/../Models/khuyenmai.php';

class KhuyenMaiController {
    public function index() {
        // Cập nhật trạng thái các mã giảm giá hết hạn
        update_discount_status();
        
        $discounts = get_all_discounts();
        include 'Views/khuyenmai/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenkhuyenmai = $_POST['tenkhuyenmai'];
            $giatrigiam = $_POST['giatrigiam'];
            $ngaybatdau = $_POST['ngaybatdau'];
            $ngayketthuc = $_POST['ngayketthuc'];
            $trangthai = $_POST['trangthai'];

            if (add_discount($tenkhuyenmai, $giatrigiam, $ngaybatdau, $ngayketthuc, $trangthai)) {
                $_SESSION['success'] = "Thêm mã giảm giá thành công";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm mã giảm giá";
            }
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=khuyenmai">';
            exit();
        }
        include 'Views/khuyenmai/add.php';
    }

    public function edit() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $discount = get_discount_by_id($id);
            
            if ($discount) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $tenkhuyenmai = $_POST['tenkhuyenmai'];
                    $giatrigiam = $_POST['giatrigiam'];
                    $ngaybatdau = $_POST['ngaybatdau'];
                    $ngayketthuc = $_POST['ngayketthuc'];
                    $trangthai = $_POST['trangthai'];

                    if (update_discount($id, $tenkhuyenmai, $giatrigiam, $ngaybatdau, $ngayketthuc, $trangthai)) {
                        $_SESSION['success'] = "Cập nhật mã giảm giá thành công";
                    } else {
                        $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật mã giảm giá";
                    }
                    echo '<meta http-equiv="refresh" content="0;url=index.php?act=khuyenmai">';
                    exit();
                }
                include 'Views/khuyenmai/edit.php';
            } else {
                $_SESSION['error'] = "Không tìm thấy mã giảm giá";
                echo '<meta http-equiv="refresh" content="0;url=index.php?act=khuyenmai">';
                exit();
            }
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if (delete_discount($id)) {
                $_SESSION['success'] = "Xóa mã giảm giá thành công";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi xóa mã giảm giá";
            }
            echo '<meta http-equiv="refresh" content="0;url=index.php?act=khuyenmai">';
            exit();
        }
    }
}
?> 