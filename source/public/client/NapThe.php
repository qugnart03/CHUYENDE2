<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'NẠP THẺ CÀO | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>
<div class="w-full max-w-6xl mx-auto pt-6 md:pt-8 pb-8">
    <div class="grid grid-cols-8 gap-4 md:p-4 bg-box-dark">
        <?php require_once('Sidebar.php');?>
        <div class="col-span-8 sm:col-span-5 md:col-span-6 lg:col-span-6 xl:col-span-6 px-2 md:px-0">
            <div class="w-full mb-2">
                <div class="rounded w-full">
                    <span>
                        <form method="POST" class="w-full">
                            <h2
                                class="v-title border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                                KHU NẠP THẺ
                            </h2>
                            <div class="py-3 px-5">
                                <div class="text-xl bg-blue-100 py-2 overflow-x-auto scrolling-touch max-w-380 text-gray-900 p-2 px-3 rounded mb-4">
                                    <?=$SIEUTHICODE->site('luuy_naptien')?>
                                </div>
                                <span class="mb-2 block">
                                    <div class="flex items-center relative">

                                        <select id="loaithe"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none select2">
                                            <option value="">Chọn nhà mạng</option>
                                            <option value="VIETTEL">VIETTEL</option>
                                            <option value="VINAPHONE">VINAPHONE</option>
                                            <option value="MOBIFONE">MOBIFONE</option>
                                            <option value="VNMB">Vietnammobile</option>
                                            <option value="ZING">Zing</option>
                                            <option value="GARENA">Garena</option>
                                            <option value="GATE">GATE</option>
                                            <option value="VCOIN">Vcoin</option>
                                        </select>
                                        <!-- <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                class="fill-current h-4 w-4">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                                </path>
                                            </svg>
                                        </div> -->
                                    </div>
                                </span>
                                <span class="mb-2 block">
                                    <div class="flex items-center relative">

                                        <select id="menhgia"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none select2">
                                            <option value="">Chọn mệnh giá</option>
                                            <option value="10000">10.000</option>
                                            <option value="20000">20.000</option>
                                            <option value="30000">30.000</option>
                                            <option value="50000">50.000</option>
                                            <option value="100000">100.000</option>
                                            <option value="200000">200.000</option>
                                            <option value="300000">300.000</option>
                                            <option value="500000">500.000</option>
                                            <option value="1000000">1.000.000</option>
                                        </select>
                                        <!-- <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                class="fill-current h-4 w-4">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                                </path>
                                            </svg>
                                        </div> -->
                                    </div>
                                </span>
                                <span class="mb-2 block">
                                    <div class="flex items-center relative"><input type="number" id="pin"
                                            placeholder="Mã số thẻ"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none" />
                                    </div>
                                </span>
                                <span class="mb-2 block">
                                    <div class="flex items-center relative"><input type="number" id="seri"
                                            placeholder="Số serial"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none" />
                                    </div>
                                </span>
                                <span class="mb-2 block">
                                    <div class="flex items-center relative"><input type="text" id="captcha"
                                            placeholder="Nhập mã captcha"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none" />
                                        <img class="" src="<?=BASE_URL('/auth/gencaptchav2')?>" id="imgcaptcha"
                                            onclick="ReloadCaptcha()" data-toggle="tooltip" data-placement="top"
                                            title="">
                                    </div>
                                </span>
                                <div class="mt-4 text-center">
                                    <button type="button" id="NapThe"
                                        class="uppercase flex w-40 font-semibold rounded items-center justify-center h-10 text-white text-xl rounded-none focus:outline-none px-4 text-center bg-red-500 hover:bg-red-600">
                                        Nạp Thẻ
                                    </button>
                                </div>
                                <div class="mt-2 text-red-500 font-semibold text-sm">
                                </div>
                            </div>
                        </form>
                    </span>
                    <!---->
                </div>
            </div>
            <div class="v-bg w-full mb-2 px-2">
                <h2
                    class="v-title border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                    LỊCH SỬ NẠP THẺ
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
                                        NHÀ MẠNG
                                    </th>
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        M.GIÁ/T.NHẬN
                                    </th>
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        SERIAL THẺ
                                    </th>
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        MÃ THẺ
                                    </th>
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        TRẠNG THÁI
                                    </th>
                                    <th
                                        class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        NẠP LÚC
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-semibold">
                                <?php $i = 0; foreach($SIEUTHICODE->get_list("SELECT * FROM `cards` WHERE `user_id` = '".$getUser['id']."' ") as $cards) { ?>
                                <tr>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$i++;?></td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b">
                                        <?=$cards['loaithe'];?></td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b">
                                        <?=format_cash($cards['menhgia']);?> VNĐ</td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$cards['seri'];?>
                                    </td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$cards['pin'];?>
                                    </td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b">
                                        <?=status($cards['status']);?>
                                    </td>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b">
                                        <?=$cards['createdate'];?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="v-table-note mt-1 py-1 font-semibold text-white text-sm">
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
$("#NapThe").on("click", function() {
    $('#NapThe').html('<i class="fa fa-spinner fa-pulse"></i> ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/NapThe.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            loaithe: $("#loaithe").val(),
            menhgia: $("#menhgia").val(),
            seri: $("#seri").val(),
            pin: $("#pin").val(),
            captcha: $("#captcha").val()
        },
        success: function(response) {
            if (response.status == 'success') {
                Toast(response.status, response.msg);
                setTimeout(function() {
                    window.location = '/';
                }, 1000);
            } else {
                Toast(response.status, response.msg)
            }
            $('#NapThe').html(
                    'Nạp Thẻ')
                .prop('disabled', false);
        }
    });
});

function ReloadCaptcha() {
    document.getElementById('imgcaptcha').src = '<?=BASE_URL('/auth/gencaptchav2')?>';
}
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable();
});
</script>
<?php 
    require_once("../../public/client/Footer.php");
?>