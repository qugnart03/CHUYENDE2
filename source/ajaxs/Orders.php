<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = Anti_xss(preg_replace('/\D/', '', $_POST['id']));
        $arr_data = array();
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập để thanh toán !'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "' AND `banned` = '1' ")) {
            die(JsonMsg('error', 'Tài khoản này đã bị khóa bởi BQT!'));
        }
        if ($SIEUTHICODE->site("status_demo") == "ON") {
            die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
        }
        $row = $SIEUTHICODE->get_row(" SELECT * FROM `accounts` WHERE `id` = '$id'  ");
        if (!$row) {
            die(JsonMsg('error', 'Không tìm thấy tài khoản!'));
        }
        if ($row['status'] == 'off') {
            die(JsonMsg('error', 'Tài khoản này đã bán, vui lòng tìm tài khoản khác !'));
        }
        $price = $row['money'] - (($row['money'] * $row['sale']) / 100);
        if ($price > $getUser['money']) {
            die(JsonMsg('error', 'Số dư không đủ vui lòng nạp thêm !'));
        }
        
        $isMoney = $SIEUTHICODE->tru("users", "money", $price, " `username` = '" . $getUser['username'] . "' ");
        if ($isMoney) {
            $detail = json_decode($row['detail'], true);
            for ($i=0; $i < count($detail['data']); $i++) {
               
                    
            array_push($arr_data, array("id" => $i, "label" => $detail['data'][$i]['label'], "type" => $detail['data'][$i]['type'], "name" => $detail['data'][$i]['name'], "value" => $detail['data'][$i]['value'], "show" => $detail['data'][$i]['show'], $detail['data'][$i]['name'] => $detail['data'][$i]['value']));
                    
               
            }
            $json['name_product'] = $detail['name_product'];
            $json['data'] = $arr_data;
            $full_detail = addslashes(json_encode($json));
            insert_log($getUser['id'], 'Mua tài khoản #'.$id.' '.$detail['name_product'].'');
            /* GHI LOG DÒNG TIỀN */
            $SIEUTHICODE->insert("dongtien", array(
                'sotientruoc' => $getUser['money'],
                'sotienthaydoi' => $price,
                'sotiensau' => $getUser['money'] - $price,
                'thoigian' => gettime(),
                'noidung' => 'Mua tài khoản #'.$id.' '.$detail['name_product'].'',
                'username' => $getUser['username'],
            ));
            

            $SIEUTHICODE->update("accounts", [
                'status' => 'off',
                'updated_at' => time(),
            ], " `id` = '" . $row['id'] . "' ");
            $date = time();
            $SIEUTHICODE->query("INSERT INTO `history_buy`(`id_acc`, `type_category`, `username`, `username_post`, `detail`, `cash`, `updated_at`, `created_at`) VALUES ('{$id}', '{$row['type_category']}', '{$getUser['username']}', '{$row['username_post']}', '{$full_detail}', '{$price}', '{$date}', '{$date}')");
            $realMoney = $price - $price * $SIEUTHICODE->site('chietkhau_banacc') /100;
            $SIEUTHICODE->query("UPDATE `users` SET `money` = `money` + '{$realMoney}' WHERE `username` = '{$row['username_post']}'"); 
            die(JsonMsg('success', 'Thanh toán thành công, chuyển hướng đến lịch sử mua !'));
        }
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
