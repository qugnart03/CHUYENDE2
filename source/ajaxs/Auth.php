<?php
require_once "../config/config.php";
require_once "../config/function.php";
require_once '../class/class.smtp.php';
require_once '../class/PHPMailerAutoload.php';
require_once '../class/class.phpmailer.php';
use PragmaRX\Google2FA\Google2FA;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'Login') {
        $username = Anti_xss($_POST['username']);
        $password = Anti_xss($_POST['password']);
        if (empty($username)) {
            die(JsonMsg('error', 'Vui lòng nhập tên đăng nhập'));
        }
        if (check_username($username) != true) {
            die(JsonMsg('error', 'Vui lòng nhập định dạng tài khoản hợp lệ !'));
        }
        if (empty($password)) {
            die(JsonMsg('error', 'Vui lòng nhập mật khẩu !'));
        }
        if (!$checkUser = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '$username' ")) {
            die(JsonMsg('error', 'Tài khoản hoặc mật khẩu không chính xác!'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '$username' AND `banned` = '1' ")) {
            die(JsonMsg('error', 'Tài khoản này đã bị khóa bởi BQT!'));
        }
        $getUser = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '".sha1(md5($password))."' ");
        if (!$getUser) {
            if($checkUser['login_attempts'] >= 3){
                $SIEUTHICODE->update("users", array(
                    'banned'     => 1
                ), " `id` = '" . $checkUser['id'] . "' ");
                insert_log($checkUser['id'],'Tài khoản của bạn đã bị tạm khoá do đang nhập sai nhiều lần');
                die(JsonMsg('error', 'Tài khoản của bạn đã bị tạm khoá do đang nhập sai nhiều lần'));
            }
            $SIEUTHICODE->cong('users', 'login_attempts', 1, " `id` = '".$checkUser['id']."' ");
            die(JsonMsg('error', 'Tài khoản hoặc mật khẩu không chính xác!'));
        }
        if ($getUser['status_2fa'] == 1) {
            die(json_encode([
                'status'    => 'verify',
                'url'       => BASE_URL('auth/verify/'.base64_encode($getUser['token'])),
                'msg'       => 'Vui lòng xác minh 2FA để hoàn thành đăng nhập'
            ]));
        }
        $SIEUTHICODE->insert("logs", [
            'user_id' => $getUser['id'],
            'ip' => myip(),
            'device' => $_SERVER['HTTP_USER_AGENT'],
            'create_date' => gettime(),
            'action' => 'Đăng nhập vào hệ thống'
        ]);
        $SIEUTHICODE->update("users", [
            'otp' => null,
            'login_attempts'=>0,
            'device' => $_SERVER['HTTP_USER_AGENT']
        ], " `username` = '$username' ");
        $_SESSION['username'] = $username;
        die(JsonMsg('success', 'Đăng nhập thành công'));
    }

    if ($_POST['type'] == 'Register') {
        $username = Anti_xss($_POST['username']);
        $password = Anti_xss($_POST['password']);
        $email = Anti_xss($_POST['email']);
        $repassword = Anti_xss($_POST['repassword']);
        $captcha = Anti_xss($_POST['captcha']);
        if (empty($email)) {
            die(JsonMsg('error', 'Vui lòng nhập email !'));
        }
        if (check_email($email) != true) {
            die(JsonMsg('error', 'Vui lòng nhập định dạng email hợp lệ !'));
        }
        if (empty($username)) {
            die(JsonMsg('error', 'Vui lòng nhập tên tài khoản !'));
        }
        if (check_username($username) != true) {
            die(JsonMsg('error', 'Vui lòng nhập định dạng tài khoản hợp lệ !'));
        }
        if (strlen($username) < 6 || strlen($username) > 64) {
            die(JsonMsg('error', 'Tài khoản phải từ 6 đến 64 ký tự !'));
        }
        if (empty($password)) {
            die(JsonMsg('error', 'Vui lòng nhập mật khẩu !'));
        }
        if (strlen($password) < 6) {
            die(JsonMsg('error', 'Vui lòng đặt mật khẩu trên 6 ký tự !'));
        }
        if ($password != $repassword) {
            die(JsonMsg('error', 'Nhập lại mật khẩu không đúng !'));
        }
        if($username == $password){
            die(JsonMsg('error', 'Tài khoản và mật khẩu không được giống nhau !'));
        }
        if (empty($captcha)) {
            die(JsonMsg('error', 'Vui lòng nhập mã captcha!'));
        }
        if ($captcha != $_SESSION['captcha']) {
            die(JsonMsg('error', 'Mã captcha không hợp lệ!'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '$username' ")) {
            die(JsonMsg('error', 'Tên đăng nhập đã tồn tại !'));
        }
        if ($SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `email` = '$email' ")) {
            die(JsonMsg('error', 'Địa chỉ email đã tồn tại !'));
        }
        if ($SIEUTHICODE->num_rows(" SELECT * FROM `users` WHERE `ip` = '" . myip() . "' ") >= $SIEUTHICODE->site('max_register_ip')) {
            die(JsonMsg('error', 'Bạn đã đạt giới hạn tạo tài khoản !'));
        }
        $google2fa = new Google2FA();
        $create = $SIEUTHICODE->insert("users", [
            'username' => $username,
            'email' => $email,
            'password' => sha1(md5($password)),
            'token' => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 64),
            'money' => 0,
            'total_money' => 0,
            'banned' => 0,
            'level' =>'member',
            'ip' => myip(),
            'time' => time(),
            'SecretKey_2fa' => $google2fa->generateSecretKey(),
            'createdate' => gettime(),
        ]);
        if ($create) {
            $_SESSION['username'] = $username;
            die(JsonMsg('success', 'Tạo tài khoản thành công'));
        } else {
            die(JsonMsg('error', 'Tạo tài khoản thất bại, vui lòng liên hệ admin để được xử lý !'));
        }
    }

    if ($_POST['type'] == 'ForgotPassword') {
        $email = check_string($_POST['email']);
        if (empty($email)) {
            msg_error2("Vui lòng nhập địa chỉ email vào ô trống");
        }
        if (check_email($email) != true) {
            msg_error2('Vui lòng nhập địa chỉ email hợp lệ');
        }
        $row = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `email` = '$email' ");
        if (!$row) {
            msg_error2('Địa chỉ email không tồn tại trong hệ thống');
        }
        $otp = random('0123456789', '6');
        $SIEUTHICODE->update("users", array(
            'otp' => $otp,
        ), " `id` = '" . $row['id'] . "' ");
        $guitoi = $email;
        $subject = 'XÁC NHẬN KHÔI PHỤC MẬT KHẨU';
        $bcc = $SIEUTHICODE->site('tenweb');
        $hoten = 'Client';
        $noi_dung = '<h3>Có ai đó vừa yêu cầu khôi phục lại mật khẩu bằng Email này, nếu là bạn vui lòng nhập mã xác minh phía dưới để xác minh tài khoản</h3>
        <table>
        <tbody>
        <tr>
        <td style="font-size:20px;">OTP:</td>
        <td><b style="color:blue;font-size:30px;">' . $otp . '</b></td>
        </tr>
        </tbody>
        </table>';
        sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);
        msg_success('Chúng tôi đã gửi mã xác minh vào địa chỉ Email của bạn !', BASE_URL('Auth/ChangePassword'), 4000);
    }

    if ($_POST['type'] == 'ChangePassword') {
        $otp = check_string($_POST['otp']);
        $repassword = check_string($_POST['repassword']);
        $password = check_string($_POST['password']);
        if (empty($otp)) {
            msg_error2("Bạn chưa nhập OTP");
        }
        if (empty($password)) {
            msg_error2("Bạn chưa nhập mật khẩu mới");
        }
        if (empty($repassword)) {
            msg_error2("Vui lòng xác minh lại mật khẩu");
        }
        if (isset($_SESSION['countVeri'])) {
            if ($_SESSION['countVeri'] >= 3) {
                msg_error2("Chức năng này tạm khóa");
            }
        } else {
            $_SESSION['countVeri'] = 0;
        }
        $row = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `otp` = '$otp' ");
        if (!$row) {
            $_SESSION['countVeri'] = $_SESSION['countVeri'] + 1;
            msg_error2("OTP không tồn tại trong hệ thống");
        }
        if ($password != $repassword) {
            msg_error2("Nhập lại mật khẩu không đúng");
        }
        if (strlen($password) < 5) {
            msg_error2('Vui lòng nhập mật khẩu có ích nhất 5 ký tự');
        }
        $SIEUTHICODE->update("users", [
            'otp' => null,
            'password' => TypePassword($password),
        ], " `id` = '" . $row['id'] . "' ");

        msg_success2("Mật khẩu của bạn đã được thay đổi thành công !");
    }
    if ($_POST['type'] == 'ChangeGoogle2FA') {
        if($SIEUTHICODE->site("status_demo") == "ON"){
            die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
        }
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập !'));
        }
        if (!$getUser = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' AND `banned` = '0' ")) {
            die(JsonMsg('error', 'Tài khoản này đã bị khóa bởi BQT!'));
        }
        if (empty($_POST['secret'])) {
            die(JsonMsg('error', 'Vui lòng nhập mã xác minh 2FA!'));
        }
        $google2fa = new Google2FA();
        if ($google2fa->verifyKey($getUser['SecretKey_2fa'], check_string($_POST['secret'])) != true) {
            die(JsonMsg('error', 'Mã xác minh không chính xác!'));
        }
        $isUpdate = $SIEUTHICODE->update("users", [
            'status_2fa' => isset($_POST['status_2fa']) ? check_string($_POST['status_2fa']) : 0
        ], " `token` = '".check_string($getUser['token'])."' ");
        die(JsonMsg('success', 'Lưu thành công'));
    }
    if ($_POST['type'] == 'ChangeSecret') {
        if($SIEUTHICODE->site("status_demo") == "ON"){
            die(JsonMsg('error', 'Đây là trang web demo, không thể thực hiện chức năng này!'));
        }
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập !'));
        }
        if (!$getUser = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' AND `banned` = '0' ")) {
            die(JsonMsg('error', 'Vui lòng đăng nhập!'));
        }
        $google2fa = new Google2FA();
        $isUpdate = $SIEUTHICODE->update("users", [
            'SecretKey_2fa' => $google2fa->generateSecretKey()
        ], " `id` = '".$getUser['id']."' ");
        insert_log($getUser['id'], 'Thay đổi serect key 2fa');
        die(JsonMsg('success', 'Thay đổi thành công'));
    }
    if ($_POST['type'] == 'VerifyGoogle2FA') {
        if (empty($_POST['token'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập !'));
        }
        if (!$getUser = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = '0' ")) {
            die(JsonMsg('error', 'Vui lòng đăng nhập!'));
        }
        if (empty($_POST['code'])) {
            die(JsonMsg('error', 'Vui lòng nhập mã xác minh!'));

        }
        $google2fa = new Google2FA();
        if ($google2fa->verifyKey($getUser['SecretKey_2fa'], check_string($_POST['code'])) != true) {
            $SIEUTHICODE->insert("logs", [
                'user_id' => $getUser['id'],
                'ip' => myip(),
                'device' => $_SERVER['HTTP_USER_AGENT'],
                'create_date' => gettime(),
                'action'        => '[Warning] Phát hiện có người đang cố gắng nhập mã xác minh'
            ]);
            die(JsonMsg('error', 'Mã xác minh không chính xác!'));
        }
        $SIEUTHICODE->insert("logs", [
            'user_id' => $getUser['id'],
            'ip' => myip(),
            'device' => $_SERVER['HTTP_USER_AGENT'],
            'create_date' => gettime(),
            'action' => 'Đăng nhập vào hệ thống'
        ]);
        $SIEUTHICODE->update("users", [
            'otp' => null,
        ], " `username` = '".$getUser['username']."' ");
        $_SESSION['username'] = $getUser['username'];
        die(JsonMsg('success', 'Đăng nhập thành công'));
    }
    if ($_POST['type'] == 'DoiMatKhau') {
        if (empty($_SESSION['username'])) {
            die(JsonMsg('error', 'Vui lòng đăng nhập !'));
        }
        $row = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "' AND `banned` = 0");
        if (!$row) {
            die(JsonMsg('error', 'Vui lòng đăng nhập!'));
        }
        if ($SIEUTHICODE->site('status_demo') == 'ON') {
            die(JsonMsg('error', 'Chức năng này không khả dụng trên trang web DEMO!'));
        }
        $repassword = Anti_xss($_POST['repassword']);
        $password = Anti_xss($_POST['password']);
        if (empty($password)) {
            die(JsonMsg('error', 'Bạn chưa nhập mật khẩu mới!'));
        }
        if (empty($repassword)) {
            die(JsonMsg('error', 'Vui lòng xác minh lại mật khẩu!'));
        }
        if ($password != $repassword) {
            die(JsonMsg('error', 'Nhập lại mật khẩu không đúng!'));
        }
        if (strlen($password) < 5) {
            die(JsonMsg('error', 'Vui lòng nhập mật khẩu có ích nhất 5 ký tự'));
        }
       
        $SIEUTHICODE->update("users", [
            'otp' => null,
            'password' => sha1(md5($password)),
        ], " `id` = '" . $row['id'] . "' ");
        insert_log($row['id'],'Thực hiện đổi mật khẩu');
        die(JsonMsg('success', 'Mật khẩu của bạn đã được thay đổi thành công'));
    }
} else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
