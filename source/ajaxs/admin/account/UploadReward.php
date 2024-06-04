<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = Anti_xss($_POST['type']);
    if (!@$getUser) {
        echo JsonMsg('error', 'Bạn chưa đăng nhập');
    } elseif ($getUser['level'] != 'admin') {
        echo JsonMsg('error', 'Bạn không có quyền thực hiện thao tác này');
    } else {
        if ($type == 'upload') {
            $type_category = Anti_xss($_POST['type_category']);
            $date = time();
            if ($SIEUTHICODE->num_rows("SELECT * FROM `minigame` WHERE `type_category` = '{$type_category}'") < 1) {
                echo JsonMsg('error', 'Không tìm thấy game bạn đã chọn');
            } else {
                if (empty($_POST['info'])) {
                    die(JsonMsg('error', 'Vui lòng nhập tài khoản'));
                }
                $query = $SIEUTHICODE->get_row("SELECT * FROM `minigame` WHERE `type_category` = '{$type_category}'");
                
                // Kiểm tra xem truy vấn có thành công không
                if ($query) {
                    
                    $info = explode("\n", $_POST['info']);
                    
                    
                    // Lấy giá trị ID từ kết quả truy vấn
                    $minigame_id = $query['id'];
                
                    // Tiếp tục thêm dữ liệu vào bảng account_reward với ID_TYPE là giá trị của ID từ bảng minigame
                    for ($i = 0; $i < count($info); $i++) {
                        $data = explode("|", $info[$i]);
                        $SIEUTHICODE->query("INSERT INTO `account_reward`(`username_post`, `type_category`, `taikhoan`, `matkhau`, `vitri`, `status`, `updated_at`, `created_at`, `ID_TYPE`) VALUES ('{$getUser['username']}', '{$query['type_category']}', '{$data['0']}', '{$data['1']}', '{$data['2']}', 'on', '{$date}', '{$date}', '{$minigame_id}')");
                    }
                
                    insert_log($getUser['id'], 'Thêm ' . count($info) . ' tài khoản trả thưởng');
                    echo JsonMsg('success', 'Đăng thành công ' . count($info) . '');
                } else {
                    // Xử lý trường hợp không tìm thấy trò chơi
                    echo JsonMsg('error', 'Không tìm thấy trò chơi bạn đã chọn');
                }
            }
        } elseif ($type == 'delete') {
            $id = Anti_xss($_POST['id']);
            if ($SIEUTHICODE->num_rows("SELECT * FROM `account_reward` WHERE `id` = '{$id}'") < 1) {
                echo JsonMsg('error', 'Không tìm thấy tài khoản bạn cần xóa');
            } else {
                $SIEUTHICODE->query("DELETE FROM `account_reward` WHERE `id` = '{$id}'");
                insert_log($getUser['id'], 'Xóa tài khoản #' . $id . ' tài khoản trả thưởng');
                echo JsonMsg('success', 'Xóa thành công tài khoản #' . $id . '');
            }
        }
    }

} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
