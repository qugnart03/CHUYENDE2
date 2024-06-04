<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'LỊCH SỬ MUA VÀNG TỰ ĐỘNG | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>
<div class="w-full max-w-6xl mx-auto pt-6 md:pt-8 pb-8">
    <div class="grid grid-cols-8 gap-4 md:p-4 bg-box-dark">
        <?php require_once('Sidebar.php');?>
        <div class="col-span-8 sm:col-span-5 md:col-span-6 lg:col-span-6 xl:col-span-6 px-2 md:px-0">
            <div class="v-bg w-full mb-2 px-2">
                <h2 class="v-title border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                    LỊCH SỬ MUA NGỌC
                </h2>
                <div class="v-table-content select-text">
                    <div class="py-2 overflow-x-auto scrolling-touch max-w-400">
                        <table id="datatable" class="table-auto w-full scrolling-touch min-w-850">
                            <thead>
                                <tr class="v-border-hr select-none border-b-2 border-gray-300">
                                    <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        STT
                                    </th>
                                    <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        THÔNG TIN
                                    </th>
                                    <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        CHI TIẾT
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="text-sm font-semibold">
                                <?php $i = 0; foreach($SIEUTHICODE->get_list(" SELECT * FROM `history_gem_nro` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC ") as $info){ 
                                    ?>
                                <tr>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$i++;?></td>
                                    <td class="px-2 py-1 md:py-2 text-xs border-b">
                                        <div>
                                            <p class="font-bold text-dark">
                                                Máy chủ: <?=$info['server_nro']?>
                                            </p>
                                            <p class="text-xs text-dark font-semibold">
                                                <?=$info['created_at']?>
                                            </p>
                                            <p class="mt-1 text-xs text-gray-600 font-semibold"><span
                                                    class="text-<?=status_history_nro($info['status'])['color']?>-600"><?=status_history_nro($info['status'])['text']?></span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-xs border-b">
                                        <div class="block mt-2 pt-2 font-semibold leading-5">
                                            <p>Thanh toán: <span class="text-green-600"><?=format_cash($info['cash'])?>đ</span></p>
                                            <p class="text-dark">
                                                Tên nhân vật: <?=$info['player']?>
                                            </p>
                                            <p class="text-sm text-<?=status_history_nro($info['status'])['color']?>-600">
                                                <i class="bx bxs-downvote relative" style="top: 1px;"></i>
                                                Nhận:
                                                <b> <?=format_cash($info['gem_number'])?> ngọc</b>
                                            </p>
                                        </div>
                                    </td>


                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="v-table-note mt-1 py-1 font-semibold text-white text-sm">
                        Dùng điện thoại <i class="bx bxs-mobile"></i>, hãy vuốt bảng từ phải qua trái (<i
                            class="bx bxs-arrow-from-right"></i>) để xem đầy đủ thông tin!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




<script type="text/javascript">

$(document).ready(function() {
    $('#datatable').DataTable();
});
</script>


<?php 
    require_once("../../public/client/Footer.php");
?>