<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['player'])){
        $player = Anti_xss($_GET['player']);
        if(empty($player)){
            die(json_encode(array('status'=>false,'msg'=>'Thiếu tên nhân vật')));
        }
        if(!$SIEUTHICODE->get_row("SELECT * FROM `history_gem_nro` WHERE `player`= '$player' AND (`status` = 0 OR `status` = 1)")){
            die(json_encode(array('status'=>false,'msg'=>'Nhân vật này không có đơn hàng')));
        }
        $listData = array();
        foreach($SIEUTHICODE->get_list("SELECT * FROM `history_gem_nro` WHERE `player`= '$player' AND (`status` = 0 OR `status` = 1)") as $row){
            $listData[] = $row;
        }
        die(json_encode(array('status'=>true,'msg'=>'Thành công','data'=>$listData)));
    }else{
        die(json_encode(array('status'=>false,'msg'=>'Thất bại')));
    }
   
}