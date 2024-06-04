<?php
        require_once("../../config/config.php");
        require_once("../../config/function.php");
        $title = 'THANH TOÁN | '.$SIEUTHICODE->site('tenweb');
        require_once("../../public/client/Header.php");
        require_once("../../public/client/Nav.php");
?>
<?php
if(isset($_GET['id']))
{
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `category_caythue` WHERE `id` = '".Anti_xss($_GET['id'])."'  ");
    if(!$row)
    {
        new Redirect('/');
    }
}
else
{
    new Redirect('/');
}

?>


<div class="mt-12 relative w-full max-w-6xl mx-auto text-gray-800 pb-8 px-2 md:px-0">
    <div class="mb-4 py-4 md:p-4 bg-box-dark">
        <div
            class="fade-in mb-2 md:mb-4 block uppercase md:py-4 text-center text-yellow-400 md:text-3xl text-2xl font-extrabold text-fill ">
            <?=$row['title'];?>
        </div>
        <div class="text-xl bg-blue-100 text-gray-900 p-2 px-3 rounded mb-4">
            <?=base64_decode($row['content'])?>
        </div>
        <div class="grid grid-cols-12 gap-4 md:p-4">
            <div class="col-span-12 sm:col-span-12 md:col-span-3 lg:col-span-3 xl:col-span-3 lg:px-0 px-2">
                <img data-src="<?=BASE_URL($row['img']);?>" src="<?=BASE_URL('');?>/assets/img/index.svg"
                    data-sizes="auto" class="border border-gray-400 mb-2 w-full lazyLoad lazy" />
            </div>
            <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 xl:col-span-4 lg:px-0 px-2">
                <div class="v-account-detail p-2 md:px-0">
                    <div class="v-infomations mb-10">
                        <div class="px-5">
                            <span class="mb-2 block">
                                <div class="flex items-center relative">
                                    <select id="dichvu" onchange="totalPayment()"
                                        class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none select2">
                                        <option data-money="0" value="">* Chọn gói cần mua</option>
                                        <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `groups_caythue` WHERE `category` = '".$row['id']."' ") as $group) {?>
                                        <option data-money="<?=$group['money'];?>" value="<?=$group['id'];?>">
                                            <?=$group['title'];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </span>
                            <span class="mb-2 block">
                                <div class="flex items-center relative"><input placeholder="Nhập tài khoản đăng nhập"
                                        id="tk"
                                        class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                </div>
                            </span>
                            <span class="mb-2 block">
                                <div class="flex items-center relative"><input placeholder="Nhập mật khẩu" id="mk"
                                        class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                </div>
                            </span>
                            <span class="mb-2 block">
                                <div class="flex items-center relative"><input placeholder="Nhập máy chủ nếu có"
                                        id="server"
                                        class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                </div>
                            </span>
                            <span class="mb-2 block">
                                <div class="flex items-center relative"><textarea placeholder="Nhập ghi chú nếu có"
                                        id="ghichu"
                                        class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none"></textarea>
                                </div>
                            </span>
                            <div
                                class="sticky col-span-12 grid grid-cols-10 gap-2 select-none px-2 color-grant text-xl font-bold rounded">
                                <div class="col-span-12 md:col-span-12">
                                    TỔNG: <b id="thanhtoan">0</b>đ
                                </div>
                            </div>
                            <div class="mt-4 text-center"><button type="button" id="Submit"
                                    class="uppercase flex w-40 font-semibold rounded items-center justify-center h-10 text-white text-xl rounded-none focus:outline-none px-4 text-center bg-red-500 hover:bg-red-600">
                                    ĐẶT HÀNG
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-12 md:col-span-5 lg:col-span-5 xl:col-span-5 px-2 md:px-0">
                <div class="v-table-content select-text">
                    <div class="py-2">
                        <table id="datatable" class="table-auto w-full">
                            <thead>
                                <tr class="v-border-hr select-none border-b-2 border-gray-300">
                                    <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        STT
                                    </th>
                                    <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        Gói
                                    </th>
                                    <th class="v-table-title py-2 text-sm font-bold text-white text-left px-1">
                                        Giá tiền
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="text-sm font-semibold">
                                <?php $i = 1; foreach($SIEUTHICODE->get_list("SELECT * FROM `groups_caythue` WHERE `category` = '".$row['id']."' ORDER BY `id` ASC") as $group):?>
                                <tr>
                                    <td class="text-sm text-white text-left px-1 py-1 border-b"><?=$i++?></td>
                                    <td class="text-sm text-white text-left px-1 py-1 border-b"><?=$group['title']?>
                                    </td>
                                    <td class="text-sm text-white text-left px-1 py-1 border-b">
                                        <?=format_cash($group['money'])?>đ</td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>



<script type="text/javascript">
function totalPayment() {
    var ketqua = $('#dichvu').children('option:selected').attr('data-money').replace(/(.)(?=(\d{3})+$)/g, '$1.');
    $("#thanhtoan").html(ketqua);
}
$("#Submit").on("click", function() {

    $('#Submit').html('<i class="fa fa-spinner fa-pulse"></i> ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/CayThue.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            type: 'Order',
            tk: $("#tk").val(),
            mk: $("#mk").val(),
            server: $("#server").val(),
            ghichu: $("#ghichu").val(),
            dichvu: $("#dichvu").val()
        },
        success: function(response) {
            if (response.status == 'success') {
                Toast(response.status, response.msg);
                setTimeout(function() {
                    window.location = '/History/Cay-thue';
                }, 1000);
            } else {
                Toast(response.status, response.msg)
            }
            $('#Submit').html(
                    'ĐẶT HÀNG')
                .prop('disabled', false);
        }
    });
});
</script>

<?php 
    require_once("../../public/client/Footer.php");
?>