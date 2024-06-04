<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loaithe = Anti_xss($_POST['loaithe']);
    $menhgia = Anti_xss($_POST['menhgia']);
    $seri = Anti_xss($_POST['seri']);
    $pin = Anti_xss($_POST['pin']);
    $captcha = Anti_xss($_POST['captcha']);

    if (empty($_SESSION['username'])) {
        die(JsonMsg('error', 'Vui lòng đăng nhập !'));
    }
    if (!$SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' AND `banned` = '0' ")) {
        die(JsonMsg('error', 'Vui lòng đăng nhập!'));
    }
    if($SIEUTHICODE->site("status_demo") == "ON"){
        die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
    }
    if (empty($loaithe)) {
        die(JsonMsg('error', 'Vui lòng chọn loại thẻ !'));
    }
    if (empty($menhgia)) {
        die(JsonMsg('error', 'Vui lòng chọn mệnh giá !'));
    }
    if (empty($seri)) {
        die(JsonMsg('error', 'Vui lòng nhập seri thẻ !'));
    }
    if (empty($pin)) {
        die(JsonMsg('error', 'Vui lòng nhập mã thẻ !'));
    }
    if (strlen($seri) < 5 || strlen($pin) < 5) {
        die(JsonMsg('error', 'Mã thẻ hoặc seri không đúng định dạng!'));
    }
    if (empty($captcha)) {
        die(JsonMsg('error', 'Vui lòng nhập mã captcha!'));
    }
    if ($captcha != $_SESSION['captchav2']) {
        die(JsonMsg('error', 'Mã captcha không hợp lệ!'));
    }
    if($SIEUTHICODE->num_rows("SELECT * FROM `cards` WHERE `user_id`='".$getUser['id']."' AND `status` = 'xuly'") > 5){
        die(JsonMsg('error', 'Bạn đã có quá nhiều yêu cầu nạp thẻ chưa được xử lý!'));
    }
    $code = random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 32);
    $data = gachthe1s($loaithe, $menhgia, $seri, $pin, $code);
    if (isset($data['status'])) {
        if ($data['status'] == '99') {
            $SIEUTHICODE->insert("cards", array(
                'code' => $code,
                'seri' => $seri,
                'pin' => $pin,
                'loaithe' => $loaithe,
                'menhgia' => $menhgia,
                'thucnhan' => '0',
                'user_id' => $getUser['id'],
                'status' => 'xuly',
                'note' => '',
                'createdate' => gettime(),
            ));
            die(JsonMsg('success', 'Gửi thẻ thành công, vui lòng đợi kết quả'));
        }else{
            die(JsonMsg('error', $data['message']));
        }
    } else {
        die(JsonMsg('error', 'Đã xảy ra lỗi khi gửi dữ liệu!'));
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
