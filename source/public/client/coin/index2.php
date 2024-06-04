<?php
$title = "BÁN VÀNG TỰ ĐỘNG";
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/client/Header.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/client/Nav.php';
?>

<div class="mt-12 relative w-full max-w-6xl mx-auto text-gray-800 pb-8 px-2 md:px-0">
    <div class="mb-4 py-4 md:p-4 bg-box-dark">
        <div
            class="fade-in mb-2 md:mb-4 block uppercase md:py-4 text-center text-yellow-400 md:text-3xl text-2xl font-extrabold text-fill ">
            <?=$SIEUTHICODE->site('title_banvang_lau')?>
        </div>
        <div class="tw-mb-2 mb-2 p-2">
            <div class="text-xl bg-blue-100 text-gray-900 p-2 px-3 rounded mb-4 panel-body hidetext">
                <?=$SIEUTHICODE->site('notice_banvang_lau')?>
            </div>
            <div style="text-align: center;">
                <span class="viewmore">Xem tất cả »</span>
            </div>
        </div>
        <script>
        $('body').delegate('.viewmore', 'click', function() {
            $(this).addClass('viewless').removeClass('viewmore');
            $(this).text('« Thu gọn');
            $('.hidetext').addClass('showtext').removeClass('hidetext');
        })
        $('body').delegate('.viewless', 'click', function() {
            $(this).addClass('viewmore').removeClass('viewless');
            $(this).text('Xem tất cả »');
            $('.showtext').addClass('hidetext').removeClass('showtext');
        })

        $('body').delegate('.btn-viewmore', 'click', function() {
            var ele = $(this).closest('.panel-body').find(".special-text").toggleClass('-expanded');
            if ($(ele).hasClass('-expanded')) {
                $(this).html('« Thu gọn');
            } else {
                $(this).html('Xem tất cả »');
            }
        })
        </script>
        <div class="mt-4">
            <div class="grid grid-cols-12 gap-4 md:p-4">
                <div class="col-span-12 sm:col-span-12 md:col-span-3 lg:col-span-3 xl:col-span-3 lg:px-0 px-2">
                    <img class="w-full object-fill object-center rounded cursor-pointer"
                        src="<?=BASE_URL($SIEUTHICODE->site('logo_banvang_lau'))?>">
                    <p class="text-white mt-2"><i class="fa fa-calendar" aria-hidden="true"></i>
                        <?=$SIEUTHICODE->site('title_banvang_lau')?></p>
                </div>
                <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xl:col-span-5 lg:px-0 px-2">
                    <div class="v-account-detail p-2 md:px-0">
                        <div class="v-infomations mb-10">
                            <div class="px-5">
                                <span class="mb-2 block">
                                    <label class="text-white">Chọn máy chủ:</label>
                                    <div class="flex items-center relative">
                                        <select id="server" onchange="selectData()"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none select2">
                                            <option data-factor="0" data-min="0" data-max="0" value="">Máy chủ</option>
                                            <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `coin_nro_lau` WHERE `status` = '1' ORDER BY `server_nro` ASC ") as $group) {?>
                                            <option data-factor="<?=$group['factor'];?>"
                                                data-min="<?=$group['min_value'];?>"
                                                data-max="<?=$group['max_value'];?>" value="<?=$group['id'];?>">Vũ trụ
                                                <?=$group['server_nro'];?></option>
                                            <?php }?>
                                        </select>
                                       
                                    </div>
                                </span>
                                <span class="mb-2 block">
                                    <label class="text-white">Nhân vật:</label>
                                    <div class="flex items-center relative"><input placeholder="Nhân vật" id="player"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                    </div>
                                </span>
                                <span class="mb-2 block">
                                    <label class="text-white">Nhập số tiền cần mua:</label>
                                    <div class="flex items-center relative"><input type="number" placeholder="Số tiền"
                                            id="money"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                    </div>
                                    <i class="text-white">Số tiền thanh toán phải từ <span id="min_value">0</span>đ đến
                                        <span id="max_value">0</span>đ</i>
                                </span>
                                <span class="mb-2 block">
                                    <label class="text-white">Hệ số:</label>
                                    <div class="flex items-center relative"><input readonly placeholder="Hệ số"
                                            id="factor"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                    </div>
                                </span>
                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4 px-2 md:px-0">
                    <div class="mt-4 text-center">
                        <button
                            class="uppercase w-full flex w-40 font-semibold rounded items-center justify-center h-10 text-white text-xl rounded-none focus:outline-none px-4 text-center hover:bg-lime-700 hover:border-lime-700 bg-lime-600">
                            Tổng: <p class="ml-1" id="actually">0 Thỏi vàng</p>
                        </button>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="button" onclick="Pay()" id="Submit"
                            class="uppercase w-full flex w-40 font-semibold rounded items-center justify-center h-10 text-white text-xl rounded-none focus:outline-none px-4 text-center bg-red-500 hover:bg-red-600">
                            THANH TOÁN
                        </button>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12 xl:col-span-12 px-2 md:px-0">
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
                                        <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                            THỜI GIAN
                                        </th>

                                    </tr>
                                </thead>
                                <tbody class="text-sm font-semibold">
                                    <?php if(isset($getUser)):?>
                                    <?php $i = 0; foreach($SIEUTHICODE->get_list(" SELECT * FROM `history_coin_nro_lau` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC ") as $info){ 
                                    ?>
                                    <tr>
                                        <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$i++;?></td>
                                        <td class="px-2 py-1 md:py-2 text-xs border-b">
                                            <div>
                                                <p class="font-bold text-dark">
                                                    Máy chủ: <?=$info['server_nro']?> sao
                                                </p>

                                                <p class="mt-1 text-xs text-gray-600 font-semibold"><span
                                                        class="text-<?=status_history_nro($info['status'])['color']?>-600"><?=status_history_nro($info['status'])['text']?></span>
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 text-xs border-b">
                                            <div class="block mt-2 pt-2 font-semibold leading-5">
                                                <p>Thanh toán: <span
                                                        class="text-green-600"><?=format_cash($info['cash'])?>đ</span>
                                                </p>
                                                <p class="text-dark">
                                                    Tên nhân vật: <?=$info['player']?>
                                                </p>
                                                <p
                                                    class="text-sm text-<?=status_history_nro($info['status'])['color']?>-600">
                                                    <i class="bx bxs-downvote relative" style="top: 1px;"></i>
                                                    Nhận:
                                                    <b> 
                                                        <?=format_cash($info['gold_bar'])?> Thỏi vàng
                                                       
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-2 py-1 md:py-2 text-xs border-b">
                                            <div>

                                                <p class="text-xs text-dark font-semibold">
                                                    <?=$info['created_at']?>
                                                </p>

                                            </div>
                                        </td>


                                    </tr>
                                    <?php }?>
                                    <?php endif;?>
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
<div class="animated modal fadeIn out fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"
    style="z-index: 999;" id="modalDialog">
    <div
        class="modal-dialog shadow-inner max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">
        <div class="modal-content">
            <div class="text-red-600 font-bold text-lg text-center mb-3 p-3 uppercase border-b border-gray-300">
                XÁC NHẬN THÔNG TIN THANH TOÁN
            </div>

            <div class="overflow-auto p-2 md:px-4" style="max-height: 600px;">
                <div class="relative px-2 pb-4 text-gray-900">
                    <div class="md:px-4 overflow-auto p-2" style="max-height:400px">
                        <div class="pb-4 relative content-popup">
                            <div class="relative">
                                <label for="">Tên nhân vật:</label>
                                <input type="text" id="player0" placeholder="Tên nhân vật"
                                    class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="border-t border-gray-300 flex p-3 md:px-3 justify-end">
                <div class="flex items-center">
                    <button
                        class="transition duration-200 hover:bg-lime-700 hover:border-lime-700 bg-lime-600 focus:outline-none border-2 border-lime-600 py-1 px-3 rounded font-bold text-white">
                        Xác nhận
                    </button>
                    <button
                        class="ml-1 rounded focus:outline-none transition duration-200 hover:bg-blue-500 hover:text-white py-1 border-2 border-blue-500 font-semibold text-blue-600 px-6"
                        data-close="">
                        Đóng
                    </button>
                    <span class="absolute cursor-pointer text-3xl text-gray-800 pt-3 px-3"
                        style="right: -1px; top: -2px;" data-close=""><i class="bx bxs-x-square"></i></span>
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
<script>
function Pay() {
    $('#Submit').html('<i class="fa fa-spinner fa-pulse"></i> ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "/Model/Pay",
        method: "POST",
        dataType: "JSON",
        data: {
            type: 'coinlau',
            user: $("#player").val(),
            server: $("#server").val(),
            money: $("#money").val()
        },
        success: function(response) {
            if (response.status == 'success') {
                Toast(response.status, response.msg);
                setTimeout(function() {
                    window.location = '/dich-vu-auto/ban-vang-nro-lau';
                }, 1000);
            } else {
                Toast(response.status, response.msg)
            }
            $('#Submit').html(
                    'Xác nhận')
                .prop('disabled', false);
        }
    });
}

function selectData() {
    const serverSelect = document.getElementById('server');
    const factorInput = document.getElementById('factor');
    const minElement = document.getElementById('min_value');
    const maxElement = document.getElementById('max_value');
    const moneyInput = document.getElementById('money');
    const resultOutput = document.getElementById('actually');

    function updateData() {
        const selectedOption = serverSelect.options[serverSelect.selectedIndex];
        const factor = selectedOption.getAttribute('data-factor');
        const min = selectedOption.getAttribute('data-min');
        const max = selectedOption.getAttribute('data-max');

        factorInput.value = formatNumberWithCommas(factor);
        minElement.innerHTML = formatNumberWithCommas(min);
        maxElement.innerHTML = formatNumberWithCommas(max);
        calculateAmount();
    }

    serverSelect.addEventListener('change', updateData);

    moneyInput.addEventListener('input', calculateAmount);

    updateData();

    function calculateAmount() {
        const moneyInput = document.getElementById('money');
        const resultOutput = document.getElementById('actually');
        const money = parseInt(moneyInput.value.replace(/\D/g,
            ''));
        const factorInput = document.getElementById('factor');
        const factor = factorInput.value;

        if (!isNaN(money) && !isNaN(factor)) {
            const totalAmount = Math.ceil(factor * money / 1000);
            resultOutput.innerHTML = formatNumberWithCommas(totalAmount) + ' Thỏi vàng';
        }
    }

    function formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

}
</script>

<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/client/Footer.php';?>