<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type_category = Anti_xss($_POST['type_category']);
    $link_anh = array();
    $arr_data = array();
    $date = time();
    if (!@$getUser) {
        echo JsonMsg('error', 'Bạn chưa đăng nhập');
    } elseif ($getUser['level'] != 'admin') {
        echo JsonMsg('error', 'Bạn không có quyền truy cập trang này');
    } elseif ($SIEUTHICODE->num_rows("SELECT * FROM `groups` WHERE `type_category` = '{$type_category}' AND `type` IN ('ACCOUNT','RANDOM')") < 1) {
        echo JsonMsg('error', 'Không tìm thấy danh mục tài khoản');
    } else {
        $query = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `type_category` = '{$type_category}' AND `type` IN ('ACCOUNT','RANDOM')", 1);
        $detail = json_decode($query['detail'], true);
        if ($query['type'] == 'ACCOUNT') { // đăng tài khoản
            $cash = Anti_xss($_POST['cash']);
            $sale = Anti_xss($_POST['sale']);
            if ($cash < 0) {
                echo JsonMsg('error', 'Giá tiền không được dưới 0đ');
            } elseif ($sale < 0) {
                echo JsonMsg('error', 'Khuyến mại không được dưới 0%');
            } elseif (count($_FILES["image"]["name"]) < 1) {
                echo JsonMsg('error', 'Bạn đang thiếu hình ảnh');
            } else {
                for ($i = 0; $i < count($_FILES["image"]["name"]); $i++) {
                    array_push($link_anh, upload_multiple_file('image', 'product', $i)); //new
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
                //print_r($arr_data);
              
                $json_image = json_encode($link_anh);
                $json['author'] = 'SIEUTHICODE.NET';
                $json['name_product'] = $detail['name_product'];
                $json['data'] = $arr_data;
                $full_detail = addslashes(json_encode($json));
                $SIEUTHICODE->query("INSERT INTO `accounts`(`groups`,`type`, `type_category`, `username_post`, `detail`, `image`, `money`, `sale`, `updated_at`, `created_at`) VALUES ('{$query['id']}','{$query['type']}', '{$type_category}', '{$getUser['username']}', '{$full_detail}', '{$json_image}', '{$cash}', '{$sale}','{$date}', '{$date}')");
                insert_log($getUser['id'], 'Thêm tài khoản ' . $detail['name_product'] . '');
                echo JsonMsg('sucess', 'Đăng tài khoản thành công');
            }
        } elseif ($query['type'] == 'RANDOM') { // đăng tài khoản vận may
            $data = Anti_xss($_POST['data']);
            if (empty($data)) {
                echo JsonMsg('error', 'Vui lòng nhập dữ liệu cần đăng');
            } else {
                function upload_random($arr, $account, $name_product)
                {
                    for ($i = 0; $i < count($arr); $i++) {
                        $arr_data[] = array("id" => $i, "label" => $arr[$i]['label'], "type" => $arr[$i]['type'], "name" => $arr[$i]['name'], "value" => encryptData($account[$i]), "show" => $arr[$i]['show']);
                        $json['author'] = 'SIEUTHICODE.NET';
                        $json['name_product'] = $name_product;
                        $json['data'] = $arr_data;
                    }
                    return $json;
                }
                $arr = $detail['data'];
                $data = explode("\n", $data);
                $z = 0;
                foreach ($data as $key) {
                    $account = explode("|", $data[$z]);
                    $full_json = addslashes(json_encode(upload_random($arr, $account, $detail['name_product'])));
                    $SIEUTHICODE->query("INSERT INTO `accounts`(`groups`,`type`, `type_category`, `username_post`, `detail`, `image`, `money`, `sale`, `updated_at`, `created_at`) VALUES ('{$query['id']}','{$query['type']}', '{$type_category}', '{$getUser['username']}', '{$full_json}', '', '{$detail['cash']}', '0', '{$date}', '{$date}')");
                    $z++;
                }
                insert_log($getUser['id'], 'Thêm ' . count($data) . ' tài khoản ' . $detail['name_product'] . '');
                echo JsonMsg('success', 'Đăng thành công ' . count($data) . '');
            }
        }
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
