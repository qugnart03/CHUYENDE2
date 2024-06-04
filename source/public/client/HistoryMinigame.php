<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'LỊCH SỬ CHƠI MINIGAME | '.$SIEUTHICODE->site('tenweb');
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
                    LỊCH SỬ CHƠI MINIGAME
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
                                        THỜI GIAN
                                    </th>
                                    <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        CHI TIẾT
                                    </th>
                                    <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        DỮ LIỆU
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="text-sm font-semibold">
                                <?php $i = 0; foreach($SIEUTHICODE->get_list(" SELECT * FROM `history_minigame` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC ") as $info){ 
                                     $detail = json_decode($info['detail'], true);
                                    ?>
                                <tr>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$i++;?></td>
                                    <td class="tw-px-2 tw-py-1 md:tw-py-2 tw-text-xs border-b">
                                        <div>

                                            <p class="text-black">
                                                <span
                                                    class="badge badge-danger"><?= date('Y-m-d H:i:s', $info['create_date']) ?>
                                                </span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="tw-px-2 tw-py-2 border-b">
                                        <div class="md:tw-text-sm">
                                            <p class="tw-font-bold text-black"><?= $detail['name_product'] ?> </p>
                                            <p class="tw-font-semibold text-xs"><?= $detail['chitiet'] ?></p>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-xs border-b">
                                        <div class="block mt-2 pt-2 font-semibold leading-5">
                                            <?php if(isset($detail['taikhoan'])):?>
                                            <p class="text-sm text-red-600">
                                                <i class="bx bxs-downvote relative" style="top: 1px;"></i>
                                                Tài khoản:
                                                <!--<b> <?=$detail['data_account'][0]['taikhoan']?></b>-->
                                                 <b> <?=$detail['taikhoan'][0]?></b>
                                            </p>
                                            <p class="text-sm text-green-600">
                                                <i class="bx bxs-downvote relative" style="top: 1px;"></i>
                                                Mật khẩu:
                                                <!--<b> <?=$detail['data_account'][0]['matkhau']?></b>-->
                                                <b> <?=$detail['taikhoan'][1]?></b>
                                            </p>
                                            <?php endif;?>
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