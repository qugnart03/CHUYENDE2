<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($SIEUTHICODE->site('status_demo') == 1) {
        die(JsonMsg('error', 'Đây là trang web demo bạn không thể thực hiện chức năng này!'));
    }
    if ($SIEUTHICODE->site('status_event') != 1) {
        die(JsonMsg('error', 'Chức năng bảo trì'));
    }
    if (!isset($getUser)) {
        die(JsonMsg('error', 'Vui lòng đăng nhập để nhận quà'));
    }
    if ($SIEUTHICODE->get_row("SELECT * FROM `log_lixi` WHERE `username` = '{$getUser['username']}'")) {
        die(JsonMsg('error', 'Mỗi tài khoản chỉ nhận tối đa 1 lần!'));
    }
    if (!$SIEUTHICODE->get_row("SELECT * FROM `log_lixi` WHERE `username` = '{$getUser['username']}'")) {

        $diamond = explode(',', $SIEUTHICODE->site('diamond'));
        $rand_diamond = rand($diamond[0], $diamond[1]);
        $amount = $rand_diamond;
        $date = time();
        if($SIEUTHICODE->site('type_lixi') == 'money'){
            $text = str_replace('...', number_format($amount), $SIEUTHICODE->site('note_event'));
            $text_lx = "Nhận $amount Tiền website từ sự kiện lúc ". gettime();
            $SIEUTHICODE->query("INSERT INTO `log_lixi`(`username`, `description`, `create_date`, `update_date`) VALUES ('{$getUser['username']}', '{$text_lx}', '{$date}', '{$date}')");
            $SIEUTHICODE->query("UPDATE `users` SET `money` = `money` + '{$amount}' WHERE `username` = '{$getUser['username']}'");
        }
        if($SIEUTHICODE->site('type_lixi') == 'diamond'){
            $text = str_replace('...', number_format($amount), $SIEUTHICODE->site('note_event'));
            $text_lx = "Nhận $amount thỏi vàng từ sự kiện lúc ". gettime();
            $SIEUTHICODE->query("INSERT INTO `log_lixi`(`username`, `description`, `create_date`, `update_date`) VALUES ('{$getUser['username']}', '{$text_lx}', '{$date}', '{$date}')");
            $SIEUTHICODE->query("UPDATE `users` SET `diamond` = `diamond` + '{$amount}' WHERE `username` = '{$getUser['username']}'");
        }
        
        $SIEUTHICODE->insert("logs", [
            'user_id' => $getUser['id'],
            'ip' => myip(),
            'device' => $_SERVER['HTTP_USER_AGENT'],
            'create_date' => gettime(),
            'action' => 'Nhận ' . $amount . ' từ sự kiện lúc ' . gettime()
        ]);
        die(JsonMsg('success', html_entity_decode($text)));
    }
    
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
