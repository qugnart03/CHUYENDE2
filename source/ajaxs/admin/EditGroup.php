<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = Anti_xss($_POST['id']);
    $type = Anti_xss($_POST['type']);
    $name_product = Anti_xss($_POST['name_product']);
    $type_category = create_slug($name_product);
    $thele = Anti_xss($_POST['thele']);
    $tag = Anti_xss($_POST['tag']);
    $display = Anti_xss($_POST['display']);
    $fake = Anti_xss($_POST['fake']);
    $arr_data = array();

    if (!@$getUser) {
        echo JsonMsg('error', 'Bạn chưa đăng nhập');
    } elseif ($getUser['level'] != 'admin') {
        echo JsonMsg('error', 'Bạn không có quyền truy cập trang này');
    } elseif (empty($name_product)) {
        echo JsonMsg('error', 'Vui lòng nhập tên sản phẩm');
    } elseif ($SIEUTHICODE->num_rows("SELECT * FROM `groups` WHERE `id` = '{$id}'") < 1) {
        echo JsonMsg('error', 'Không tìm thấy sản phẩm để chỉnh sửa');
    } elseif (empty($type)) {
        echo JsonMsg('error', 'Vui lòng chọn loại tài khoản');
    }elseif (empty($fake)) {
        echo JsonMsg('error', 'Vui lòng nhập giao dịch ảo');
    } else {
        $query = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `id` = '{$id}' AND `type` IN ('ACCOUNT','RANDOM')");
        $detail = json_decode($query['detail'], true);
        for ($i = 0; $i < count($_POST['data_name']); $i++) {
            array_push($arr_data, array("id" => $i, "label" => $_POST['data_name'][$i], "type" => $_POST['data_type'][$i], "name" => toslug($_POST['data_name'][$i]), "value" => $_POST['data_value'][$i], "show" => $_POST['data_show'][$i]));
        }
        $json['author'] = 'SIEUTHICODE.NET';
        $json['name_product'] = $name_product;
        $json['thumb'] = update_file('thumb', $detail['thumb'], 'product');
        $json['tag'] = $tag;
        if ($type == 'RANDOM') {
            $price = Anti_xss($_POST['price']);
            $json['cash'] = $price;
        }
        $json['thele'] = $thele;
        $json['data'] = $arr_data;
        $full_json = addslashes(json_encode($json));
        $SIEUTHICODE->query("UPDATE `groups` SET `type` = '{$type}',`detail` = '{$full_json}',`fake` = '{$fake}',`display` = '{$display}' WHERE `id` = '{$id}'");
        insert_log($getUser['id'], 'Chỉnh sửa ngăn game ' . $detail['name_product'] . '');
        echo JsonMsg('success', 'Chỉnh sửa thành công trò chơi ' . $name_product . '');
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
