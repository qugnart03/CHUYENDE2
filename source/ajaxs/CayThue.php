<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
require_once '../class/class.smtp.php';
require_once '../class/PHPMailerAutoload.php';
require_once '../class/class.phpmailer.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'Order') {
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập để thanh toán !'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "' AND `banned` = '1' ")) {
            die(JsonMsg('error', 'Tài khoản này đã bị khóa bởi BQT!'));
        }
        if ($SIEUTHICODE->site("status_demo") == "ON") {
            die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
        }
        $tk = Anti_xss($_POST['tk']);
        $mk = Anti_xss($_POST['mk']);
        $dichvu = Anti_xss($_POST['dichvu']);
        $ghichu = Anti_xss($_POST['ghichu']);
        $server = Anti_xss($_POST['server']);
        if (empty($dichvu)) {
            die(JsonMsg('error', 'Vui lòng chọn gói dịch vụ!'));
        }
        if (empty($tk)) {
            die(JsonMsg('error', 'Vui lòng nhập tài khoản đăng nhập game!'));
        }
        if (empty($mk)) {
            die(JsonMsg('error', 'Vui lòng nhập mật khẩu đăng nhập game!'));
        }
        $group = $SIEUTHICODE->get_row("SELECT * FROM `groups_caythue` WHERE `id` = '$dichvu' ");
        if (!$group['title']) {
            die(JsonMsg('error', 'Dịch vụ không hợp lệ!'));
        }
        if ($group['money'] > $getUser['money']) {
            die(JsonMsg('error', 'Số dư không đủ vui lòng nạp thêm!'));
        }
        $isMoney = $SIEUTHICODE->tru("users", "money", $group['money'], " `username` = '" . $getUser['username'] . "' ");
        if ($isMoney) {
            $isOrder = $SIEUTHICODE->insert("orders_caythue", [
                'username' => $getUser['username'],
                'dichvu_id'=>$group['id'],
                'dichvu' => $group['title'],
                'money' => $group['money'],
                'tk' => encryptData($tk),
                'mk' => encryptData($mk),
                'maychu'=>$server,
                'createdate' => gettime(),
                'updatedate' => gettime(),
                'status' => 'xuly',
                'ghichu' => $ghichu,
            ]);
            if ($isOrder) {
                /* GHI LOG DÒNG TIỀN */
                $SIEUTHICODE->insert("dongtien", array(
                    'sotientruoc' => $getUser['money'] ,
                    'sotienthaydoi' => $group['money'],
                    'sotiensau' => $getUser['money'] - $group['money'],
                    'thoigian' => gettime(),
                    'noidung' => 'Đặt hàng gói (' . $group['title'] . ')',
                    'username' => $getUser['username'],
                ));
                die(JsonMsg('success', 'Thanh toán thành công !'));
            } else {
                $SIEUTHICODE->cong("users", "money", $group['money'], " `username` = '" . $getUser['username'] . "' ");
                die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
            }
        } else {
            die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
        }
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
