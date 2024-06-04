<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');

if (isset($_POST['id']) && isset($_POST['status'])) {
    // if ($SIEUTHICODE->site('status_demo') != 0) {
    //     die(JsonMsg('error', 'Không được dùng chức năng này vì đây là trang web demo!'));
    // }
    if (empty($_SESSION['username'])) {
        die(JsonMsg('error', 'Vui lòng đăng nhập !'));
    }
    $user = Anti_xss($_SESSION['username']);
    if (!$getUser=$SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '".$user."' AND `banned` = '0' ")) {
        die(JsonMsg('error', 'Vui lòng đăng nhập!'));
    }
    if($getUser['level'] != 'admin'){
        die(JsonMsg('error', 'Bạn không có quyền thực hiện chức năng này!'));
    }
    $id = Anti_xss($_POST['id']);
    $status = Anti_xss($_POST['status']);
    $note = Anti_xss($_POST['note']);
    if (!$row = $SIEUTHICODE->get_row("SELECT * FROM `withdraw_ctv` WHERE `id` = '$id' ")) {
        die(JsonMsg('error', 'ID lịch sử không tồn tại trong hệ thống!'));
    }

    $isUpdate = $SIEUTHICODE->update("withdraw_ctv", [
        'status' => $status,
        'reason' => $note,
        'update_gettime' => gettime(),
    ], " `id` = '" . $row['id'] . "' ");

    if ($isUpdate) {
        $SIEUTHICODE->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Chỉnh sửa trạng thái lịch sử rút tiền CTV (ID '.$row['id'].')'
        ]);
        die(JsonMsg('success', 'Cập nhật thành công'));
    }else{
        die(JsonMsg('error', 'Cập nhật thất bại'));
    }
} else {
    die(JsonMsg('error', 'Dữ liệu không hợp lệ!'));
}