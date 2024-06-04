<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
CheckLogin();
$title = 'NẠP ATM/MOMO TỰ ĐỘNG| ' . $SIEUTHICODE->site('tenweb');
require_once "../../public/client/Header.php";
require_once "../../public/client/Nav.php";
?>
<div class="w-full max-w-6xl mx-auto pt-6 md:pt-8 pb-8">
    <div class="grid grid-cols-8 gap-4 md:p-4 bg-box-dark">
        <?php require_once 'Sidebar.php';?>
        <div class="col-span-8 sm:col-span-5 md:col-span-6 lg:col-span-6 xl:col-span-6 px-2 md:px-0">
            <div class="w-full mb-10">
                <h2
                    class="v-title uppercase border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                    Nạp tiền qua ATM/MOMO
                </h2>
                <div class="text-xl bg-blue-100 text-gray-900 mt-3 p-2 px-3 rounded mb-4">
                    <?=$SIEUTHICODE->site('luuy_napbank')?>
                </div>
                <div class="fade-in grid grid-cols-8 gap-2 px-2 md:px-0">
                    <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `bank` ") as $bank): ?>
                    <div
                        class="hover:shadow-lg border border-gray-300 col-span-8 sm:col-span-6 md:col-span-4 lg:col-span-4 xl:col-span-4 relative rounded border border-gray-300">
                        <img data-src="<?=qrbank($bank['short_name'], $bank['accountNumber'], $bank['accountName'], 30000, $SIEUTHICODE->site('noidung_naptien') . $getUser['id'])?>"
                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                            class="rounded-t h-60 md:h-64a w-full object-fill object-center lazyLoad" />
                        <div class="py-1">
                            <div class="col-span-12 px-2 text-white items-center justify-center text-base md:text-sm">
                                <p>
                                    Cổng thanh toán:

                                    <b
                                        class="text-white">
                                        <?=$bank['short_name'];?> </b>
                                </p>
                            </div>
                            <div class="col-span-12 px-2 text-white items-center justify-center text-base md:text-sm">
                                <p>
                                    Chủ TK:

                                    <b
                                        class="text-white">
                                        <?=$bank['accountName'];?> </b>
                                </p>
                            </div>
                            <div class="col-span-12 px-2 text-white items-center justify-center text-base md:text-sm">
                                <span>
                                    Số TK:

                                    <b id="copystk<?=$bank['id']?>"
                                        class="text-white">
                                        <?=$bank['accountNumber'];?> </b>
                                        <button onclick="copyText('copystk<?=$bank['id']?>')" type="button"
                                        class="copy ml-1 bg-gray-500 font-semibold text-white rounded focus:outline-none px-2"
                                        >
                                        <i class="relative bx bx-copy"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="col-span-12 px-2 text-white items-center justify-center text-base md:text-sm">
                                <span>
                                    Nội dung:

                                    <b id="copynd<?=$bank['id']?>"
                                        class="text-white">
                                        <?=$SIEUTHICODE->site('noidung_naptien') . $getUser['id'];?></b>
                                   
                                        <button onclick="copyText('copynd<?=$bank['id']?>')" type="button"
                                        class="copy ml-1 bg-gray-500 font-semibold text-white rounded focus:outline-none px-2"
                                        >
                                        <i class="relative bx bx-copy"></i>
                                    </button>
                                </span>
                               
                            </div>


                        </div>

                    </div>
                    <?php endforeach;?>


                </div>
               
            </div>
            <div class="v-bg w-full mb-2 px-2">
                <h2
                    class="v-title border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                    LỊCH SỬ NẠP BANK
                </h2>
                <div class="v-table-content select-text">
                    <div class="py-2 overflow-x-auto scrolling-touch max-w-400">
                        <table id="datatable" class="table-auto w-full scrolling-touch min-w-850">
                            <thead>
                                <tr class="v-border-hr select-none border-b-2 border-gray-300">
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        STT
                                    </th>
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        MÃ GD
                                    </th>
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        T.NHẬN
                                    </th>
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        NỘI DUNG
                                    </th>
                                   
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        NẠP LÚC
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-semibold">
                                <?php $i = 0; foreach($SIEUTHICODE->get_list("SELECT * FROM `bank_auto` WHERE `username` = '".$getUser['username']."' ") as $order) { ?>
                                <tr>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$i++;?></td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b">
                                        <?=$order['tid'];?></td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b">
                                        <?=format_cash($order['amount']);?> VNĐ</td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$order['description'];?>
                                    </td>
                                 
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b">
                                        <?=$order['time'];?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="v-table-note mt-1 py-1 font-semibold <?=$SIEUTHICODE->site('style_theme') == 'dark' ? 'text-white':'text-dark'?> text-sm">
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
require_once "../../public/client/Footer.php";
?>