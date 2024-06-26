<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');

if (isset($_POST['id'])) {
    if ($SIEUTHICODE->site('status_demo') != 0) {
        die(JsonMsg('error', 'Không được dùng chức năng này vì đây là trang web demo!'));
    }
    if (empty($_SESSION['username'])) {
        die(JsonMsg('error', 'Vui lòng đăng nhập !'));
    }
    if (!$getUser=$SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' AND `banned` = '0' ")) {
        die(JsonMsg('error', 'Vui lòng đăng nhập!'));
    }
    if($getUser['level'] != 'admin'){
        die(JsonMsg('error', 'Bạn không có quyền thực hiện chức năng này!'));
    }
    $id = Anti_xss($_POST['id']);
    if (!$row = $SIEUTHICODE->get_row("SELECT * FROM `blogs` WHERE `id` = '$id' ")) {
        die(JsonMsg('error', 'ID bài viết không tồn tại trong hệ thống!'));
    }
    $isRemove = $SIEUTHICODE->remove("blogs", " `id` = '$id' ");
    if ($isRemove) {
        $SIEUTHICODE->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Xoá bài viết ('.$row['title'].' ID '.$row['id'].')'
        ]);
        die(JsonMsg('success', 'Xóa bài viết thành công'));
    }
} else {
    die(JsonMsg('error', 'Dữ liệu không hợp lệ!'));
}