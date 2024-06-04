<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (@$getUser) {
        if ($SIEUTHICODE->site('status_withdraw_ctv') != 1) {
            die(JsonMsg('error', 'Chức năng rút tiền đang bảo trì'));
        }
        if (empty($_POST['bank'])) {
            die(JsonMsg('error', 'Vui lòng chọn ngân hàng cần rút'));
        }
        if (empty($_POST['stk'])) {
            die(JsonMsg('error', 'Vui lòng nhập số tài khoản cần rút'));
        }
        if (empty($_POST['name'])) {
            die(JsonMsg('error', 'Vui lòng nhập tên chủ tài khoản'));
        }
        if (empty($_POST['amount'])) {
            die(JsonMsg('error', 'Vui lòng nhập số tiền cần rút'));
        }
        if($_POST['amount'] < $SIEUTHICODE->site('minrut_ctv')){
            die(JsonMsg('error', 'Số tiền rút tối thiểu phải là'.' '.format_cash($SIEUTHICODE->site('minrut_ctv'))));
        }
        if($getUser['money'] < $_POST['amount']){
            die(JsonMsg('error', 'Số dư khả dụng của bạn không đủ'));
        }
        $amount = Anti_xss($_POST['amount']);
        $trans_id = random('123456789QWERTYUIOPASDFGHJKLZXCVBNM', 6);
        $isTru = $SIEUTHICODE->tru('users', 'money', $amount, " `id` = '".$getUser['id']."' ");
        if($isTru){
            $SIEUTHICODE->insert('log_ctv', [
                'user_id'       => $getUser['id'],
                'reason'        => 'Rút số dư CTV #'.$trans_id,
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $amount,
                'sotienhientai' => $amount - $amount,
                'create_date'    => gettime()
            ]);
            if(getRowRealTime('users',$getUser['id'], 'money') < 0){
                Banned($getUser['id'], 'Gian lận khi rút số dư CTV');
                die(JsonMsg('error', 'Bạn đã bị khoá tài khoản vì gian lận'));
            }
            $isInsert = $SIEUTHICODE->insert('withdraw_ctv', [
                'trans_id'  => $trans_id,
                'user_id'   => $getUser['id'],
                'bank'      => Anti_xss($_POST['bank']),
                'stk'       => Anti_xss($_POST['stk']),
                'name'      => Anti_xss($_POST['name']),
                'amount'    => Anti_xss($_POST['amount']),
                'status'    => 0,
                'create_gettime'    => gettime(),
                'update_gettime'    => gettime(),
                'reason'    => NULL
            ]);
            if($isInsert){  
                die(JsonMsg('success', 'Tạo yêu cầu rút tiền thành công, vui lòng đợi ADMIN xử lý'));
            }
            die(JsonMsg('error', 'ERROR 1 - Phát hiện lỗi khi rút tiền, vui lòng liên hệ ADMIN'));
        }else{
            die(JsonMsg('error', 'ERROR 2 - Phát hiện lỗi khi rút tiền, vui lòng liên hệ ADMIN'));
        }
    } else {
        die(JsonMsg('error', 'Vui lòng đăng nhập để thực hiện'));
    }
}
