<?php
    require_once("../config/config.php");
    require_once("../config/function.php");

    if (isset($_GET['status']) && $_GET['code'] && $_GET['serial'] && $_GET['trans_id'] && $_GET['telco'] && $_GET['callback_sign']) {
        // TRẠNG THÁI
        $status = Anti_xss($_GET['status']);
        // SERIAL THẺ NẠP
        $serial = Anti_xss($_GET['serial']);
        // MÃ THẺ NẠP
        $code = Anti_xss($_GET['code']);
        // MÃ REQUEST
        $request_id = Anti_xss($_GET['request_id']);
        // TRẠNG THÁI TIN NHẮN (THẤT BẠI - THÀNH CÔNG) TỪ THESIEURE
        $message = Anti_xss($_GET['message']);
        // MỆNH GIÁ GỐC THẺ NẠP
        $real_money = Anti_xss($_GET['value']);
        // MỆNH GIÁ THỰC NHẬN
        $geted_money = Anti_xss($_GET['amount']);
        // NHÀ MẠNG THẺ CÀO
        $nhamang = Anti_xss($_GET['telco']);
        // ĐƠN GIAO DỊCH BÊN THESIEURE
        $trans_id = Anti_xss($_GET['trans_id']);
        // KIỂM TRA CHỮ KÝ MD5
        $check_sign = md5($SIEUTHICODE->site('partner_key_card') . $code . $serial);
    
        // KIỂM TRA CHỮ KÝ HỢP LỆ TRÁNH TRƯỜNG HỢP BUG
        if (Anti_xss($_GET['callback_sign']) == $check_sign) {
            $row = $SIEUTHICODE->get_row(" SELECT * FROM `cards` WHERE `code` = '$request_id' AND `status` = 'xuly' ");
            if (!$row) {
                die("Cái quát đờ phắc gì vậy?");
            }
            $row_user = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `id` = '" . $row['user_id'] . "' ");
            if ($status == 1) {
                $thucnhan = $geted_money;
    
                /* CẬP NHẬT TRẠNG THÁI THẺ CÀO */
                $SIEUTHICODE->update("cards", array(
                    'status'    => 'thanhcong',
                    'note'      => 'Thẻ cào hợp lệ',
                    'thucnhan'  => $thucnhan
                ), " `id` = '" . $row['id'] . "' ");

                /* CỘNG TIỀN USER */
                $SIEUTHICODE->cong("users", "money", $thucnhan, " `id` = '".$row_user['id']."' ");
                $SIEUTHICODE->cong("users", "total_money", $thucnhan, " `id` = '".$row_user['id']."' ");
                /* GHI LOG DÒNG TIỀN */
                $SIEUTHICODE->insert("dongtien", array(
                    'sotientruoc' => $row_user['money'],
                    'sotienthaydoi' => $thucnhan,
                    'sotiensau' => $row_user['money'] + $thucnhan,
                    'thoigian' => gettime(),
                    'noidung' => 'Nạp tiền tự động qua thẻ cào seri ('.$row['seri'].')',
                    'username' => $row_user['username']
                ));
            } else {
                /* CẬP NHẬT TRẠNG THÁI THẺ CÀO */
                $SIEUTHICODE->update("cards", array(
                    'status'    => 'thatbai',
                    'note'      => 'Thẻ cào không hợp lệ hoặc đã được sử dụng',
                ), " `id` = '" . $row['id'] . "' ");
            }
        } else {
            die(json_encode([
                'status' => 'error',
                'msg'   => 'Truy cập trái phép hệ thống đã lưu IP: ' . myip() . ''
            ]));
        }
    } else {
        die(json_encode([
            'status' => 'error',
            'msg'   => 'Truy cập trái phép hệ thống đã lưu IP: ' . myip() . ''
        ]));
    }

