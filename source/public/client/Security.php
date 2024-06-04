<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'XÁC THỰC 2 BƯỚC | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>
<div class="w-full max-w-6xl mx-auto pt-6 md:pt-8 pb-8">
    <div class="grid grid-cols-8 gap-4 md:p-4 bg-box-dark">
        <?php require_once('Sidebar.php');?>
        <div class="col-span-8 sm:col-span-5 md:col-span-6 lg:col-span-6 xl:col-span-6 px-2 md:px-0">
            <div class="v-bg w-full mb-5">
                <h2 class="v-title border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                    Two-Factor Authentication</h2>
                <div class="v-table-content">
                    <div class="py-3 pt-5">
                        <table class="table-auto w-full">
                            <tbody class="text-sm select-text">
                                <tr class="v-border-hr-2 rounded-none border-b border-gray-200 py-10">
                                    <td class="v-account-text py-2 font-bold text-white">Bật/Tắt Google 2FA</td>
                                    <td class="v-table-title font-bold px-2 py-2 text-white uppercase">
                                        <div class="flex items-center relative"> <select id="status_2fa"
                                                class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                                <option <?=$getUser['status_2fa'] == 1 ? 'selected' : '';?> value="1">
                                                    Bật</option>
                                                <option <?=$getUser['status_2fa'] == 0 ? 'selected' : '';?> value="0">
                                                    Tắt</option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    class="fill-current h-4 w-4">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="v-border-hr-2 rounded-none border-b border-gray-200 py-10">
                                    <td class="v-account-text py-2 font-bold text-white">Secret Key</td>
                                    <td class="v-table-title font-bold px-2 py-2 text-gray-800 uppercase"><input
                                            type="text" id="password" placeholder=""
                                            value="<?=$getUser['SecretKey_2fa'];?>"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                    </td>
                                </tr>
                                <tr class="v-border-hr-2 rounded-none border-b border-gray-200 py-10">
                                    <td class="v-account-text py-2 font-bold text-white">QR CODE</td>
                                    <td class="v-table-title font-bold px-2 py-2 text-white uppercase">
                                        <?php
                                    use PragmaRX\Google2FAQRCode\Google2FA;

                                    $google2fa = new Google2FA();
                                    $qrCodeUrl = $google2fa->getQRCodeInline($SIEUTHICODE->site('tenweb'), $getUser['email'], $getUser['SecretKey_2fa']);
                                   ?>
                                        <?=$qrCodeUrl;?>
                                        <i>Xác minh OTP: Thực hiện xác minh bằng Ứng dụng Google Authenticator</i>
                                    </td>
                                </tr>
                                <tr class="v-border-hr-2 rounded-none  py-10">
                                    <td class="v-account-text py-2 font-bold text-white">MÃ XÁC MINH</td>
                                    <td class="v-table-title font-bold px-2 py-2 text-gray-800 uppercase"><input
                                            type="text" id="secret" placeholder="Nhập mã xác minh"
                                            class="border border-gray-500 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                                    </td>
                                </tr>



                            </tbody>
                        </table>
                        <div class="flex">
                        <button id="save2fa"
                            class="uppercase flex mr-2 w-40 font-semibold rounded items-center justify-center h-10 text-white text-xl rounded-none focus:outline-none px-4 text-center bg-lime-600 hover:bg-red-600 mt-3">
                            LƯU NGAY </button>
                            <button onclick="openModal('modalDialog')"
                            class="uppercase flex w-40 font-semibold rounded items-center justify-center h-10 text-white text-xl rounded-none focus:outline-none px-4 text-center bg-red-500 hover:bg-red-600 mt-3">
                            ĐỔI SERECT </button>
                        </div>
                       
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
        class="animated fadeInDown fixed shadow-inner max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">
        <div class="modal-content">
            <div class="text-red-600 font-bold text-lg text-center mb-3 p-3 uppercase border-b border-gray-300">
                Bạn có muốn thay đổi Secret Key ?
            </div>

            <div class="overflow-auto p-2 md:px-4" style="max-height: 600px;">
                <div class="relative px-2 pb-4 text-gray-900">
                    <div class="md:px-4 overflow-auto p-2" style="max-height:400px">
                        <div class="pb-4 px-2 relative content-popup">
                            <p>Chọn "Thay đổi" bên dưới nếu bạn đã sẵn sàng thay đổi secret key của mình.</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="border-t border-gray-300 flex p-3 md:px-3 justify-end">
                <div class="flex items-center">
                    <button id="changeSecret"
                        class="transition duration-200 hover:bg-lime-700 hover:border-lime-700 bg-lime-600 focus:outline-none border-2 border-lime-600 py-1 px-3 rounded font-bold text-white">
                        Thay đổi
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
$("#save2fa").on("click", function() {
    $('#save2fa').html('<i class="fa fa-spinner fa-pulse"></i> ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/Auth.php");?>",
        method: "POST",
        dataType: "json",
        data: {
            type: 'ChangeGoogle2FA',
            status_2fa: $("#status_2fa").val(),
            secret: $("#secret").val()
        },
        success: function(response) {
            Toast(response.status, response.msg);
            $('#save2fa').html(
                    'LƯU NGAY')
                .prop('disabled', false);
        }
    });
});
$("#changeSecret").on("click", function() {
    $('#changeSecret').html('<i class="fa fa-spinner fa-pulse"></i> ĐANG XỬ LÝ').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/Auth.php");?>",
        method: "POST",
        dataType: "json",
        data: {
            type: 'ChangeSecret'
        },
        success: function(response) {
            Toast(response.status, response.msg);
            $('#changeSecret').html(
                    'Thay đổi')
                .prop('disabled', false);
        }
    });
});
</script>
<?php 
    require_once("../../public/client/Footer.php");
?>