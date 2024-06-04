<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['server']) && isset($_POST['player'])) {
        $server = Anti_xss($_POST['server']);
        $player = Anti_xss($_POST['player']);
        $goldnumber = Anti_xss($_POST['goldnumber']);
        $goldbar = Anti_xss($_POST['goldbar']);
        $gem = Anti_xss($_POST['gem']);
        $zone = Anti_xss($_POST['zone']);
        $location = Anti_xss($_POST['location']);
        $status = Anti_xss($_POST['status']);
        if (empty($server)) {
            die(json_encode(array('status' => false, 'msg' => 'Thiếu máy chủ')));
        }
        if (empty($player)) {
            die(json_encode(array('status' => false, 'msg' => 'Thiếu tên nhân vật')));
        }
        $goldnumber = empty($goldnumber) ? 0 : $goldnumber;
        $goldbar = empty($goldbar) ? 0 : $goldbar;
        $gem = empty($gem) ? 0 : $gem;
        $zone = empty($zone) ? 0 : $zone;
        $status = empty($status) ? 0 : $status;
        if (empty($location)) {
            die(json_encode(array('status' => false, 'msg' => 'Thiếu địa điểm')));
        }
       
        if (!$row = $SIEUTHICODE->get_row("SELECT * FROM `nrocoin_info_bot` WHERE `player`= '$player' AND `server_nro` = '$server'")) {
            die(json_encode(array('status' => false, 'msg' => 'Nhân vật này không có trong hệ thống')));
        }
        $SIEUTHICODE->update("nrocoin_info_bot", array(
            'gold_number' => $goldnumber,
            'gold_bar' => $goldbar,
            'gem' => $gem,
            'zone' => $zone,
            'location' => $location,
            'status' => $status,
            'updated_at' => gettime(),
        ), " `id` = '" . $row['id'] . "' ");
        die(json_encode(array('status' => true, 'msg' => 'Cập nhật thành công')));
    } else {
        die(json_encode(array('status' => false, 'msg' => 'Thiếu dữ liệu đầu vào')));
    }

}
