<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = Anti_xss($_POST['id']);
    if (!@$getUser) {
        echo JsonMsg('error', 'Bạn chưa đăng nhập');
    } elseif ($getUser['level'] != 'admin') {
        echo JsonMsg('error', 'Bạn không có quyền truy cập vào trang này');
    } elseif ($SIEUTHICODE->num_rows("SELECT * FROM `accounts` WHERE `id` = '{$id}'") < 1) {
        echo JsonMsg('error', 'Không tìm thấy tài khoản bạn cần xóa');
    } else {
        if ($getUser['level'] == 'ctv') {
            // if ($SIEUTHICODE->num_rows("SELECT * FROM `list_account` WHERE `id` = '{$id}' AND `username_post` = '{$data_user['username']}'") > 0) {
            //     $SIEUTHICODE->query("DELETE FROM `list_account` WHERE `id` = '{$id}' AND `username_post` = '{$data_user['username']}'");
            //     insert_log($data_user['username'], 'DELETEACOUNT', 'Xóa tài khoản #' . $id . '', $old_cash = $data_user['cash'], $change_cash = 0, $new_cash = $data_user['cash'], $old_cash_diamond = $data_user['diamond'], $change_cash_diamond = 0, $new_cash_diamond = $data_user['diamond']);
            //     echo JsonMsg('success', 'Xóa thành công tài khoản #' . $id . '');
            // } else {
            //     echo JsonMsg('error', 'Không tìm thấy tài khoản để xóa');
            // }
        } elseif ($getUser['level'] == 'member') {
            echo JsonMsg('error', 'Bạn không có quyền thao tác chức năng này');
        } elseif ($getUser['level'] == 'admin') {
            $SIEUTHICODE->query("DELETE FROM `accounts` WHERE `id` = '{$id}'");
            insert_log($getUser['id'], 'Xóa tài khoản #' . $id . '');
            echo JsonMsg('success', 'Xóa thành công tài khoản #' . $id . '');
        }
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
