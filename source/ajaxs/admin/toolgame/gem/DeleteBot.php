<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = Anti_xss($_POST['id']);
    if (!@$getUser) {
        echo JsonMsg('error', 'Bạn chưa đăng nhập');
    } elseif ($getUser['level'] != 'admin') {
        echo JsonMsg('error', 'Bạn không có quyền truy cập vào trang này');
    } elseif ($SIEUTHICODE->num_rows("SELECT * FROM `nrogem_info_bot` WHERE `id` = '{$id}'") < 1) {
        echo JsonMsg('error', 'Không tìm thấy bot bạn cần xóa');
    } else {
        $SIEUTHICODE->query("DELETE FROM `nrogem_info_bot` WHERE `id` = '{$id}'");
        insert_log($getUser['id'], 'Xóa bot bán ngọc #' . $id . '');
        echo JsonMsg('success', 'Xóa thành công bot bán ngọc #' . $id . '');
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
