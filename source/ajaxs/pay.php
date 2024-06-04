<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'coin') {
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập để thanh toán !'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "' AND `banned` = '1' ")) {
            die(JsonMsg('error', 'Tài khoản này đã bị khóa bởi BQT!'));
        }
        if ($SIEUTHICODE->site("status_demo") == "ON") {
            die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
        }
        $user = Anti_xss($_POST['user']);
        $server = Anti_xss(preg_replace('/\D/', '', $_POST['server']));
        $money = Anti_xss(preg_replace('/\D/', '', $_POST['money']));

        if (empty($server)) {
            die(JsonMsg('error', 'Vui lòng chọn máy chủ!'));
        }
        if (empty($user)) {
            die(JsonMsg('error', 'Vui lòng nhập tên nhân vật!'));
        }
        if (empty($money)) {
            die(JsonMsg('error', 'Vui lòng nhập số tiền!'));
        }
        $checkServerCoin = $SIEUTHICODE->get_row("SELECT * FROM `coin_nro` WHERE `id` = '$server' AND `status` = 1");
        if (!$checkServerCoin) {
            die(JsonMsg('error', 'Máy chủ không hợp lệ'));
        }
        if ($money < $checkServerCoin['min_value'] || $money > $checkServerCoin['max_value']) {
            die(JsonMsg('error', 'Bạn chỉ có thể thanh toán số tiền từ ' . format_cash($checkServerCoin['min_value']) . ' đến ' . format_cash($checkServerCoin['max_value'])));
        }
        if ($money > $getUser['money']) {
            die(JsonMsg('error', 'Số dư không đủ vui lòng nạp thêm!'));
        }
        $gold_number = $checkServerCoin['factor'] * $money;
        $isMoney = $SIEUTHICODE->tru("users", "money", $money, " `username` = '" . $getUser['username'] . "' ");
        if ($isMoney) {
            $isOrder = $SIEUTHICODE->insert("history_coin_nro", [
                'user_id' => $getUser['id'],
                'server_nro' => $checkServerCoin['server_nro'],
                'player' => trim($user),
                'cash' => $money,
                'gold_number' => $gold_number,
                'gold_bar' => tinhSoVangDu($gold_number)['soThoiVang'],
                'remaining' => tinhSoVangDu($gold_number)['soVangDu'],
                'status' => '0',
                'created_at' => gettime(),
                'updated_at' => gettime(),
            ]);
            if ($isOrder) {
                /* GHI LOG DÒNG TIỀN */
                $SIEUTHICODE->insert("dongtien", array(
                    'sotientruoc' => $getUser['money'],
                    'sotienthaydoi' => $money,
                    'sotiensau' => $getUser['money'] - $money,
                    'thoigian' => gettime(),
                    'noidung' => 'Mua vàng tự động (' . format_cash($gold_number) . ' gold - ' . format_cash($money) . ' vnđ)',
                    'username' => $getUser['username'],
                ));
                insert_log($getUser['id'], 'Mua vàng tự động (' . format_cash($gold_number) . ' gold - ' . format_cash($money) . ' vnđ)');
                die(JsonMsg('success', 'Thanh toán thành công !'));
            } else {
                insert_log($getUser['id'], 'Hoàn tiền do mua vàng lỗi');
                $SIEUTHICODE->cong("users", "money", $money, " `username` = '" . $getUser['username'] . "' ");
                die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
            }
        } else {
            die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
        }
    }
    if ($_POST['type'] == 'coinlau') {
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập để thanh toán !'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "' AND `banned` = '1' ")) {
            die(JsonMsg('error', 'Tài khoản này đã bị khóa bởi BQT!'));
        }
        if ($SIEUTHICODE->site("status_demo") == "ON") {
            die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
        }
        $user = Anti_xss($_POST['user']);
        $server = Anti_xss(preg_replace('/\D/', '', $_POST['server']));
        $money = Anti_xss(preg_replace('/\D/', '', $_POST['money']));

        if (empty($server)) {
            die(JsonMsg('error', 'Vui lòng chọn máy chủ!'));
        }
        if (empty($user)) {
            die(JsonMsg('error', 'Vui lòng nhập tên nhân vật!'));
        }
        if (empty($money)) {
            die(JsonMsg('error', 'Vui lòng nhập số tiền!'));
        }
        $checkServerCoin = $SIEUTHICODE->get_row("SELECT * FROM `coin_nro_lau` WHERE `id` = '$server' AND `status` = 1");
        if (!$checkServerCoin) {
            die(JsonMsg('error', 'Máy chủ không hợp lệ'));
        }
        if ($money < $checkServerCoin['min_value'] || $money > $checkServerCoin['max_value']) {
            die(JsonMsg('error', 'Bạn chỉ có thể thanh toán số tiền từ ' . format_cash($checkServerCoin['min_value']) . ' đến ' . format_cash($checkServerCoin['max_value'])));
        }
        if ($money > $getUser['money']) {
            die(JsonMsg('error', 'Số dư không đủ vui lòng nạp thêm!'));
        }
        $gold_number = $checkServerCoin['factor'] * $money /1000;
        $isMoney = $SIEUTHICODE->tru("users", "money", $money, " `username` = '" . $getUser['username'] . "' ");
        if ($isMoney) {
            $isOrder = $SIEUTHICODE->insert("history_coin_nro_lau", [
                'user_id' => $getUser['id'],
                'server_nro' => $checkServerCoin['server_nro'],
                'player' => trim($user),
                'cash' => $money,
                'gold_number' => $gold_number,
                'gold_bar' => $gold_number,
                'remaining' => $gold_number,
                'status' => '0',
                'created_at' => gettime(),
                'updated_at' => gettime(),
            ]);
            if ($isOrder) {
                if ($SIEUTHICODE->site('chat_id') != '' && $SIEUTHICODE->site('token_tele') != '') {
                    $data = 'Có một đơn hàng mua vàng mới!
                Nhân vật: ' . $user . '
                Máy chủ: ' . $checkServerCoin['server_nro'] . ' sao
                Thanh toán: ' . format_cash($money) . 'đ
                Thỏi vàng: ' . format_cash($gold_number) . '
                Thời gian mua: ' . gettime() . '
                    ';
                    BotTele($SIEUTHICODE->site('chat_id'), $SIEUTHICODE->site('token_tele'), $data);
                }
                /* GHI LOG DÒNG TIỀN */
                $SIEUTHICODE->insert("dongtien", array(
                    'sotientruoc' => $getUser['money'],
                    'sotienthaydoi' => $money,
                    'sotiensau' => $getUser['money'] - $money,
                    'thoigian' => gettime(),
                    'noidung' => 'Mua vàng tự động (' . format_cash($gold_number) . ' gold - ' . format_cash($money) . ' vnđ)',
                    'username' => $getUser['username'],
                ));
                insert_log($getUser['id'], 'Mua vàng tự động (' . format_cash($gold_number) . ' gold - ' . format_cash($money) . ' vnđ)');
                die(JsonMsg('success', 'Thanh toán thành công !'));
            } else {
                insert_log($getUser['id'], 'Hoàn tiền do mua vàng lỗi');
                $SIEUTHICODE->cong("users", "money", $money, " `username` = '" . $getUser['username'] . "' ");
                die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
            }
        } else {
            die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
        }
    }
    if ($_POST['type'] == 'gem') {
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập để thanh toán !'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "' AND `banned` = '1' ")) {
            die(JsonMsg('error', 'Tài khoản này đã bị khóa bởi BQT!'));
        }
        if ($SIEUTHICODE->site("status_demo") == "ON") {
            die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
        }
        $user = Anti_xss($_POST['user']);
        $server = Anti_xss(preg_replace('/\D/', '', $_POST['server']));
        $money = Anti_xss(preg_replace('/\D/', '', $_POST['money']));

        if (empty($server)) {
            die(JsonMsg('error', 'Vui lòng chọn máy chủ!'));
        }
        if (empty($user)) {
            die(JsonMsg('error', 'Vui lòng nhập tên nhân vật!'));
        }
        if (empty($money)) {
            die(JsonMsg('error', 'Vui lòng nhập số tiền!'));
        }
        $checkServerCoin = $SIEUTHICODE->get_row("SELECT * FROM `gem_nro` WHERE `id` = '$server' AND `status` = 1");
        if (!$checkServerCoin) {
            die(JsonMsg('error', 'Máy chủ không hợp lệ'));
        }
        if ($money < $checkServerCoin['min_value'] || $money > $checkServerCoin['max_value']) {
            die(JsonMsg('error', 'Bạn chỉ có thể thanh toán số tiền từ ' . format_cash($checkServerCoin['min_value']) . ' đến ' . format_cash($checkServerCoin['max_value'])));
        }
        if ($money > $getUser['money']) {
            die(JsonMsg('error', 'Số dư không đủ vui lòng nạp thêm!'));
        }
        $gem_number = $checkServerCoin['factor'] * $money / 1000;
        $isMoney = $SIEUTHICODE->tru("users", "money", $money, " `username` = '" . $getUser['username'] . "' ");
        if ($isMoney) {
            $isOrder = $SIEUTHICODE->insert("history_gem_nro", [
                'user_id' => $getUser['id'],
                'server_nro' => $checkServerCoin['server_nro'],
                'player' => trim($user),
                'cash' => $money,
                'gem_number' => $gem_number,
                'status' => '0',
                'created_at' => gettime(),
                'updated_at' => gettime(),
            ]);
            if ($isOrder) {
                /* GHI LOG DÒNG TIỀN */
                $SIEUTHICODE->insert("dongtien", array(
                    'sotientruoc' => $getUser['money'],
                    'sotienthaydoi' => $money,
                    'sotiensau' => $getUser['money'] - $money,
                    'thoigian' => gettime(),
                    'noidung' => 'Mua ngọc tự động (' . format_cash($gem_number) . ' gem - ' . format_cash($money) . ' vnđ)',
                    'username' => $getUser['username'],
                ));
                insert_log($getUser['id'], 'Mua ngọc tự động (' . format_cash($gem_number) . ' gem - ' . format_cash($money) . ' vnđ)');
                die(JsonMsg('success', 'Thanh toán thành công !'));
            } else {
                insert_log($getUser['id'], 'Hoàn tiền do mua ngọc lỗi');
                $SIEUTHICODE->cong("users", "money", $money, " `username` = '" . $getUser['username'] . "' ");
                die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
            }
        } else {
            die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
        }
    }
    if ($_POST['type'] == 'gemapi') {
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập để thanh toán !'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "' AND `banned` = '1' ")) {
            die(JsonMsg('error', 'Tài khoản này đã bị khóa bởi BQT!'));
        }
        if ($SIEUTHICODE->site("status_demo") == "ON") {
            die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
        }
        $user = Anti_xss($_POST['user']);
        $pass = Anti_xss($_POST['pass']);
        $server = Anti_xss(preg_replace('/\D/', '', $_POST['server']));
        $money = Anti_xss(preg_replace('/\D/', '', $_POST['money']));
        if (empty($server)) {
            die(JsonMsg('error', 'Vui lòng chọn máy chủ!'));
        }
        if (empty($money)) {
            die(JsonMsg('error', 'Vui lòng nhập số tiền!'));
        }
        if (empty($user)) {
            die(JsonMsg('error', 'Vui lòng nhập tài khoản game!'));
        }
        if (empty($pass)) {
            die(JsonMsg('error', 'Vui lòng nhập mật khẩu game!'));
        }
        $checkServerCoin = $SIEUTHICODE->get_row("SELECT * FROM `gem_api_nro` WHERE `id` = '$server' AND `status` = 1");
        if (!$checkServerCoin) {
            die(JsonMsg('error', 'Máy chủ không hợp lệ'));
        }
        if ($money < $checkServerCoin['min_value'] || $money > $checkServerCoin['max_value']) {
            die(JsonMsg('error', 'Bạn chỉ có thể thanh toán số tiền từ ' . format_cash($checkServerCoin['min_value']) . ' đến ' . format_cash($checkServerCoin['max_value'])));
        }
        if ($money > $getUser['money']) {
            die(JsonMsg('error', 'Số dư không đủ vui lòng nạp thêm!'));
        }
        $gem_number = $checkServerCoin['factor'] * $money / 1000;
        $isMoney = $SIEUTHICODE->tru("users", "money", $money, " `username` = '" . $getUser['username'] . "' ");
        if ($isMoney) {
            $tranid = time() . rand(10000, 99999);
            $response = DAILY_SERVICE($tranid, $server, $user, $pass, $gem_number);
            if ($response['status'] == 2) {
                $isOrder = $SIEUTHICODE->insert("history_gem_api_nro", [
                    'request_id' => $tranid,
                    'user_id' => $getUser['id'],
                    'server_nro' => $checkServerCoin['server_nro'],
                    'user' => trim($user),
                    'pass' => trim($pass),
                    'cash' => $money,
                    'gem_number' => $gem_number,
                    'status' => '1',
                    'created_at' => gettime(),
                    'updated_at' => gettime(),
                ]);
                if ($isOrder) {
                    /* GHI LOG DÒNG TIỀN */
                    $SIEUTHICODE->insert("dongtien", array(
                        'sotientruoc' => $getUser['money'],
                        'sotienthaydoi' => $money,
                        'sotiensau' => $getUser['money'] - $money,
                        'thoigian' => gettime(),
                        'noidung' => 'Ký ngọc tự động (' . format_cash($gem_number) . ' gem - ' . format_cash($money) . ' vnđ)',
                        'username' => $getUser['username'],
                    ));
                    insert_log($getUser['id'], 'Ký ngọc tự động (' . format_cash($gem_number) . ' gem - ' . format_cash($money) . ' vnđ)');
                    die(JsonMsg('success', $response['message']));
                } else {
                    die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
                }
            } else {
                insert_log($getUser['id'], $response['message'] . ' ' . '(' . format_cash($gem_number) . ' gem - ' . format_cash($money) . ' vnđ)');
                die(JsonMsg('error', $response['message']));
            }

        } else {
            die(JsonMsg('error', 'Không thể xử lý giao dịch, vui lòng thử lại !'));
        }
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
