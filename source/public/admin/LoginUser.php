<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        if (!@$getUser) {
            echo JsonMsg('error', 'Bạn chưa đăng nhập');
        } elseif ($getUser['level'] != 'admin') {
            echo JsonMsg('error', 'Bạn không có quyền truy cập trang này');
        }
        $id = Anti_xss($_GET['id']);
        $user = $SIEUTHICODE->get_row("SELECT * FROM `users` WHERE `id` = '$id' ");
        if (!$user) {
            new Redirect('/Admin/Home');
        }
        insert_log($getUser['id'], 'Login user ' . $user['username']);
        $_SESSION['username'] = $user['username'];
        new Redirect('/');
    }
    new Redirect('/Admin/Home');
}
