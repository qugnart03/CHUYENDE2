<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
$id = Anti_xss($_POST['id']);
    if(!@$getUser){
        echo JsonMsg('error','Bạn chưa đăng nhập');
    }elseif($getUser['level'] != 'admin'){
        echo JsonMsg('error','Bạn không có quyền truy cập trang này');
    }elseif($SIEUTHICODE->num_rows("SELECT * FROM `minigame` WHERE `id` = '{$id}'") < 1){
        echo JsonMsg('error','Không tìm thấy dữ liệu cần xóa');
    }else{
        $query = $SIEUTHICODE->get_row("SELECT * FROM `minigame` WHERE `id` = '{$id}'");
        $detail = json_decode($query['detail'], true);
        $SIEUTHICODE->query("DELETE FROM `minigame` WHERE `id` = '{$id}'");
        insert_log($getUser['id'], 'Xóa trò chơi '.$detail['name_product'].'');
        echo JsonMsg('success','Xóa thành công trò chơi '.$detail['name_product'].'');
    }