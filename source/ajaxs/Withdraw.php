<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($SIEUTHICODE->site('baotri') == 'OFF'){
        die(JsonMsg('error', 'Website đang bảo trì vui lòng quay lại sau!'));
    }
    if ($SIEUTHICODE->site("status_demo") == "ON") {
        die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
    }
    if(!isset($_POST['data']) || !isset($_POST['packdiamond'])){
        die(JsonMsg('error', 'Thiếu tham số dữ liệu'));
    }
    $datagame = Anti_xss($_POST['data']);
    $package = Anti_xss($_POST['packdiamond']);
    if ($package == 1) {
        $diamond = 90;
        $amount = 20000;
    } elseif ($package == 2) {
        $diamond = 230;
        $amount = 50000;
    } elseif ($package == 3) {
        $diamond = 465;
        $amount = 100000;
    } elseif ($package == 4) {
        $diamond = 950;
        $amount = 200000;
    } elseif ($package == 5) {
        $diamond = 2375;
        $amount = 500000;
    }

    if (!@$getUser) {
        echo JsonMsg('error', 'Vui lòng đăng nhập để sử dụng tính năng');
    } elseif ($SIEUTHICODE->site('status_diamond') != '1') {
        echo JsonMsg('error', 'Chức năng rút kim cương đang bảo trì tạm thời');
    } elseif ($diamond > $getUser['diamond']) {
        echo JsonMsg('error', 'Bạn không đủ kim cương để rút gói này');
    } elseif (empty($datagame)) {
        echo JsonMsg('error', 'Vui lòng nhập dữ liệu');
    } elseif (empty($package)) {
        echo JsonMsg('error', 'Vui lòng chọn gói kim cương');
    } elseif ($getUser['banned'] == '1') {
        echo JsonMsg('error', 'Tài khoản của quý khách đã bị khóa');
    } else {
        $json['author'] = 'SIEUTHICODE.NET';
        $json['diamond'] = $diamond;
        $json['amount'] = $amount;
        $json['datagame'] = encryptData($datagame);//mã hóa dữ liệu
        $full_json = json_encode($json);
        $isOrder = $SIEUTHICODE->insert("withdraw", [
            'user_id' => $getUser['id'],
            'detail' => $full_json,
            'create_date' => time(),
            'update_date' => time(),
        ]);
        $SIEUTHICODE->update("users", [
            'diamond' => $getUser['diamond'] - $diamond
        ], " `username` = '".$getUser['username']."' ");
        insert_log($getUser['id'], 'Rút gói ' . $diamond . ' kim cương thành công');
    
        echo JsonMsg('success', 'Rút gói ' . $diamond . ' kim cương thành công');
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
