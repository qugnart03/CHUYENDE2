<?php
    require_once("../config/config.php");
    require_once("../config/function.php");

    if($SIEUTHICODE->site('token_acb') == '')
    {
        die('Thiếu API');
    }
    // if(time() - $SIEUTHICODE->site('check_time_cron_bank') < 30)
    // {
    //     die('Không thể cron vào lúc này!');
    // }
    // $SIEUTHICODE->update("options", [
    //     'value' => time()
    // ], " `name` = 'check_time_cron_bank' ");
    
    $token = $SIEUTHICODE->site('token_acb');
    $result = curl_get("https://api.sieuthicode.net/historyapiacb/$token");
    $result = json_decode($result, true);
    if(!isset($result['data'])){
        exit('Không thể lấy được dữ liệu');
    }
    foreach ($result['data'] as $data)
    {
        if($data['type'] != 'IN') continue;
        $des = $data['description'];
        $amount = $data['amount'];
        $tid = $data['transactionNumber'];
        $id = parse_order_id($des);
        if ($id)
        {
            $row = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `id` = '$id' ");
            if($row['username'])
            {
                if($SIEUTHICODE->num_rows(" SELECT * FROM `bank_auto` WHERE `tid` = '$tid' ") == 0)
                {
                    /* GHI LOG BANK AUTO */
                    $create = $SIEUTHICODE->insert("bank_auto", array(
                        'tid' => $tid,
                        'description' => $des,
                        'amount' => $amount,
                        'time' => gettime(),
                        'username' => $row['username']
                        ));
                    if ($create)
                    {
                        $real_amount = $amount + $amount * $SIEUTHICODE->site('ck_bank') / 100;
                        $isCheckMoney = $SIEUTHICODE->cong("users", "money", $real_amount, " `username` = '".$row['username']."' ");
                        if($isCheckMoney)
                        {
                            $SIEUTHICODE->cong("users", "total_money", $real_amount, " `username` = '".$row['username']."' ");
                            /* GHI LOG DÒNG TIỀN */
                            $SIEUTHICODE->insert("dongtien", array(
                                'sotientruoc' => $row['money'],
                                'sotienthaydoi' => $real_amount,
                                'sotiensau' => $row['money'] + $real_amount,
                                'thoigian' => gettime(),
                                'noidung' => 'Nạp tiền tự động ngân hàng (ACB | '.$tid.')',
                                'username' => $row['username']
                            ));
                        }
                    }
                }
            }
        }    
    }

