<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = Anti_xss($_POST['id']);
    if (!@$getUser) {
        echo JsonMsg('error', 'Bạn chưa đăng nhập');
    } elseif ($getUser['level'] != 'ctv') {
        echo JsonMsg('error', 'Bạn không có quyền truy cập vào trang này');
    } elseif ($SIEUTHICODE->num_rows("SELECT * FROM `accounts` WHERE `id` = '{$id}' AND `username_post` = '".$getUser['username']."'") < 1) {
        echo JsonMsg('error', 'Không tìm thấy tài khoản bạn cần xóa');
    } else {
        if ($getUser['level'] == 'member') {
            echo JsonMsg('error', 'Bạn không có quyền thao tác chức năng này');
        } elseif ($getUser['level'] == 'ctv') {
            $SIEUTHICODE->query("DELETE FROM `accounts` WHERE `id` = '{$id}' AND `username_post` = '".$getUser['username']."'");
            insert_log($getUser['id'], 'Xóa tài khoản #' . $id . '');
            echo JsonMsg('success', 'Xóa thành công tài khoản #' . $id . '');
        }
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
