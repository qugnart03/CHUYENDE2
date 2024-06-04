<?php
    require_once("../config/config.php");
    require_once("../config/function.php");

    if($SIEUTHICODE->site('api_bank') == '')
    {
        die('Thiếu API');
    }

    
    $token = $SIEUTHICODE->site('api_bank');
    $result = curl_get("https://api.sieuthicode.net/historyapimbbank/$token");
    $result = json_decode($result, true);
    if(!isset($result['TranList'])){
        exit('Không thể lấy được dữ liệu');
    }
    foreach ($result['TranList'] as $data)
    {
        $des = $data['description'];
        $amount = $data['creditAmount'];
        $tid = explode('\\', $data['tranId'])[0];
        $id = parse_order_id($des);
        
        $file = @fopen('LogBank.txt', 'a');
        if ($file)
        {
            $data = "tid => $tid description => $des ($id) amount => $amount ".PHP_EOL;
            fwrite($file, $data);
        }
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
                                'noidung' => 'Nạp tiền tự động ngân hàng (Mbbank | '.$tid.')',
                                'username' => $row['username']
                            ));
                        }
                    }
                }
            }
        }    
    }

