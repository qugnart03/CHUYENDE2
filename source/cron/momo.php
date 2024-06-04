<?php
    require_once("../config/config.php");
    require_once("../config/function.php");

    if($SIEUTHICODE->site('api_momo') == '')
    {
        die('Thiếu API');
    }
    if(time() - $SIEUTHICODE->site('check_time_cron') < 5)
    {
        die('Không thể cron vào lúc này!');
    }
    $SIEUTHICODE->update("options", [
        'value' => time()
    ], " `name` = 'check_time_cron' ");
    $token = $SIEUTHICODE->site('api_momo');
    $result = curl_get("https://api.sieuthicode.net/historyapimomo/$token");
    $result = json_decode($result, true);
    foreach($result['momoMsg']['tranList'] as $data)
    {
        $partnerId      = $data['partnerId'];               // SỐ ĐIỆN THOẠI CHUYỂN
        $comment        = $data['comment'];                 // NỘI DUNG CHUYỂN TIỀN
        $tranId         = $data['tranId'];                  // MÃ GIAO DỊCH
        $partnerName    = $data['partnerName'];             // TÊN CHỦ VÍ
        $id_momo        = parse_order_id($comment);         // TÁCH NỘI DUNG CHUYỂN TIỀN
        $amount         = $data['amount'];

        $file = @fopen('LogMOMO.txt', 'a');
        if ($file)
        {
            $data = "partnerId => $partnerId comment => $comment ($id_momo) amount => $amount partnerName => $partnerName".PHP_EOL;
            fwrite($file, $data);
        }
        if ($id_momo)
        {
            $row = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `id` = '$id_momo' ");
            if($row['id'])
            {
                if($SIEUTHICODE->num_rows(" SELECT * FROM `momo` WHERE `tranId` = '$tranId' ") == 0)
                {
                    $create = $SIEUTHICODE->insert("momo", array(
                        'tranId'        => $tranId,
                        'username'      => $row['username'],
                        'comment'       => $comment,
                        'time'          => gettime(),
                        'partnerId'     => $partnerId,
                        'amount'        => $amount,
                        'partnerName'   => $partnerName
                    ));
                    if ($create)
                    {
                        $real_amount = $amount + $amount * $SIEUTHICODE->site('ck_bank') / 100;
                        $isCheckMoney = $SIEUTHICODE->cong("users", "money", $real_amount, " `username` = '".$row['username']."' ");

                        if($isCheckMoney)
                        {
                            $SIEUTHICODE->cong("users", "total_money", $real_amount, " `username` = '".$row['username']."' ");
                            $SIEUTHICODE->insert("dongtien", array(
                                'sotientruoc'   => $row['money'],
                                'sotienthaydoi' => $real_amount,
                                'sotiensau'     => $row['money'] + $real_amount,
                                'thoigian'      => gettime(),
                                'noidung'       => 'Nạp tiền tự động qua ví MOMO ('.$tranId.')',
                                'username'      => $row['username']
                            ));
                        }
                    }
                }
            }
        }         
    }
 