<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
if (isset($_GET['status']) && $_GET['message'] && $_GET['request_id']) {
    $status = Anti_xss($_GET['status']);
    $request_id = Anti_xss($_GET['request_id']);
    $message = Anti_xss($_GET['message']);

    $row = $SIEUTHICODE->get_row(" SELECT * FROM `history_gem_api_nro` WHERE `request_id` = '$request_id' AND `status` = '1'");
    if (!$row) {
        die(json_encode([
            'status' => 'error',
            'msg' => 'Truy cập trái phép hệ thống đã lưu IP: ' . myip() . '',
        ]));
    }
    if ($status == 4) {
        $SIEUTHICODE->update("history_gem_api_nro", array(
            'status' => 4,
            'note' => $message,
        ), " `id` = '" . $row['id'] . "' ");
    } else {
        $SIEUTHICODE->update("history_gem_api_nro", array(
            'status' => $status,
            'note' => $message,
        ), " `id` = '" . $row['id'] . "' ");
    }

} else {
    die(json_encode([
        'status' => 'error',
        'msg' => 'Truy cập trái phép hệ thống đã lưu IP: ' . myip() . '',
    ]));
}
