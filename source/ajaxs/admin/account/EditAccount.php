<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = Anti_xss($_POST['id']);
    $cash = Anti_xss($_POST['cash']);
    $sale = Anti_xss($_POST['sale']);
    $type = Anti_xss($_POST['type']);
    $type_category = Anti_xss($_POST['type_category']);
    $status = Anti_xss($_POST['status']);
    $link_anh = array();
    $arr_data = array();
    $date = time();
    if (!@$getUser) {
        echo JsonMsg('error', 'Bạn chưa đăng nhập');
    } elseif ($getUser['level'] != 'admin') {
        echo JsonMsg('error', 'Bạn không có quyền truy cập trang này');
    } elseif (empty($cash)) {
        echo JsonMsg('error', 'Vui lòng nhập giá tiền');
    } elseif ($cash < 0) {
        echo JsonMsg('error', 'Giá tiền không được bé hơn 0đ');
    } elseif ($sale < 0) {
        echo JsonMsg('error', 'Khuyến mại không được bé hơn 0%');
    } elseif ($sale > 100) {
        echo JsonMsg('error', 'Khuyến mại không được lớn hơn 100%');
    } elseif (empty($status)) {
        echo JsonMsg('error', 'Vui lòng chọn trạng thái tài khoản');
    } else {
        if ($SIEUTHICODE->num_rows("SELECT * FROM `accounts` WHERE `id` = '{$id}' AND `type` = '{$type}' AND `type_category` = '{$type_category}'") > 0) {
            $query_product = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `type_category` = '{$type_category}' AND `type` IN ('ACCOUNT','RANDOM')");
            $detail = json_decode($query_product['detail'], true);
            $query = $SIEUTHICODE->get_row("SELECT * FROM `accounts` WHERE `id` = '{$id}'");
            if ($getUser['level'] == 'adminphu') { // admin phụ
                echo JsonMsg('error', 'Bạn không có quyền chỉnh sửa tài khoản này');
            } elseif ($getUser['level'] == 'ctv') { // ctv
                if ($SIEUTHICODE->num_rows("SELECT * FROM `accounts` WHERE `id` = '{$id}' AND `username_post` = '{$data_user['username']}'") > 0) {
                    $full_img = '';
                    if ($query['type'] == 'ACCOUNT') {
                        if (count($_FILES["image"]["name"]) > 1) {
                            for ($i = 0; $i < count($_FILES["image"]["name"]); $i++) { // upload nếu có ảnh mới
                                array_push($link_anh, upload_multiple_file('image', 'product', $i)); //new
                            }
                            $full_img = json_encode($link_anh);
                        } else {
                            $full_img = $query['image'];
                        }
                    }
                    for ($i = 0; $i < count($detail['data']); $i++) {
                        // $$detail['data'][$i]['name'] = Anti_xss($_POST[$detail['data'][$i]['name']]);
                        if($detail['data'][$i]['name'] == 'taikhoan' || $detail['data'][$i]['name'] == 'matkhau'){
                            $name = encryptData(Anti_xss($_POST[$detail['data'][$i]['name']]));
                        }else{
                            $name = Anti_xss($_POST[$detail['data'][$i]['name']]);
                        }
                        array_push($arr_data, array("id" => $i, "label" => $detail['data'][$i]['label'], "type" => $detail['data'][$i]['type'], "name" => $detail['data'][$i]['name'], "value" => encryptData(Anti_xss($_POST[$detail['data'][$i]['name']])), "show" => $detail['data'][$i]['show'], $detail['data'][$i]['name'] => $name));
                    }

                    $json['author'] = 'SIEUTHICODE.NET';
                    $json['data'] = $arr_data;
                    $full_detail = addslashes(json_encode($json));
                    $SIEUTHICODE->query("UPDATE `accounts` SET `type` = '{$type}',`detail` = '{$full_detail}',`image` = '{$full_img}',`money` = '{$cash}',`sale` = '{$sale}',`status` = '{$status}',`updated_at` = '{$date}' WHERE `id` = '{$id}' AND `username_post` = '{$data_user['username']}'");
                    insert_log($getUser['id'], 'Chỉnh sửa tài khoản #' . $id . '');
                    echo JsonMsg('success', 'Chỉnh sửa thành công tài khoản #' . $id . '');
                } else {
                    echo JsonMsg('error', 'Bạn không thể chỉnh sửa tài khoản này');
                }
            } elseif ($getUser['level'] == 'admin') { // quản trị viên
                $full_img = '';
                if ($query['type'] == 'ACCOUNT') {
                    if (count($_FILES["image"]["name"]) > 1) {
                        for ($i = 0; $i < count($_FILES["image"]["name"]); $i++) { // upload nếu có ảnh mới
                            array_push($link_anh, upload_multiple_file('image', 'product', $i)); //new
                        }
                        $full_img = json_encode($link_anh);
                    } else {
                        $full_img = $query['image'];
                    }
                }
                for ($i = 0; $i < count($detail['data']); $i++) {
                    //$$detail['data'][$i]['name'] = Anti_xss($_POST[$detail['data'][$i]['name']]);
                    if($detail['data'][$i]['name'] == 'taikhoan' || $detail['data'][$i]['name'] == 'matkhau'){
                        $name = encryptData(Anti_xss($_POST[$detail['data'][$i]['name']]));
                    }else{
                        $name = Anti_xss($_POST[$detail['data'][$i]['name']]);
                    }
                    array_push($arr_data, array("id" => $i, "label" => $detail['data'][$i]['label'], "type" => $detail['data'][$i]['type'], "name" => $detail['data'][$i]['name'], "value" => encryptData(Anti_xss($_POST[$detail['data'][$i]['name']])), "show" => $detail['data'][$i]['show'], $detail['data'][$i]['name'] => $name));
                }

                $json['author'] = 'SIEUTHICODE.NET';
                $json['data'] = $arr_data;
                $full_detail = addslashes(json_encode($json));
                $SIEUTHICODE->query("UPDATE `accounts` SET `type` = '{$type}',`detail` = '{$full_detail}',`image` = '{$full_img}',`money` = '{$cash}',`sale` = '{$sale}',`status` = '{$status}',`updated_at` = '{$date}' WHERE `id` = '{$id}'");
                insert_log($getUser['id'], 'Chỉnh sửa tài khoản #' . $id . '');
                echo JsonMsg('success', 'Chỉnh sửa thành công tài khoản #' . $id . '');
            }
        } else {
            echo JsonMsg('error', 'Không tìm thấy dữ liệu tài khoản');
        }
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
