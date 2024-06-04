<?php
   require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
   require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php');
   // Chuyển đổi thời gian hiện tại về định dạng ngày tháng năm giờ phút giây
   $currentTime = date("Y/m/d H:i:s");
   // Cập nhật dữ liệu
   $SIEUTHICODE->update("history_gem_nro", array(
       'status'    => 3,
       'updated_at' => gettime()
   ), "STR_TO_DATE('$currentTime', '%Y/%m/%d %H:%i:%s') - INTERVAL 5 MINUTE > STR_TO_DATE(`updated_at`, '%Y/%m/%d %H:%i:%s') AND `status` = 0");
   $SIEUTHICODE->update("history_coin_nro", array(
    'status'    => 3,
    'updated_at' => gettime()
), "STR_TO_DATE('$currentTime', '%Y/%m/%d %H:%i:%s') - INTERVAL 5 MINUTE > STR_TO_DATE(`updated_at`, '%Y/%m/%d %H:%i:%s') AND `status` = 0");
   ?>
   