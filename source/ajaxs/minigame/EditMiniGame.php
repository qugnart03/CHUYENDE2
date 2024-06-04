<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
//error_reporting(0);
$id = Anti_xss($_POST['id']);
$name_game = Anti_xss($_POST['name_game']); // tên trò chơi
$type_category = create_slug($name_game); // key trò chơi
$type_game = Anti_xss($_POST['type_game']); // loại game
$cash = Anti_xss($_POST['cash']);
$sale_cash = Anti_xss($_POST['sale_cash']);
$fake_spin = Anti_xss($_POST['fake_spin']);
$tag = Anti_xss($_POST['tag']);
$lenh_admin = Anti_xss($_POST['lenh_admin']);
$lenh_user = Anti_xss($_POST['lenh_user']);
$thele = Anti_xss($_POST['thele']);
$arr_gift = array();
    if(!@$getUser){
        echo JsonMsg('error','Bạn chưa đăng nhập');
    }elseif($getUser['level'] != 'admin'){
        echo JsonMsg('error','Bạn không có quyền truy cập vào trang này');
    }elseif(empty($name_game)){
        echo JsonMsg('error','Vui lòng nhập tên sản phẩm');
    }elseif($SIEUTHICODE->num_rows("SELECT * FROM `minigame` WHERE `id` = '{$id}'") < 1){
        echo JsonMsg('error','Không tìm thấy dữ liệu chỉnh sửa');
    }elseif($cash < 0){
        echo JsonMsg('error','Số tiền không được nhỏ hơn 0');
    }elseif($sale_cash < 0){
        echo JsonMsg('error','Số khuyến mại không được nhỏ hơn 0');
    }elseif($fake_spin < 0){
        echo JsonMsg('error','Fake lượt chơi không được nhỏ hơn 0');
    }elseif(empty($lenh_admin)){
        echo JsonMsg('error','Vui lòng nhập lệnh quay admin');
    }elseif(empty($lenh_user)){
        echo JsonMsg('error','Vui lòng nhập lệnh quay người dùng');
    }else{
  
        
        
        $query = $SIEUTHICODE->get_row("SELECT * FROM `minigame` WHERE `id` = '{$id}'");
        $detail = json_decode($query['detail'], true);
        for($i= 0; $i < count($_POST["tyle_type"]); $i++){
            if($_FILES['item']["error"][$i] == 0){
                $image = upload_multiple_file('item','minigame',$i);
            }else{
                $image = $detail['data'][$i]['item'];
            }
            array_push($arr_gift, array("item" => $image, "tyle_type" => $_POST['tyle_type'][$i], "tyle_value" => $_POST['tyle_value'][$i], "tyle_text" => $_POST['tyle_text'][$i]));
        }
        $json['author'] = 'SIEUTHICODE.NET';
        $json['name_product'] = $name_game;
        $json['thumb'] = update_file('thumb',$detail['thumb'],'minigame');
        $json['vongquay'] = update_file('vongquay',$detail['vongquay'],'minigame');
        $json['open'] = update_file('open',$detail['open'],'minigame');
        $json['close'] = update_file('close',$detail['close'],'minigame');
        $json['lenh_admin'] = $lenh_admin;
        $json['lenh_user'] = $lenh_user;
        $json['tag'] = $tag;
        $json['cash'] = $cash;
        $json['fake_spin'] = $fake_spin;
        $json['sale_cash'] = $sale_cash;
        $json['thele'] = $thele;
        $json['data'] = $arr_gift;
        $full_json = addslashes(json_encode($json));
        $date = gettime();
        //echo $full_json;
        $SIEUTHICODE->update("minigame", [
            'type' => $type_game,
            'type_category' => $type_category,
            'detail' =>json_encode($json),
            'update_date' => gettime()
        ], " `id` = '$id' ");
        //$SIEUTHICODE->query("UPDATE `minigame` SET `type` = '{$type_game},`type_category` = '{$type_category}',`detail` = '{$full_json}',`update_date` = '{$date}' WHERE `id` = '{$id}'");
        //insert_log($data_user['username'], 'EDITPRODUCT', 'Chỉnh sửa trò chơi '.$detail['name_product'].'', $old_cash = $data_user['cash'], $change_cash = 0, $new_cash = $data_user['cash'], $old_cash_diamond = $data_user['diamond'], $change_cash_diamond = 0, $new_cash_diamond = $data_user['diamond']);
        echo JsonMsg('success','Chỉnh sửa thành công trò chơi '.$detail['name_product'].'');
    }