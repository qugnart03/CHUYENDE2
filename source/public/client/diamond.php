<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'RÚT VẬT PHẨM | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>
<script>
function Tab(id) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" vactive", "");
    }
    document.getElementById(id).style.display = "block";
    event.currentTarget.className += " vactive";
}
</script>
<style>
.vactive {
    --border-opacity: 1;
    border-color: rgba(239, 68, 68, var(--border-opacity));
    --bg-opacity: 1;
    background-color: rgba(239, 68, 68, var(--bg-opacity));
    font-weight: 800 !important;
    --text-opacity: 1;
    color: rgba(255, 255, 255, var(--text-opacity));
}

.checkbox-withdraw {
    display: inline-block;
    width: 1.25rem;
    height: 1.25rem;
    border: solid 2px #cd3e3e;
    border-radius: 9999px;
}

#xTech-GasForm input[type=radio] {
    display: none;
}

#xTech-GasForm input[type=radio]:checked+.checkbox-withdraw {
    background-color: #cd3e3e;
}

.col-span-7 {
    grid-column: span 7/span 7;
}
</style>
<div class="w-full max-w-6xl mx-auto pt-6 md:pt-8 pb-8">
    <div class="grid grid-cols-8 gap-4 md:p-4 bg-box-dark">
        <?php require_once('Sidebar.php');?>
        <div class="col-span-8 sm:col-span-5 md:col-span-6 lg:col-span-6 xl:col-span-6 px-2 md:px-0">
            <div class="v-bg w-full mb-2 px-2">
                <h2 class="v-title border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                    VẬT PHẬM HIỆN CÓ
                </h2>
                <div class="col-span-12 md:col-span-8 mt-2">
                    <div class="grid grid-cols-12 mb-4 bg-white">
                        <button
                            class="tablinks col-span-4 py-2 font-semibold border-b-2 relative rounded-tl focus:outline-none hover:border-red-500 vactive"
                            onclick="Tab('kc')">
                            <img class="hidden md:block h-12 absolute left-2" style="top: 6px;"
                                src="/assets/images/icon_roblox1.png">
                            <span>Rút <span class="hidden md:inline-block">Kim cương</span><span
                                    class="inline-block md:hidden">Robux</span></span>
                            <p class="text-xs md:text-sm font-semibold">
                                (Liên quân/Free Fire)
                            </p>
                        </button>
                    </div>
                    <div class="bg-white rounded p-2 md:py-4 md:px-5 w-full mb-4">
                        <div class="form-withdraw">
                            <div class="tabcontent" id="kc" style="display: block;">
                                <div class="pb-2 mb-2 border-b border-gray-200 font-bold">
                                    Hiện có:
                                    <b class="text-red-500 uppercase">
                                        <?=$getUser['diamond']?>
                                    </b>
                                    Kim cương = Quân Huy (Tỉ lệ quy đổi ngang nhau)
                                </div>
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-12 md:col-span-6">
                                        <form id="form-Diamond" class="px-2 md:px-0">
                                            <div class="mb-4">
                                                <label class="block mb-2 text-sm font-semibold"><b>Bước 1:</b> Chọn gói
                                                    rút </label>
                                                <div>
                                                    <div class="border-b py-1 px-2 grid grid-cols-12 gap-2 text-sm">
                                                        <div class="col-span-4 text-center font-semibold">
                                                            Gói
                                                        </div>
                                                        <div class="col-span-8 text-center font-semibold">
                                                            Tỉ lệ thêm
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="py-2 px-2 grid grid-cols-12 gap-2 text-sm border-b cursor-default">
                                                        <div class="col-span-1 flex items-center" id="xTech-GasForm">
                                                            <input type="radio" name="packdiamond" id="pack1" value="1"
                                                                class="block h-5 w-5 border-2 border-red-600 rounded-full cursor-pointer"
                                                                checked="">
                                                            <label class="checkbox-withdraw" for="pack1"></label>
                                                        </div>
                                                        <div
                                                            class="col-span-4 border-r flex font-semibold items-center uppercase">
                                                            90 Kim cương
                                                        </div>
                                                        <div class="col-span-7">
                                                            Rút 90 Kim cương
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="py-2 px-2 grid grid-cols-12 gap-2 text-sm border-b cursor-default">
                                                        <div class="col-span-1 flex items-center" id="xTech-GasForm">
                                                            <input type="radio" name="packdiamond" id="pack2" value="2"
                                                                class="block h-5 w-5 border-2 border-red-600 rounded-full cursor-pointer">
                                                            <label class="checkbox-withdraw" for="pack2"></label>
                                                        </div>
                                                        <div
                                                            class="col-span-4 border-r flex font-semibold items-center uppercase">
                                                            230 Kim cương
                                                        </div>
                                                        <div class="col-span-7">
                                                            Rút 230 Kim cương
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="py-2 px-2 grid grid-cols-12 gap-2 text-sm border-b cursor-default">
                                                        <div class="col-span-1 flex items-center" id="xTech-GasForm">
                                                            <input type="radio" name="packdiamond" id="pack3" value="3"
                                                                class="block h-5 w-5 border-2 border-red-600 rounded-full cursor-pointer">
                                                            <label class="checkbox-withdraw" for="pack3"></label>
                                                        </div>
                                                        <div
                                                            class="col-span-4 border-r flex font-semibold items-center uppercase">
                                                            465 Kim cương
                                                        </div>
                                                        <div class="col-span-7">
                                                            Rút 465 Kim cương
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="py-2 px-2 grid grid-cols-12 gap-2 text-sm border-b cursor-default">
                                                        <div class="col-span-1 flex items-center" id="xTech-GasForm">
                                                            <input type="radio" name="packdiamond" id="pack4" value="4"
                                                                class="block h-5 w-5 border-2 border-red-600 rounded-full cursor-pointer">
                                                            <label class="checkbox-withdraw" for="pack4"></label>
                                                        </div>
                                                        <div
                                                            class="col-span-4 border-r flex font-semibold items-center uppercase">
                                                            950 Kim cương
                                                        </div>
                                                        <div class="col-span-7">
                                                            Rút 950 KIm cương
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="py-2 px-2 grid grid-cols-12 gap-2 text-sm border-b cursor-default">
                                                        <div class="col-span-1 flex items-center" id="xTech-GasForm">
                                                            <input type="radio" name="packdiamond" id="pack5" value="5"
                                                                class="block h-5 w-5 border-2 border-red-600 rounded-full cursor-pointer">
                                                            <label class="checkbox-withdraw" for="pack5"></label>
                                                        </div>
                                                        <div
                                                            class="col-span-4 border-r flex font-semibold items-center uppercase">
                                                            2375 Kim cương
                                                        </div>
                                                        <div class="col-span-7">
                                                            Rút 2375 Kim cương
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label class="block mb-1 text-sm font-semibold"><b>Bước 2:</b> Nhập
                                                    thông tin </label>
                                                <input name="data"
                                                    placeholder="Nhập tài khoản|mật khẩu|ID game(nếu có)|Loại game (Liên quân/ Freefire)"
                                                    class="h-10 px-3 rounded font-semibold border border-gray-400 w-full focus:outline-none">
                                                <p class="mt-1 mb-2 text-sm text-gray-600"><i>Ví dụ:
                                                        nickabc|123456|8487548|Freefire</i>
                                                </p>
                                                <label class="block mb-2 text-sm font-semibold"><b>Lưu ý :</b> Các bạn
                                                    cần phải nhập đúng thông tin của các bạn rút nhé !!!</label>
                                            </div>
                                            
                                            
                                            <div>
                                                <button type="button" id="Withdraw" onclick="Diamond()"
                                                    class="h-10 px-3 text-center font-semibold bg-red-500 text-white w-full rounded focus:outline-none">
                                                    RÚT NGAY
                                                </button>
                                            </div>
                                        </form>
                                        <a href="#"
                                            class="mt-4 block md:hidden px-1 font-semibold hover:text-red-600">#Xem Danh
                                            sách rút vật phẩm</a>
                                    </div>
                                    <div class="col-span-12 md:col-span-6 text-sm">
                                        <div class="border-2 border-amber-300 bg-white rounded text-sm leading-7 px-3 py-1 my-2"
                                            style="overflow-y: auto; height: 26.9rem;">
                                            <div class="relative">
                                                <?=$SIEUTHICODE->site('noti_diamond')?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div></div>
                                <div></div> -->
                        </div>
                    </div>

                </div>
                <h2 class="v-title border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                    LỊCH SỬ RÚT VẬT PHẨM
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
                                <?php $i = 0; foreach($SIEUTHICODE->get_list(" SELECT * FROM `withdraw` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC ") as $info){ 
                                     $detail = json_decode($info['detail'], true);
                                    ?>
                                <tr>
                                    <td class="text-sm text-gray-800 text-left px-1 py-1 border-b"><?=$i++;?></td>
                                    <td class="px-2 py-1 md:py-2 text-xs border-b">
                                        <div>
                                            <p class="font-bold text-dark">
                                                Gói: <?=number_format($detail['diamond'])?> KC
                                            </p>
                                            <p class="text-xs text-dark font-semibold">
                                                <?=date('Y-m-d H:i:s',$info['create_date'])?>
                                            </p>
                                            <p class="mt-1 text-xs text-gray-600 font-semibold"><span
                                                    class="text-<?=status_history($info['status'])['color']?>-600"><?=status_history($info['status'])['text']?></span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-xs border-b">
                                        <div class="block mt-2 pt-2 font-semibold leading-5">
                                            <p class="text-dark">
                                                Data: <?=decodecryptData($detail['datagame'])?>
                                            </p>
                                            <p class="text-sm text-<?=status_history($info['status'])['color']?>-600">
                                                <i class="bx bxs-downvote relative" style="top: 1px;"></i>
                                                Nhận:
                                                <b> <?=number_format($detail['diamond'])?> KC</b>
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
// rut kim cuong
function Diamond() {
    $('#Withdraw').html('<i class="fa fa-spinner"></i> Đang xử lý...').prop('disabled',
        true);
    var data = $("#form-Diamond").serialize();
    $.ajax({
        url: '/Model/Withdraw',
        data: data,
        dataType: "json",
        type: "POST",
        success: function(data) {
            if (data.status == 'success') {
                Toast(data.status, data.msg);
                setTimeout(function() {
                    window.location.href = "/user/diamond"
                }, 2000);
            } else {
                $('.content-popup').text(data.msg);
                openModal('modalMinigame');
            }
            $('#Withdraw').html(
                    'RÚT NGAY')
                .prop('disabled', false);
        }
    });
}
$(document).ready(function() {
    $('#datatable').DataTable();
});
</script>


<?php 
    require_once("../../public/client/Footer.php");
?>