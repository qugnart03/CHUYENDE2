<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['player']) && isset($_GET['id']) && isset($_GET['status'])){
        $player = Anti_xss($_GET['player']);
        $id = Anti_xss($_GET['id']);
        $status = Anti_xss($_GET['status']);
        if(empty($player)){
            die(json_encode(array('status'=>false,'msg'=>'Thiếu tên nhân vật')));
        }
        if(empty($id)){
            die(json_encode(array('status'=>false,'msg'=>'Thiếu id đơn hàng')));
        }
        if(empty($status)){
            die(json_encode(array('status'=>false,'msg'=>'Thiếu trạng thái đơn hàng')));
        }
        if(!$row = $SIEUTHICODE->get_row("SELECT * FROM `history_gem_nro` WHERE `id` = '$id' AND `player` = '$player' AND (`status` = 0 OR `status` = 1)")){
            die(json_encode(array('status'=>false,'msg'=>'Nhân vật này không có đơn hàng')));
        }
        $SIEUTHICODE->update("history_gem_nro", array(
            'status'    => $status,
            'updated_at' =>gettime()
        ), " `id` = '" . $row['id'] . "' ");
        die(json_encode(array('status'=>true,'msg'=>'Cập nhật thành công')));
    }else{
        die(json_encode(array('status'=>false,'msg'=>'Thất bại')));
    }
   
}