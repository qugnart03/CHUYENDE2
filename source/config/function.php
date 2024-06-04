<?php
// @ioncube.dk $k -> "_KEYHERE_"
$SIEUTHICODE = new SIEUTHICODE;
require_once(__DIR__ . '/RSACrypt.php');
$rsa = new RSACrypt();
define('DOMAIN', 'https://' . $_SERVER['SERVER_NAME']);
$currentDomain = $_SERVER['HTTP_HOST'];
$MEMO_PREFIX        = $SIEUTHICODE->site('noidung_naptien');
$site_gmail_momo    = $SIEUTHICODE->site('email');
$site_pass_momo     = $SIEUTHICODE->site('pass_email');
$partner_id_card    = $SIEUTHICODE->site('partner_id_card');
$partner_key_card     = $SIEUTHICODE->site('partner_key_card');
class Redirect
{
    public function __construct($url = null)
    {
        if ($url) {
            echo '<script>location.href="' . $url . '";</script>';
        }
    }
}
function encryptData($data)
{
    global $rsa;
    $rsa->setPrivateKey(__DIR__ . '/../security/clientPrivate.pem');
    $rsa->setPublicKey(__DIR__ . '/../security/serverPublic.pem');
    return $rsa->encryptWithPublicKey($data);
}
function decodecryptData($data)
{
    global $rsa;
    $rsa->setPrivateKey(__DIR__ . '/../security/serverPrivate.pem');
    $rsa->setPublicKey(__DIR__ . '/../security/clientPublic.pem');
    return $rsa->decryptWithPrivateKey($data);
}
function format_date($time){
    return date("H:i:s d/m/Y", $time);
}
function Banned($user_id, $reason){
    global $SIEUTHICODE;
    $SIEUTHICODE->insert("logs", [
        'user_id' => $user_id,
        'ip' => myip(),
        'device' => $_SERVER['HTTP_USER_AGENT'],
        'create_date' => gettime(),
        'action' => $reason,
    ]);
    $SIEUTHICODE->update("users", array(
        'banned' => 1
    ), "id = '".$user_id."' ");
}
function create_slug($string)
{
    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
        '#(ì|í|ị|ỉ|ĩ)#',
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
        '#(ỳ|ý|ỵ|ỷ|ỹ)#',
        '#(đ)#',
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
        '#(Ì|Í|Ị|Ỉ|Ĩ)#',
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
        '#(Đ)#',
        "/[^a-zA-Z0-9\-\_]/",
    );
    $replace = array(
        'a',
        'e',
        'i',
        'o',
        'u',
        'y',
        'd',
        'A',
        'E',
        'I',
        'O',
        'U',
        'Y',
        'D',
        '-',
    );
    $string = preg_replace($search, $replace, $string);
    $string = preg_replace('/(-)+/', '-', $string);
    $string = strtolower($string);
    return $string;
}
function toslug($str) {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '', $str);
    return $str;
}
function upload_multiple_file($name,$folder,$i = 0){
    $rand = rand(0,99999999999999);
    $arr_type = ['jpg', 'jpeg', 'png', 'gif'];
    $destination_path = realpath($_SERVER["DOCUMENT_ROOT"]);
    $path = $destination_path.'/assets/'.$folder.'/'; // patch lưu file
    if($_FILES[$name]["error"][$i] == 0){
        $arr = explode(".", $_FILES[$name]["name"][$i]);
        if(in_array(strtolower(end($arr)), $arr_type)){
            @move_uploaded_file($_FILES[$name]["tmp_name"][$i], $path.md5($_FILES[$name]["name"][$i].$rand).".".end($arr));
        }
        $image = "assets/$folder/".md5($_FILES[$name]["name"][$i].$rand).".".end($arr);
    }
    return $image;
}
function upload_file($name,$folder){ // upload file lên hệ thống
    $rand = rand(0,99999999999999);
    $arr_type = ['jpg', 'jpeg', 'png', 'gif'];
    $destination_path = realpath($_SERVER["DOCUMENT_ROOT"]);
    $path = $destination_path.'/assets/'.$folder.'/'; // patch lưu file
    if($_FILES[$name]["error"] == 0){
        $arr = explode(".", $_FILES[$name]["name"]);
        if(in_array(strtolower(end($arr)), $arr_type)){
            @move_uploaded_file($_FILES[$name]["tmp_name"], $path.md5($_FILES[$name]["name"].$rand).".".end($arr));
        }
        $image = "assets/$folder/".md5($_FILES[$name]["name"].$rand).".".end($arr);
    }
    return $image;
}
function update_file($name,$old_link,$folder){ // cập nhật lại link web
    $rand = rand(0,99999999999999);
    $arr_type = ['jpg', 'jpeg', 'png', 'gif'];
    $destination_path = realpath($_SERVER["DOCUMENT_ROOT"]);
    $path = $destination_path.'/assets/'.$folder.'/'; // patch lưu file
    if($_FILES[$name]["error"] == 0) {
        $arr = explode(".", $_FILES[$name]["name"]);
        if(in_array(strtolower(end($arr)), $arr_type)){
            @move_uploaded_file($_FILES[$name]["tmp_name"], $path.md5($_FILES[$name]["name"].$rand).".".end($arr));
        }
        $image = "assets/$folder/".md5($_FILES[$name]["name"].$rand).".".end($arr);
    }else{
        $image = $old_link;
    }
    return $image;
}
function to_slug($str) {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    return $str;
}
function BotTele($id_chat, $token_tele, $text)
{
    $token = $token_tele;
    $chat_id = $id_chat;
    $data = [
        "text" => $text,
        "chat_id" => $chat_id,
    ];
    file_get_contents("https://api.telegram.org/bot" . $token . "/sendMessage?" . http_build_query($data));
}
function insert_log($user_id,$action){
    global $SIEUTHICODE;
    $SIEUTHICODE->insert("logs", [
        'user_id' => $user_id,
        'ip' => myip(),
        'device' => $_SERVER['HTTP_USER_AGENT'],
        'create_date' => gettime(),
        'action' => $action
    ]);
}
function getRowRealtime($table, $id, $row)
{
    global $SIEUTHICODE;
    return $SIEUTHICODE->get_row("SELECT `".$row."` FROM `$table` WHERE `id` = '$id' ")[$row];
}
function display_status_product($data)
{
    if ($data == 1) {
        $show = '<span class="badge badge-success">Hiển thị</span>';
    } elseif ($data == 0) {
        $show = '<span class="badge badge-danger">Ẩn</span>';
    }
    return $show;
}
function redirect($url)
{
    header("Location: {$url}");
    exit();
}
function hashName($name)
{
    $p = '';
    for ($i = 0; $i < strlen($name); $i++) {
        if ($i < 4) {
            $p .= $name[$i];
        } else {
            $p .= 'x';
        }
    }
    return $p;
}
function custom_cal_days_in_month($month, $year)
{
    if ($month < 1 || $month > 12 || $year < 0) {
        return false;
    }
    $nextMonth = $month % 12 + 1;
    $nextYear = ($month == 12) ? $year + 1 : $year;
    $lastDayOfNextMonth = mktime(0, 0, 0, $nextMonth, 0, $nextYear);
    $numberOfDays = date('d', $lastDayOfNextMonth);

    return $numberOfDays;
}
function hideFirstFourCharacters($inputString) {
    if (strlen($inputString) >= 4) {
        $hiddenPart = str_repeat('*', 4);
        $visiblePart = substr($inputString, 4);
        $hiddenString = $hiddenPart . $visiblePart;
    } else {
        $hiddenString = str_repeat('*', strlen($inputString));
    }

    return $hiddenString;
}
function timeAgo2($time_ago)
{
    $time_ago   = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed;
    $minutes    = round($time_elapsed / 60);
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400);
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640);
    $years      = round($time_elapsed / 31207680);
    // Seconds
    if ($seconds <= 60) {
        return "$seconds giây trước";
    }
    //Minutes
    else if ($minutes <= 60) {
        return "$minutes phút trước";
    }
    //Hours
    else if ($hours <= 24) {
        return "$hours tiếng trước";
    }
    //Days
    else if ($days <= 7) {
        if ($days == 1) {
            return "Hôm qua";
        } else {
            return "$days ngày trước";
        }
    }
    //Weeks
    else if ($weeks <= 4.3) {
        return "$weeks tuần trước";
    }
    //Months
    else if ($months <= 12) {
        return "$months tháng trước";
    }
    //Years
    else {
        return "$years năm trước";
    }
}
function gachthe1s($loaithe, $menhgia, $seri, $pin, $code)
{
    global $partner_id_card, $partner_key_card,$SIEUTHICODE;
    // ĐẶT GIÁ TRỊ MẢNG THÀNH NULL TRÁNH LỖI
    $POSTGET = array();

    // YÊU CẦU ID
    $POSTGET['request_id'] = $code;

    // MÃ THẺ NẠP TỪ POST USER
    $POSTGET['code'] = $pin;

    // PARTENER ID
    $POSTGET['partner_id'] = $partner_id_card;

    // SERI THẺ CÀO TỪ POST USER
    $POSTGET['serial'] = $seri;

    // NHÀ MẠNG TỪ POST USER
    $POSTGET['telco'] = $loaithe;

    // LỆNH (MẶC ĐỊNH: NẠP THẺ)
    $POSTGET['command'] = 'charging';

    // SẮP XẾP MẢNG
    ksort($POSTGET);

    //CHỮ KÝ KHI ĐỔI THẺ
    $sign = $partner_key_card;

    //Đặt chữ ký MD5 vào item
    foreach ($POSTGET as $item) {
        $sign .= $item;
    }

    //CHUYỂN CHỮ KÝ SANG ĐỊNH DẠNG MD5 (BẮT BUỘC)
    $mysign = md5($sign);

    // MỆNH GIÁ THẺ TỪ POST USER
    $POSTGET['amount'] = $menhgia;

    // CHỮ KÝ MD5
    $POSTGET['sign'] = $mysign;

    // XUẤT RA URL ĐỂ GỬI LÊN TSR
    $data = http_build_query($POSTGET);
    // CHẠY CURL
    $ch = curl_init();
    // QUÁ TRÌNH GỬI LÊN TSR (ĐỪNG THAY ĐỔI)
    curl_setopt($ch, CURLOPT_URL, $SIEUTHICODE->site('url_card'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $SERVER_NAME = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    curl_setopt($ch, CURLOPT_REFERER, $SERVER_NAME);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    // ĐÓNG GỬI LÊN
    curl_close($ch);
    // XUẤT RA JSON (STD CLASS
    return json_decode($result,true);
}

/* CONFIG RÚT TIỀN */
function listbank()
{
    $html = '
    <option value="">Chọn ngân hàng</option>
    <option value="MOMO">MOMO</option>
    <option value="VIETTEL PAY">VIETTEL PAY</option>
    <option value="ZALO PAY">ZALO PAY</option>
    <option value="VIETINBANK">VIETINBANK</option>
    <option value="VIETCOMBANK">VIETCOMBANK</option>
    <option value="AGRIBANK">AGRIBANK</option>
    <option value="TPBANK">TPBANK</option>
    <option value="HDB">HDB</option>
    <option value="VPBANK">VPBANK</option>
    <option value="MBBANK">MBBANK</option>
    <option value="OCEANBANK">OCEANBANK</option>
    <option value="BIDV">BIDV</option>
    <option value="SACOMBANK">SACOMBANK</option>
    <option value="ACB">ACB</option>
    <option value="ABBANK">ABBANK</option>
    <option value="NCB">NCB</option>
    <option value="IBK">IBK</option>
    <option value="CIMB">CIMB</option>
    <option value="EXIMBANK">EXIMBANK</option>
    <option value="SEABANK">SEABANK</option>
    <option value="SCB">SCB</option>
    <option value="DONGABANK">DONGABANK</option>
    <option value="SAIGONBANK">SAIGONBANK</option>
    <option value="PG BANK">PG BANK</option>
    <option value="PVCOMBANK">PVCOMBANK</option>
    <option value="KIENLONGBANK">KIENLONGBANK</option>
    <option value="VIETCAPITAL BANK">VIETCAPITAL BANK</option>
    <option value="OCB">OCB</option>
    <option value="MSB">MSB</option>
    <option value="SHB">SHB</option>
    <option value="VIETBANK">VIETBANK</option>
    <option value="VRB">VRB</option>
    <option value="NAMABANK">NAMABANK</option>
    <option value="SHBVN">SHBVN</option>
    <option value="VIB">VIB</option>
    <option value="TECHCOMBANK">TECHCOMBANK</option>
    ';
    return $html;
}

function daily($data)
{
    if($data == 0)
    {
        return 'Thành viên';
    }
    else if($data == 1)
    {
        return 'Đại lý';
    }
}
function trangthai($data)
{
    if($data == 'xuly')
    {
        return 'Đang xử lý';
    }
    else if($data == 'hoantat')
    {
        return 'Hoàn tất';
    }
    else if($data == 'thanhcong')
    {
        return 'Thành công';
    }
    else if($data == 'huy')
    {
        return 'Hủy';
    }
    else if($data == 'thatbai')
    {
        return 'Thất bại';
    }
    else
    {
        return 'Khác';
    }
}
function loaithe($data)
{
    if (strtolower($data) == 'viettel')
    {
        $show = 'https://i.imgur.com/xFePMtd.png';
    }
    else if (strtolower($data) == 'vinaphone')
    {
        $show = 'https://i.imgur.com/s9Qq3Fz.png';
    }
    else if (strtolower($data) == 'mobifone')
    {
        $show = 'https://i.imgur.com/qQtcWJW.png';
    }
    else if (strtolower($data) == 'vietnamobile')
    {
        $show = 'https://i.imgur.com/IHm28mq.png';
    }
    else if (strtolower($data) == 'zing')
    {
        $show = 'https://i.imgur.com/xkd7kQ0.png';
    }
    else if (strtolower($data) == 'garena')
    {
        $show = 'https://i.imgur.com/BLkY5qm.png';
    }
    return '<img style="text-align: center;" src="'.$show.'" width="70px" />';
}

function sendCSM($mail_nhan,$ten_nhan,$chu_de,$noi_dung,$bcc)
{
    global $site_gmail_momo, $site_pass_momo;
        // PHPMailer Modify
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail ->Debugoutput = "html";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $site_gmail_momo; // GMAIL STMP
        $mail->Password = $site_pass_momo; // PASS STMP
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom($site_gmail_momo, $bcc);
        $mail->addAddress($mail_nhan, $ten_nhan);
        $mail->addReplyTo($site_gmail_momo, $bcc);
        $mail->isHTML(true);
        $mail->Subject = $chu_de;
        $mail->Body    = $noi_dung;
        $mail->CharSet = 'UTF-8';
        $send = $mail->send();
        return $send;
}
function parse_order_id($des)
{
    global $MEMO_PREFIX;
    $re = '/'.$MEMO_PREFIX.'\d+/im';
    preg_match_all($re, $des, $matches, PREG_SET_ORDER, 0);
    if (count($matches) == 0 )
        return null;
    // Print the entire match result
    $orderCode = $matches[0][0];
    $prefixLength = strlen($MEMO_PREFIX);
    $orderId = intval(substr($orderCode, $prefixLength ));
    return $orderId ;
}
function BASE_URL($url)
{
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
    if ($base_url == 'http://localhost') {
        $base_url = 'http://localhost';
    }
    return $base_url .'/'. $url;
}
function gettime()
{
    return date('Y/m/d H:i:s', time());
}
function check_string($data)
{
    return trim(htmlspecialchars(addslashes($data)));
    //return str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($data))));
}
function Anti_xss($data)
{
    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
    $query_string = $_SERVER['QUERY_STRING'];
    $sql_injection = array("union","coockie","concat","alter","exec","shell","wget","**/","/**","0x3a","null","DR/**/OP/","drop","/*","*/","*","--",";","||","' #","or 1=1","'1'='1","BUN","S@BUN","char","OR%","`","[","]",
    "<",">","++","script","1,1","substring","ascii","sleep(","insert","between","values","truncate","benchmark","sql","mysql","%27","%22","(",")","<?","<?php","?>","../","/localhost","127.0.0.1","loopback",":","%0A",
    "%0D","%3C","%3E","%00","%2e%2e","input_file","execute","mosconfig","environ","scanner","path=.","mod=.","eval\(","javascript:","base64_","boot.ini","etc/passwd","self/environ","md5","echo.*kae","=%27$","'", '"');
    foreach($sql_injection as $key){
        if(strlen($query_string) > 255 OR strpos(strtolower($query_string), strtolower($key)) !== false){
            new Redirect("/");
        }
    }
    $data = addslashes(trim($data));
    do
    {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);
    // we are done...
    return $data;
}
function format_cash($price)
{
    return str_replace(",", ".", number_format($price));
}
function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    
    curl_close($ch);
    return $data;
}
function random($string, $int)
{  
    return substr(str_shuffle($string), 0, $int);
}
function pheptru($int1, $int2)
{
    return $int1 - $int2;
}
function phepcong($int1, $int2)
{
    return $int1 + $int2;
}
function phepnhan($int1, $int2)
{
    return $int1 * $int2;
}
function phepchia($int1, $int2)
{
    return $int1 / $int2;
}
function check_img($img)
{
    $filename = $_FILES[$img]['name'];
    $ext = explode(".", $filename);
    $ext = end($ext);
    $valid_ext = array("png","jpeg","jpg","PNG","JPEG","JPG","gif","GIF");
    if(in_array($ext, $valid_ext))
    {
        return true;
    }
}/*
function msg_success2($text)
{
    return die('<div class="alert alert-success alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div>');
}
function msg_error2($text)
{
    return die('<div class="alert alert-danger alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div>');
}
function msg_warning2($text)
{
    return die('<div class="alert alert-warning alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div>');
}
function msg_success($text, $url, $time)
{
    return die('<div class="alert alert-success alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function msg_error($text, $url, $time)
{
    return die('<div class="alert alert-danger alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function msg_warning($text, $url, $time)
{
    return die('<div class="alert alert-warning alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
*/
function msg_success2($text)
{
    return die('<script type="text/javascript">Swal.fire("Thành Công", "'.$text.'","success");</script>');
}
function msg_error2($text)
{
    return die('<script type="text/javascript">Swal.fire("Thất Bại", "'.$text.'","error");</script>');
}
function msg_warning2($text)
{
    return die('<script type="text/javascript">Swal.fire("Thông Báo", "'.$text.'","warning");</script>');
}
function msg_success($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thành Công", "'.$text.'","success");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function msg_error($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thất Bại", "'.$text.'","error");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function msg_warning($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thông Báo", "'.$text.'","warning");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}

function admin_msg_success($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thành Công", "'.$text.'","success");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function admin_msg_error($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thất Bại", "'.$text.'","error");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function admin_msg_warning($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thông Báo", "'.$text.'","warning");
    setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function display_banned($data)
{
    if ($data == 1)
    {
        $show = '<span class="badge badge-danger">Banned</span>';
    }
    else if ($data == 0)
    {
        $show = '<span class="badge badge-success">Hoạt động</span>';
    }
    return $show;
}
function display_loaithe($data)
{
    if ($data == 0)
    {
        $show = '<span class="badge badge-warning">Bảo trì</span>';
    }
    else 
    {
        $show = '<span class="badge badge-success">Hoạt động</span>';
    }
    return $show;
}
function display_ruttien($data)
{
    if ($data == 'xuly')
    {
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    }
    else if ($data == 'hoantat')
    {
        $show = '<span class="badge badge-success">Đã thanh toán</span>';
    }
    else if ($data == 'huy')
    {
        $show = '<span class="badge badge-danger">Hủy</span>';
    }
    return $show;
}
function status_withdraw($data)
{
    $statuses = array(
        '0' => '<span class="badge badge-info">Đang xử lý</span>',
        '2' => '<span class="badge badge-success">Đã thanh toán</span>',
        '1' => '<span class="badge badge-danger">Hủy</span>'
    );
    return isset($statuses[$data]) ? $statuses[$data] : '';
}

function XoaDauCach($text)
{
    return trim(preg_replace('/\s+/',' ', $text));
}
function display($data)
{
    if ($data == '0')
    {
        $show = '<span class="badge badge-danger">ẨN</span>';
    }
    else if ($data == '1')
    {
        $show = '<span class="badge badge-success">HIỂN THỊ</span>';
    }
    return $show;
}
function status($data)
{
    if ($data == 'xuly'){
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    }
    else if ($data == 'hoantat'){
        $show = '<span class="badge badge-success">Hoàn tất</span>';
    }
    else if ($data == 'thanhcong'){
        $show = '<span class="badge badge-success">Thành công</span>';
    }
    else if ($data == 'success'){
        $show = '<span class="badge badge-success">Success</span>';
    }
    else if ($data == 'thatbai'){
        $show = '<span class="badge badge-danger">Thất bại</span>';
    }
    else if ($data == 'error'){
        $show = '<span class="badge badge-danger">Error</span>';
    }
    else if ($data == 'loi'){
        $show = '<span class="badge badge-danger">Lỗi</span>';
    }
    else if ($data == 'huy'){
        $show = '<span class="badge badge-danger">Hủy</span>';
    }
    else if ($data == 'dangnap'){
        $show = '<span class="badge badge-warning">Đang đợi nạp</span>';
    }
    else if ($data == 2){
        $show = '<span class="badge badge-success">Hoàn tất</span>';
    }
    else if ($data == 1){
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    }
    else{
        $show = '<span class="badge badge-warning">Khác</span>';
    }
    return $show;
}
function getHeader(){
    $headers = array();
    $copy_server = array(
        'CONTENT_TYPE'   => 'Content-Type',
        'CONTENT_LENGTH' => 'Content-Length',
        'CONTENT_MD5'    => 'Content-Md5',
    );
    foreach ($_SERVER as $key => $value) {
        if (substr($key, 0, 5) === 'HTTP_') {
            $key = substr($key, 5);
            if (!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
                $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                $headers[$key] = $value;
            }
        } elseif (isset($copy_server[$key])) {
            $headers[$copy_server[$key]] = $value;
        }
    }
    if (!isset($headers['Authorization'])) {
        if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
            $basic_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
            $headers['Authorization'] = 'Basic ' . base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $basic_pass);
        } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
            $headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
        }
    }
    return $headers;
}

function check_username($data)
{
    if (preg_match('/^[a-zA-Z0-9_-]{3,16}$/', $data, $matches))
    {
        return True;
    }
    else
    {
        return False;
    }
}
function check_email($data)
{
    if (preg_match('/^.+@.+$/', $data, $matches))
    {
        return True;
    }
    else
    {
        return False;
    }
}
function check_phone($data)
{
    if (preg_match('/^\+?(\d.*){3,}$/', $data, $matches))
    {
        return True;
    }
    else
    {
        return False;
    }
}
function check_url($url)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_HEADER, 1);
    curl_setopt($c, CURLOPT_NOBODY, 1);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_FRESH_CONNECT, 1);
    if(!curl_exec($c))
    {
        return false;
    }
    else
    {
        return true;
    }
}
function check_zip($img)
{
    $filename = $_FILES[$img]['name'];
    $ext = explode(".", $filename);
    $ext = end($ext);
    $valid_ext = array("zip","ZIP");
    if(in_array($ext, $valid_ext))
    {
        return true;
    }
}
function TypePassword($string)
{
    return sha1(md5($string));
}
function pagination($url, $start, $total, $kmess)
{
    $out[] = ' <div class="paging_simple_numbers"><ul class="pagination">';
    $neighbors = 2;
    if ($start >= $total) $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
    else $start = max(0, (int)$start - ((int)$start % (int)$kmess));
    $base_link = '<li class="paginate_button page-item previous "><a class="page-link" href="' . strtr($url, array('%' => '%%')) . 'page=%d' . '">%s</a></li>';
    $out[] = $start == 0 ? '' : sprintf($base_link, $start / $kmess, 'Previous');
    if ($start > $kmess * $neighbors) $out[] = sprintf($base_link, 1, '1');
    if ($start > $kmess * ($neighbors + 1)) $out[] = '<li class="paginate_button page-item previous disabled"><a class="page-link">...</a></li>';
    for ($nCont = $neighbors;$nCont >= 1;$nCont--) if ($start >= $kmess * $nCont) {
        $tmpStart = $start - $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    $out[] = '<li class="paginate_button page-item previous active"><a class="page-link">' . ($start / $kmess + 1) . '</a></li>';
    $tmpMaxPages = (int)(($total - 1) / $kmess) * $kmess;
    for ($nCont = 1;$nCont <= $neighbors;$nCont++) if ($start + $kmess * $nCont <= $tmpMaxPages) {
        $tmpStart = $start + $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages) $out[] = '<li class="paginate_button page-item previous disabled"><a class="page-link">...</a></li>';
    if ($start + $kmess * $neighbors < $tmpMaxPages) $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);
    if ($start + $kmess < $total)
    {
        $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
        $out[] = sprintf($base_link, $display_page, 'Next');
    }
    $out[] = '</ul></div>';
    return implode('', $out);
}
function pagination_account($url, $start, $total, $kmess)
{
    $out[] = '<nav class="section-pagination mt-3"><ul class="flex items-center">';
    $neighbors = 2;
    if ($start >= $total) $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
    else $start = max(0, (int)$start - ((int)$start % (int)$kmess));
    $base_link = '<li class="pr-2"><a class="cursor-pointer" onclick="page=%d;load_account();"><div
    class="mx-1 border border-gray-400 bg-white relative v-page-no w-8 md:w-10 h-8 md:h-10 text-md md:text-lg rounded font-bold inline-flex items-center justify-center px-2 py-2 leading-5 font-medium focus:outline-none transition ease-in-out duration-150 text-gray-800 v-pagination-text disabled">
    <span class="transform">%s</span>
</div></a></li>';
    $out[] = $start == 0 ? '' : sprintf($base_link, $start / $kmess, '<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>');
    if ($start > $kmess * $neighbors) $out[] = sprintf($base_link, 1, '1');
    if ($start > $kmess * ($neighbors + 1)) $out[] = '<li class="pr-2"><a class="cursor-pointer"><div
    class="mx-1 border border-gray-400 bg-white relative v-page-no w-8 md:w-10 h-8 md:h-10 text-md md:text-lg rounded font-bold inline-flex items-center justify-center px-2 py-2 leading-5 font-medium focus:outline-none transition ease-in-out duration-150 text-gray-800 v-pagination-text disabled">
    <span class="transform">...</span>
</div></a></li>';
    for ($nCont = $neighbors; $nCont >= 1; $nCont--) if ($start >= $kmess * $nCont) {
        $tmpStart = $start - $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    $out[] = '<li class="pr-2"><a class="cursor-pointer"><div
    class="border mx-1 w-8 md:w-10 h-8 md:h-10 text-md md:text-lg select-none rounded inline-flex justify-center items-center px-4 py-2 focus:outline-none text-white border-red-600 text-white bg-red-600">
    <span class="transform">' . ($start / $kmess + 1) . '</span>
</div></a></li>';
    $tmpMaxPages = (int)(($total - 1) / $kmess) * $kmess;
    for ($nCont = 1; $nCont <= $neighbors; $nCont++) if ($start + $kmess * $nCont <= $tmpMaxPages) {
        $tmpStart = $start + $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages) $out[] = '<li class="pr-2"><a class="cursor-pointer"><div
    class="mx-1 border border-gray-400 bg-white relative v-page-no w-8 md:w-10 h-8 md:h-10 text-md md:text-lg rounded font-bold inline-flex items-center justify-center px-2 py-2 leading-5 font-medium focus:outline-none transition ease-in-out duration-150 text-gray-800 v-pagination-text disabled">
    <span class="transform">...</span>
</div></a></li>';
    if ($start + $kmess * $neighbors < $tmpMaxPages) $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);
    if ($start + $kmess < $total) {
        $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
        $out[] = sprintf($base_link, $display_page, '<i class="fa fa-chevron-circle-right" aria-hidden="true"></i>');
    }
    $out[] = '</ul></nav>';
    return implode('', $out);
}

function phantrang($url, $start, $total, $kmess)
{
    $out[] = ' <nav class="relative z-0 inline-flex v-pagination mx-auto v-text-1 v-light-theme">';
    $neighbors = 2;
    if ($start >= $total) $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
    else $start = max(0, (int)$start - ((int)$start % (int)$kmess));
    $base_link = '<li><a class="mx-1 border border-gray-400 bg-white relative v-page-no w-8 md:w-10 h-8 md:h-10 text-md md:text-lg rounded font-bold inline-flex items-center justify-center px-2 py-2 leading-5 font-medium focus:outline-none transition ease-in-out duration-150 text-gray-800 v-pagination-text disabled" href="' . strtr($url, array('%' => '%%')) . 'page=%d' . '">%s</a></li>';
    $out[] = $start == 0 ? '' : sprintf($base_link, $start / $kmess, '<svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
    <path fill-rule="evenodd"
        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
        clip-rule="evenodd"></path>
</svg>');
    if ($start > $kmess * $neighbors) $out[] = sprintf($base_link, 1, '1');
    if ($start > $kmess * ($neighbors + 1)) $out[] = '<li class="page-item"><a class="page-link">...</a></li>';
    for ($nCont = $neighbors;$nCont >= 1;$nCont--) if ($start >= $kmess * $nCont) {
        $tmpStart = $start - $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    $out[] = '<li class="border mx-1 w-8 md:w-10 h-8 md:h-10 text-md md:text-lg select-none rounded inline-flex justify-center items-center px-4 py-2 focus:outline-none text-white border-red-600 text-white bg-red-600"><a class="page-link">' . ($start / $kmess + 1) . '</a></li>';
    $tmpMaxPages = (int)(($total - 1) / $kmess) * $kmess;
    for ($nCont = 1;$nCont <= $neighbors;$nCont++) if ($start + $kmess * $nCont <= $tmpMaxPages) {
        $tmpStart = $start + $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages) $out[] = '<li class="page-item"><a class="page-link">...</a></li>';
    if ($start + $kmess * $neighbors < $tmpMaxPages) $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);
    if ($start + $kmess < $total)
    {
        $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
        $out[] = sprintf($base_link, $display_page, '<svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
        <path fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd"></path>
    </svg>
        ');
    }
    $out[] = '</ul></nav>';
    return implode('', $out);
}
function qrbank($type, $stk, $accountname, $amount, $comment)
{
    if ($type == 'MOMO') {
        $result = 'data:image/png;base64,' . base64_encode(file_get_contents("https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=2|99|$stk|||0|0|$amount|$comment|transfer_myqr"));
    } else {
        $result = "https://api.vietqr.io/$type/$stk/$amount/$comment/vietqr_net_2.jpg?accountName=$accountname";
    }
    return $result;
}
function myip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))     
    {  
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))    
    {  
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    else  
    {  
        $ip_address = $_SERVER['REMOTE_ADDR'];  
    }
    return $ip_address;
}
function timeAgo($time_ago)
{
    $time_ago   = date("Y-m-d H:i:s", $time_ago);
    $time_ago   = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60)
    {
        return "$seconds giây trước";
    }
    //Minutes
    else if($minutes <= 60)
    {
        return "$minutes phút trước";
    }
    //Hours
    else if($hours <= 24)
    {
        return "$hours tiếng trước";
    }
    //Days
    else if($days <= 7)
    {
        if($days == 1)
        {
            return "Hôm qua";
        }
        else
        {
            return "$days ngày trước";
        }
    }
    //Weeks
    else if($weeks <= 4.3)
    {
        return "$weeks tuần trước";
    }
    //Months
    else if($months <=12)
    {
        return "$months tháng trước";
    }
    //Years
    else
    {
        return "$years năm trước";
    }
}
function dirToArray($dir) {
  
    $result = array();
 
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
       if (!in_array($value,array(".","..")))
       {
          if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
          {
             $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
          }
          else
          {
             $result[] = $value;
          }
       }
    }
   
    return $result;
 }

 function realFileSize($path)
{
    if (!file_exists($path))
        return false;

    $size = filesize($path);
   
    if (!($file = fopen($path, 'rb')))
        return false;
   
    if ($size >= 0)
    {//Check if it really is a small file (< 2 GB)
        if (fseek($file, 0, SEEK_END) === 0)
        {//It really is a small file
            fclose($file);
            return $size;
        }
    }
   
    //Quickly jump the first 2 GB with fseek. After that fseek is not working on 32 bit php (it uses int internally)
    $size = PHP_INT_MAX - 1;
    if (fseek($file, PHP_INT_MAX - 1) !== 0)
    {
        fclose($file);
        return false;
    }
   
    $length = 1024 * 1024;
    while (!feof($file))
    {//Read the file until end
        $read = fread($file, $length);
        $size = bcadd($size, $length);
    }
    $size = bcsub($size, $length);
    $size = bcadd($size, strlen($read));
   
    fclose($file);
    return $size;
}
function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}
function GetCorrectMTime($filePath)
{

    $time = filemtime($filePath);

    $isDST = (date('I', $time) == 1);
    $systemDST = (date('I') == 1);

    $adjustment = 0;

    if($isDST == false && $systemDST == true)
        $adjustment = 3600;
   
    else if($isDST == true && $systemDST == false)
        $adjustment = -3600;

    else
        $adjustment = 0;

    return ($time + $adjustment);
}
function DownloadFile($file) { // $file = include path
    if(file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}
function JsonMsg($status,$msg){
    return json_encode(array("status" => $status,"msg" => $msg));
}
function his_admin($status){
    if($status == 1){
        return '<span class="badge bg-secondary">Chờ duyệt</span>';
    }elseif($status == 2){
        return '<span class="badge bg-success">Thành công</span>';
    }elseif($status == 3){
        return '<span class="badge bg-danger">Thất bại</span>';
    }elseif($status == 4){
        return '<span class="badge bg-warning">Sai mệnh giá</span>';
    }
}
function status_type($type){
    if($type == 'on'){
        return '<span class="badge bg-success">Chưa bán</span>';
    }elseif($type == 'off'){
        return '<span class="badge bg-danger">Đã bán</span>';
    }
}
function status_history($status){
    if($status == 1){
        $res['text'] = 'Đang chờ duyệt';
        $res['color'] = 'yellow';
    }elseif($status == 2){
        $res['text'] = 'Thành công';
        $res['color'] = 'green';
    }elseif($status == 3){
        $res['text'] = 'Thất bại';
        $res['color'] = 'red';
    }
    return $res;
}
function status_history_nro($status){
    if($status == 0){
        $res['text'] = 'Đang chờ giao dịch';
        $res['color'] = 'yellow';
    }elseif($status == 1){
        $res['text'] = 'Chờ ký gửi';
        $res['color'] = 'yellow';
    }elseif($status == 2){
        $res['text'] = 'Đã nhận';
        $res['color'] = 'green';
    }elseif($status == 3){
        $res['text'] = 'Đã hủy';
        $res['color'] = 'red';
    }
    return $res;
}
function status_history_nro_gem($status){
    if($status == 1){
        $res['text'] = 'Đang xử lý';
        $res['color'] = 'yellow';
    }elseif($status == 4){
        $res['text'] = 'Hoàn tất';
        $res['color'] = 'green';
    }elseif($status == 0){
        $res['text'] = 'Hủy đơn';
        $res['color'] = 'red';
    }elseif($status == 5){
        $res['text'] = 'Thất bại';
        $res['color'] = 'red';
    }elseif($status == 3){
        $res['text'] = 'Từ chối';
        $res['color'] = 'red';
    }elseif($status == 77){
        $res['text'] = 'Mất item không hoàn tiền';
        $res['color'] = 'red';
    }elseif($status == 88){
        $res['text'] = 'Mất item hoàn tiền';
        $res['color'] = 'red';
    }
    return $res;
}
function status_history_nro_admin($status){
    if($status == 0){
        $res = '<span class="badge bg-warning">Đang chờ giao dịch</span>';
    }elseif($status == 2){
        $res = '<span class="badge bg-success">Hoàn tất</span>';
    }elseif($status == 3){
        $res = '<span class="badge bg-danger">Đã hủy</span>';
    }
    return $res;
}
function status_history_nrogem_admin($status){
    if($status == 1){
        $res = '<span class="badge bg-warning">Đang xử lý</span>';
    }elseif($status == 4){
        $res = '<span class="badge bg-success">Hoàn tất</span>';
    }elseif($status == 3){
        $res = '<span class="badge bg-danger">Từ chối</span>';
    }elseif($status == 77){
        $res = '<span class="badge bg-danger">Mất item không hoàn tiền</span>';
    }elseif($status == 88){
        $res = '<span class="badge bg-danger">Mất item có hoàn tiền</span>';
    }elseif($status == 5){
        $res = '<span class="badge bg-danger">Thất bại</span>';
    }elseif($status == 0){
        $res = '<span class="badge bg-danger">Hủy đơn</span>';
    }
    return $res;
}
function status_bot_nro($status){
    if($status == 0){
       $res = '<span class="ml-2 inline-flex items-center font-bold text-white bg-red-600 justify-center h-6 text-md rounded focus:outline-none px-2 text-center">OFFLINE</span>';
    }elseif($status == 1){
        $res = '<span class="ml-2 inline-flex items-center font-bold text-white bg-green-600 justify-center h-6 text-md rounded focus:outline-none px-2 text-center">ONLINE</span>';
    }
    return $res;
}
function calculateDiscount($price, $discountPercent) {
    $discountAmount = $price * ($discountPercent / 100);
    $discountedPrice = $price - $discountAmount;
    return $discountedPrice;
}
function array_account($type,$index){
    global $SIEUTHICODE;
    $query_account = $SIEUTHICODE->get_row("SELECT * FROM `account_reward` WHERE `status` = 'on' AND `type_category` = '{$type}' AND `vitri` = {$index}");
    $SIEUTHICODE->query("UPDATE `account_reward` SET `status` = 'off' WHERE `id` = '{$query_account['id']}'");
    $arr_data[] = array("taikhoan" => $query_account['taikhoan'], "matkhau" => $query_account['matkhau']);
    return $arr_data;
}
function array_account_override($type,$index){
    global $SIEUTHICODE;
    $query_account = $SIEUTHICODE->get_row("SELECT * FROM `account_reward` WHERE `status` = 'on' AND `type_category` = '{$type}' AND `vitri` = {$index}");
    $SIEUTHICODE->query("UPDATE `account_reward` SET `status` = 'off' WHERE `id` = '{$query_account['id']}'");
    $arr_data[] = array("taikhoan" => $query_account['taikhoan'], "matkhau" => $query_account['matkhau']);
    return $query_account['taikhoan'] ."|" .$query_account['matkhau'];
}
function shuffleString($string) {
    $array = explode(",", $string);
    shuffle($array);
    $shuffledString = implode(",", $array);
    return $shuffledString;
}

function removeValArray(&$randA, $num) {
    foreach ($randA as $key => $value) {
        if ($value === $num) {
            unset($randA[$key]);
        }
    }
    
    return array_values($randA);
}

function insertLogWheel($chitiet,$taikhoan){
    // global $SIEUTHICODE;
    // $SIEUTHICODE->insert("log_wheel", [
    //     'id' => ,
    //     'user_id' => $user_id,
    //     'ip' => myip(),
    //     'device' => $_SERVER['HTTP_USER_AGENT'],
    //     'create_date' => gettime(),
    //     'action' => $reason,
    // ]);
    // $stmt = $SIEUTHICODE->prepare("INSERT INTO `log_wheel` (`chitiet`, `username`) VALUES ({$chitiet}, {$taikhoan})");
    // $stmt->bind_param("ss", $chitiet, $taikhoan);

    // $stmt->execute();
    // $stmt->close();
}

function loop_wheel($numrolllop,$type_category,$data_detail,$query){
    global $SIEUTHICODE,$getUser;
    $date = time();
    $day = date('d-m-Y');
    $data_array = $data_detail['data'];
    $arr_gift = array();
    $listgift = array();
    $count_price = 0;
    $count_kc = 0;
    
    if ($SIEUTHICODE->num_rows("SELECT * FROM `account_reward` WHERE `status` = 'on' AND `type_category` = '{$type_category}' ") < $numrolllop) {
        return;
    }
    
    $check = 0;
    $j = 0;
    
    if($getUser['level'] == 'admin'){
        $quyluat = explode(',', $data_detail['lenh_admin']);
    }else{
        $quyluat = explode(',', $data_detail['lenh_user']);
    }
    foreach ($quyluat as &$element) {
    $element = (int)$element;}
    
    // $checkDis = $SIEUTHICODE -> query("SELECT count(DISTINCT vitri) AS count_vitri, vitri as vitri FROM account_reward WHERE status = 'on' and type_category = {$type_category}");
    // $row = $checkDis->fetch_assoc();
    // $count_vitri = $row['count_vitri'];
    // $vitri = $row['vitri'];
    // $turns = 0;
    
    for ($i=0; $i < $numrolllop;  ) {
        $getRand = rand(0,count($quyluat) - 1); //get random // random 1 số từ 0 -> 9 ví dụ ra 0 đi
        $getRandValue = $quyluat[$getRand]; //value array // value lấy từ lệnh người dùng
        
        $price = calculateDiscount($data_detail['cash'],$data_detail['sale_cash']);
        $countI = $SIEUTHICODE->query("SELECT * FROM `account_reward` WHERE type_category = '{$type_category}' AND vitri = {$getRandValue} ");

        if(($countI -> num_rows) == null){
            $quyluat = removeValArray($quyluat, $getRandValue);
            if (count($quyluat) == 0) {
                return;
            }
            continue;
        }else{
            if(@$getUser){
                if($getUser['money'] >= $price){
                    $msg = $getUser['money'] ." price: " .$price;
                    $data_account = array_account_override($type_category, $getRandValue);
                    if ($data_account == '|') {
                        continue;
                    }
                    
                    $SIEUTHICODE->update("users", [
                    'money' => $getUser['money'] - ($price * ($i+1)) 
                    ], " `username` = '".$getUser['username']."' ");
                    
                    $msg = $data_array[$getRandValue-1]['tyle_text'] .". Chi tiết: " .$data_account;
                    $chitiet = $data_array[$getRandValue-1]['tyle_text'];
                    $acc = explode('|', $data_account);
                    
                    array_push($arr_gift, array("title" => $msg));
                    $i++;
                }else{
                    $msg = "Bạn không đủ số dư";
                    break;
                }
               
            }
        }
                
        
        
        
        //array_push($arr_gift, array("title" => $msg));
        // $img = $data_array[$get_num]['item'];
        // if($query['type'] == 'LATHINH'){
        //     for($a=0; $a < count($data_array); $a++){
        //         if($a != $get_num){
        //             array_push($listgift, array("image" => BASE_URL($data_array[$a]['item'])));
        //         }
        //     }
        // }

        $count_price += $price;
        $count_kc += $kc;
        $log['chitiet'] = $chitiet;
        $log['taikhoan'] = $acc;
        $log['name_product'] = $data_detail['name_product'];
        $log['msg'] = $msg;
        $log['cash'] = $data_detail['cash'];
        $log['price_old'] = $getUser['money'];
        $log['price_change'] = $data_detail['cash'];
        $log['price_new'] = $getUser['money']-$data_detail['cash']+$price;
        $log['diamond_old'] = $getUser['diamond'];
        $log['diamond_change'] = $kc;
        $log['diamond_new'] = $getUser['diamond']+$kc;
        $full_log = json_encode($log);
        $SIEUTHICODE->insert("history_minigame", [
            'user_id' => $getUser['id'],
            'type_category' => $type_category,
            'detail' => $full_log,
            'create_date' => time(),
            'update_date' => time()
        ]);
        unset($log);
    }
    $array['count_price'] = $count_price;
    $array['count_kc'] = $count_kc;
    $array['get_num'] = $get_num;
    $array['msg'] = $msg;
    $array['img'] = $img;
    $array['arr_gift'] = $arr_gift;
    $array['listgift'] = $listgift;
    return $array;

}
function DAILY_SERVICE($tranid,$server,$customer_data0,$customer_data1,$amount)
{
    global $SIEUTHICODE;
    $callback_host = $SIEUTHICODE->site('link_callback');
    $callback = str_replace(".www.",'.',$callback_host);
    $data = array(
        'request_id' => $tranid,
        'user_id' => $SIEUTHICODE->site('user_id'),
        'sign' => $SIEUTHICODE->site('sign'),
        'idkey' => 'nrogem',
        'server'=> $server,
        'customer_data0' => $customer_data0,
        'customer_data1' => $customer_data1,
        'amount' => $amount,
        'callback' =>$callback
    );
    $apiUrl = "https://daily.tichhop.pro/api/v1/agency-service?" . http_build_query($data);
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response,true);
}

function check_license($license)
{
    global $currentDomain;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://static.sieuthicode.net/api/v1/check-license',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('domain' => str_replace(".www.",'.',$currentDomain),'license' => $license),
    ));
    $response = curl_exec($curl);
    
    curl_close($curl);
    return json_decode($response,true);
}
function active_license()
{
    global $SIEUTHICODE;
    if ($SIEUTHICODE->site('license') == '' || check_license($SIEUTHICODE->site('license'))['status'] === 'error') {
        if (isset($_POST['SaveSettings'])) {
            if ($SIEUTHICODE->site('status_demo') == 'ON') {
                admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
            }
            foreach ($_POST as $key => $value) {
                $SIEUTHICODE->update("options", array(
                    'value' => $value,
                ), " `key` = '$key' ");
            }
            $response = check_license($SIEUTHICODE->site('license'));
            if ($response['status'] === 'error') {
                die('<script type="text/javascript">if(!alert("' . $response['msg'] . '")){window.history.back().location.reload();}</script>');
            }
            die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
        }
        ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cấu hình thông tin bản quyền</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">THÔNG TIN BẢN QUYỀN</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Mã bản quyền (license key)</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" name="license"
                                                placeholder="Nhập mã bản quyền của bạn để sử dụng chức năng này"
                                                value="<?=$SIEUTHICODE->site('license');?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="SaveSettings" class="btn btn-primary btn-block">
                                    <span>LƯU</span></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">HƯỚNG DẪN</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Để có thể lấy License key tại đây: <a target="_blank"
                                    href="https://zalo.me/g/cbzsbc549">https://zalo.me/g/cbzsbc549</a>
                            </p>
                            <p>Nếu quý khách mua hàng tại SIEUTHICODE.NET mà chưa có License key, vui lòng liên hệ Zalo
                                <b>https://zalo.me/g/cbzsbc549</b> để được cấp.
                            </p>
                            <p>Chỉ áp dụng cho những ai mua code, không hỗ trợ những trường hợp mua lại hay sử dụng mã
                                nguồn
                                lậu.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Footer.php';
        die();
    }
}