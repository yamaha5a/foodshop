<?php
require_once __DIR__ . '/../check_auth.php';
require_once __DIR__ . '/../Models/lienhe.php';

/**
 * Hiển thị danh sách liên hệ
 */
function index() {
    $lienHeList = get_all_contacts();
    include 'Views/lienhe/list.php';
}

/**
 * Xem chi tiết liên hệ
 */
function detail() {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error'] = "ID liên hệ không hợp lệ";
        header("Location: index.php?act=lienhe");
        exit();
    }

    $id = $_GET['id'];
    $contact = get_contact_by_id($id);

    if (!$contact) {
        $_SESSION['error'] = "Không tìm thấy liên hệ";
        header("Location: index.php?act=lienhe");
        exit();
    }

    // Đánh dấu đã đọc
    mark_as_read($id);

    include 'Views/lienhe/detail.php';
}

/**
 * Cập nhật trả lời liên hệ
 */
function update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?act=lienhe");
        exit();
    }

    if (!isset($_POST['id']) || !is_numeric($_POST['id']) || empty($_POST['phanhoi'])) {
        $_SESSION['error'] = "Dữ liệu không hợp lệ";
        header("Location: index.php?act=lienhe");
        exit();
    }

    $id = $_POST['id'];
    $phanhoi = $_POST['phanhoi'];

    $result = update_contact($id, $phanhoi);

    if ($result) {
        $_SESSION['success'] = "Cập nhật phản hồi thành công";
    } else {
        $_SESSION['error'] = "Cập nhật phản hồi thất bại";
    }

    header("Location: index.php?act=detailLienHe&id=" . $id);
    exit();
}

/**
 * Xóa liên hệ
 */
function delete() {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error'] = "ID liên hệ không hợp lệ";
        header("Location: index.php?act=lienhe");
        exit();
    }

    $id = $_GET['id'];
    $result = delete_contact($id);

    if ($result) {
        $_SESSION['success'] = "Xóa liên hệ thành công";
    } else {
        $_SESSION['error'] = "Xóa liên hệ thất bại";
    }

    header("Location: index.php?act=lienhe");
    exit();
} 