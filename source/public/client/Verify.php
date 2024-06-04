<?php
        require_once("../../config/config.php");
        require_once("../../config/function.php");
        $title = 'ĐĂNG NHẬP | '.$SIEUTHICODE->site('tenweb');
        require_once("../../public/client/Header.php");
        require_once("../../public/client/Nav.php");
        if (isset($_GET['token'])) {
            if (!$row = $SIEUTHICODE->get_row("SELECT * FROM `users` WHERE `token` = '".Anti_xss(base64_decode($_GET['token']))."' ")) {
                new Redirect('/');
            }
        } else {
            new Redirect('/');
        }
?>

<div class="flex justify-center items-center px-4 py-8 md:px-0 md:py-0" style="height: calc(100vh - 80px)">
    <div class="w-full max-w-sm">
        <form class="w-full border border-gray-400 shadow rounded bg-white py-4 px-6">
            <div class="text-gray-800 text-center text-2xl font-extrabold">
            Google Authenticator
            </div>
            <p class="text-center">Vui lòng xác minh 2FA để hoàn tất quá trình đăng nhập</p>
            <div class="border-t border-gray-600 w-32 mx-auto mt-1"></div>
            <div id="thongbao"></div>
            <span>
                <div class="mt-4">
                    <label class="block text-gray-800 text-sm font-semibold mb-1">Mã Xác Minh</label>
                    <input class="form-control" id="token" type="hidden" value="<?=$row['token'];?>">
                    <input type="number" min="1" max="6" placeholder="Nhập mã xác minh" id="code"
                        class="border border-gray-400 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                    <span class="mt-1 flex items-center font-semibold tracking-wide text-red-500 text-xs"></span>
                </div>
            </span>

           
            <div class="mt-4 mb-2 flex justify-center flex-col">
                <button type="button" id="Login"
                    class="focus:outline-none h-10 bg-red-600 text-white flex items-center justify-center rounded w-full p-1 px-8 text-xl">
                    Xác Nhận
                </button>
                <a href="<?=BASE_URL('Auth/Register');?>"
                    class="mt-2 py-1 rounded border border-gray-400 bg-white text-gray-800 text-xl flex items-center justify-center relative"><i
                        class="absolute bx bxs-user-plus" style="left: 10px; top: 9px;"></i> Tạo Tài Khoản</a>
            </div>
        </form>
    </div>
</div>
</div>


<script type="text/javascript">
$("#Login").on("click", function() {
    $('#Login').html('Đang xử lý...').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/Auth.php");?>",
        method: "POST",
        dataType:"JSON",
        data: {
            type: 'VerifyGoogle2FA',
            code: $("#code").val(),
            token: $("#token").val()
        },
        success: function(response) {
            if (response.status == 'success') {
                Toast(response.status,response.msg);
                setTimeout(function () {
                            window.location = '/';
                        }, 1000);
            } else {
                Toast(response.status,response.msg)
            }
            $('#Login').html(
                    'Xác Nhận ')
                .prop('disabled', false);
        }
    });
});
</script>


<?php 
    require_once("../../public/client/Footer.php");
?>