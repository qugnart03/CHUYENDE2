<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['player']) && isset($_GET['id'])){
        $player = Anti_xss($_GET['player']);
        $id = Anti_xss($_GET['id']);
        if(empty($player)){
            die(json_encode(array('status'=>false,'msg'=>'Thiếu tên nhân vật')));
        }
        if(empty($id)){
            die(json_encode(array('status'=>false,'msg'=>'Thiếu id đơn hàng')));
        }
        if(!$row = $SIEUTHICODE->get_row("SELECT * FROM `history_coin_nro` WHERE `status` = 0 AND `player`= '$player' AND `id` = '$id'")){
            die(json_encode(array('status'=>false,'msg'=>'Nhân vật này không có đơn hàng')));
        }
        $SIEUTHICODE->update("history_coin_nro", array(
            'status'    => '2',
            'updated_at' =>gettime()
        ), " `id` = '" . $row['id'] . "' ");
        die(json_encode(array('status'=>true,'msg'=>'Cập nhật thành công')));
    }else{
        die(json_encode(array('status'=>false,'msg'=>'Thất bại')));
    }
   
}