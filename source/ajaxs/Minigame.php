<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
//error_reporting(0);
header('Content-Type: application/json');
$numrolllop = Anti_xss(preg_replace('/\D/', '',$_POST['numrolllop']));
$typeRoll = Anti_xss($_POST['typeRoll']);
$type = Anti_xss($_POST['type']);
$listgift = array();
$arr_gift = array();
$date = time();
if($SIEUTHICODE->num_rows("SELECT * FROM `minigame` WHERE `type_category` = '{$type}'") == 0){
    $sql = "SELECT * FROM `minigame` WHERE `type_category` = '{$type}'";
}else{
    $sql = "SELECT * FROM `minigame` WHERE `type_category` = '{$type}'";
}
$query = $SIEUTHICODE->get_row($sql);
$detail = json_decode($query['detail'], true);
$data_detail = $detail['data'];
$data_array = $detail['data'];
#tính số lượt quay
	$gia = calculateDiscount($detail['cash'],$detail['sale_cash']) * $numrolllop;
    if($SIEUTHICODE->num_rows("SELECT * FROM `minigame` WHERE `type_category` = '{$type}'") < 1){
        $json['status'] = 'error';
        $json['msg'] = 'Không tìm thấy dữ liệu trò chơi';
    }elseif($numrolllop < 0){
        $json['status'] = 'error';
        $json['msg'] = 'Số lượt chơi không được bé hơn 0';
    }elseif($SIEUTHICODE->site('baotri') == 'OFF'){
        $json['status'] == 'error';
        $json['msg'] = 'Trang web hiện tại đang bảo trì';
    }elseif($numrolllop < 0 || $numrolllop > 10){
        $json['status'] = 'error';
        $json['msg'] = 'Số lượt quay không hợp lệ';
    }else{
        if($typeRoll == 'play'){
            if(!@$getUser){
                $json['status'] = 'login';
                $json['msg'] = 'Bạn chưa đăng nhập';
            }elseif($getUser['banned'] == '1'){
                $json['status'] = 'error';
                $json['msg'] = 'Tài khoản bạn đã bị khóa, vui lòng liên hệ admin';
            }elseif($getUser['money'] < $gia){
                $json['status'] = 'error';
                $json['msg'] = 'Bạn không đủ tiền để thực hiện giao dịch này';
            }else{
                if($detail['cash'] == '0'){
                    if($getUser['turn_wheel'] < $numrolllop){
                        $json['status'] = 'error';
                        $json['msg'] = 'Bạn không đủ lượt quay';
                    }else{
                        if($SIEUTHICODE->num_rows("SELECT * FROM `account_reward` WHERE `status` = 'on' AND `type_category` = '{$type}'") < $numrolllop){
                        // $json['status'] = 'login';
                        // $json['msg'] = 'Đã hết tài khoản trong kho';
                        die(JsonMsg('error','Số lượng tài khoản đã hết'));
                    }
                        $loop_wheel = loop_wheel($numrolllop,$type,$detail,$query);
                        insert_log($getUser['id'], 'Chơi trò chơi '.$detail['name_product'].' x'.$numrolllop.'');
                        //$SIEUTHICODE->query("UPDATE `users` SET `turn_wheel` = `turn_wheel` - '{$numrolllop}',`cash` = `cash` + '{$loop_wheel['count_price']}',`diamond` = `diamond` + '{$loop_wheel['count_kc']}',`updated_at` = '{$date}' WHERE `username` = '{$data_user['username']}'");
                        $SIEUTHICODE->update("users", [
                            'turn_wheel' => $getUser['turn_wheel'] - $numrolllop,
                            'diamond' => $getUser['diamond'] + $loop_wheel['count_kc']
                        ], " `username` = '".$getUser['username']."' ");
                        if($data_array[$loop_wheel['get_num']]['tyle_type'] == 'NO'){
                            $locale = '1';
                        }else{
                            $locale = '0';
                        }
                        $json['msg'] = array("name" => $loop_wheel['msg'], "pos" => $loop_wheel['get_num']+1, "locale" => $locale, "image" => BASE_URL($loop_wheel['img']), "num_roll_remain" => $getUser['turn_wheel']-$numrolllop);
                        $json['typeRoll'] = 'Quay Thật';
                        $json['arr_gift'] = $loop_wheel['arr_gift'];
                        $json['total'] = number_format($loop_wheel['count_kc']);
                        $json['price'] = number_format($gia); 
                        if($query['type'] == 'LATHINH'){
                            $json['listgift'] = $loop_wheel['listgift'];
                        }

                        $wheel['msg'] = 'Trúng '.$loop_wheel['count_kc'].' Thỏi vàng';
                        $wheel['name'] = $getUser['username'];
                        $full_wheel = json_encode($wheel);
                        if($loop_wheel['count_kc'] > 1){
                            $SIEUTHICODE->insert("log_wheel", [
                                'user_id' => $getUser['id'],
                                'type' => $type,
                                'detail' => $full_wheel,
                                'create_date' => time(),
                                'update_date' => time()
                            ]);
                            //$SIEUTHICODE->query("INSERT INTO `log_wheel`(`user_id`, `type`, `detail`, `created_date`, `updated_date`) VALUES ('{$getUser['id']}', '{$type}', '{$full_wheel}', '{$date}', '{$date}')");
                        }
                    }
                }else{
                    if($SIEUTHICODE->num_rows("SELECT * FROM `account_reward` WHERE `status` = 'on' AND `type_category` = '{$type}'") < $numrolllop){
                        // $json['status'] = 'login';
                        // $json['msg'] = 'Đã hết tài khoản trong kho';
                        die(JsonMsg('error','Số lượng tài khoản trong kho không còn đủ'));
                    }
                    $loop_wheel = loop_wheel($numrolllop,$type,$detail,$query);
                 
                    insert_log($getUser['id'],'Chơi trò chơi '.$detail['name_product'].' x'.$numrolllop.'');
                    // $SIEUTHICODE->update("users", [
                    //     'money' => ($getUser['money'] - $gia) + $loop_wheel['count_price'],
                    //     'diamond' => $getUser['diamond'] + $loop_wheel['count_kc']
                    // ], " `username` = '".$getUser['username']."' ");
                    
                    if($data_array[$loop_wheel['get_num']]['tyle_type'] == 'NO'){
                        $locale = '1';
                    }else{
                        $locale = '0';
                    }
                    $json['msg'] = array("name" => $loop_wheel['msg'], "pos" => $loop_wheel['get_num']+1, "locale" => $locale, "image" => BASE_URL($loop_wheel['img']), "num_roll_remain" => floor(($getUser['money']-$gia+$loop_wheel['count_price'])/calculateDiscount($detail['cash'],$detail['sale_cash'])));
                    $json['typeRoll'] = 'Quay Thật';
                    $json['arr_gift'] = $loop_wheel['arr_gift'];
                    $json['total'] = number_format($loop_wheel['count_kc']);
                    $json['price'] = number_format($gia);
                    if($query['type'] == 'LATHINH'){
                        $json['listgift'] = $loop_wheel['listgift'];
                    }

                    $wheel['msg'] = 'Trúng '.$loop_wheel['count_kc'].' Thỏi vàng';
                    $wheel['name'] = $getUser['username'];
                    $full_wheel =json_encode($wheel);
                    if($loop_wheel['count_kc'] > 1){
                        $SIEUTHICODE->insert("log_wheel", [
                            'user_id' => $getUser['id'],
                            'type' => $type,
                            'detail' => $full_wheel,
                            'create_date' => time(),
                            'update_date' => time()
                        ]);
                    }
                }
            }
        }elseif($typeRoll == 'try'){
            $count_kc = 0;
            for($i=0; $i < $numrolllop; $i++){
                $get_num = rand(0,count($data_detail)-2);
                if($data_detail[$get_num]){
                    if($data_detail[$get_num]['tyle_type'] == 'KCRD'){
                        $kc = rand(12,500);
                    }elseif($data_detail[$get_num]['tyle_type'] == 'KC'){
                        $kc = $data_detail[$get_num]['tyle_value'];
                    }elseif($data_detail[$get_num]['tyle_type'] == 'PRICE'){
                        $kc = '0';
                        $price = $data_detail[$get_num]['tyle_value'];
                    }elseif($data_detail[$get_num]['tyle_type'] == 'NO'){
                        $kc = '0';
                        $price = '0';
                    }
                    $msg = str_replace('...',$kc,$data_detail[$get_num]['tyle_text']);
                }
                array_push($arr_gift, array("title" => $msg));
                $count_kc += $kc;
                if($query['type'] == 'LATHINH'){
                    $img = $data_detail[$get_num]['item'];
                    for($a=0; $a < count($data_detail); $a++){
                        if($a != $get_num){
                            array_push($listgift, array("image" => $data_detail[$a]['item']));
                        }
                    }
                }
            }
            if($data_detail[$get_num]['tyle_type'] == 'NO'){
                $locale = '1';
            }else{
                $locale = '0';
            }
            $json['msg'] = array("name" => $msg, "pos" => $get_num+1, "locale" => $locale, "num_roll_remain" => '1', "image" => BASE_URL($data_detail[$get_num]['item']));
            $json['typeRoll'] = 'Quay Thử';
            $json['arr_gift'] = $arr_gift;
            $json['total'] = number_format($count_kc);
            $json['price'] = number_format($gia);
            if($query['type'] == 'LATHINH'){
                $json['listgift'] = $listgift;
            }
        }
    }
    echo json_encode($json);