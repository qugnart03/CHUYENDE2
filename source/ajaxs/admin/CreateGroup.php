<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = Anti_xss($_POST['type']);
    $category = Anti_xss($_POST['category']);
    $name_product = Anti_xss($_POST['name_product']);
    $type_category = create_slug($name_product);
    $thele = Anti_xss($_POST['thele']);
    $tag = Anti_xss($_POST['tag']);
    $cash = Anti_xss($_POST['cash']);
    $fake = Anti_xss($_POST['fake']);
    $arr_data = array();
   
    if (!@$getUser) {
        echo JsonMsg('error', 'Bạn chưa đăng nhập');
    } elseif ($getUser['level'] != 'admin') {
        echo JsonMsg('error', 'Bạn không có quyền truy cập vào trang này');
    } elseif (empty($name_product)) {
        echo JsonMsg('error', 'Vui lòng nhập tên sản phẩm');
    } elseif ($SIEUTHICODE->num_rows("SELECT * FROM `groups` WHERE `type_category` = '{$type_category}'") > 0) {
        echo JsonMsg('error', 'Sản phẩm này đã tồn tại trên hệ thống');
    } elseif (empty($type)) {
        echo JsonMsg('error', 'Vui lòng chọn loại tài khoản');
    }elseif (empty($fake)) {
        echo JsonMsg('error', 'Vui lòng nhập giao dịch ảo');
    } else {
        for ($i = 0; $i < count($_POST['data_name']); $i++) {
            array_push($arr_data, array("id" => $i, "label" => $_POST['data_name'][$i], "type" => $_POST['data_type'][$i], "name" => toslug($_POST['data_name'][$i]), "value" => $_POST['data_value'][$i], "show" => $_POST['data_show'][$i]));
        }
        $json['author'] = 'SIEUTHICODE.NET';
        $json['name_product'] = $name_product;
        $json['thumb'] = upload_file('thumb', 'product');
        $json['tag'] = $tag;
        $json['cash'] = $cash;
        $json['thele'] = $thele;
        $json['data'] = $arr_data;
        $full_json = addslashes(json_encode($json));
        $SIEUTHICODE->query("INSERT INTO `groups`(`stt`, `category`, `type`, `type_category`, `detail`,`fake`, `display`) VALUES ('1', '{$category}', '{$type}', '{$type_category}', '{$full_json}','{$fake}','1')");
        insert_log($getUser['id'], 'Thêm ngăn tài khoản game ' . $name_product . ' ');
        echo JsonMsg('success', 'Thêm thành công trò chơi ' . $name_product . '');
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
