<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
$title = 'TẠO TÀI KHOẢN | ' . $SIEUTHICODE->site('tenweb');
require_once "../../public/client/Header.php";
require_once "../../public/client/Nav.php";
?>

<div class="flex justify-center items-center px-4 py-8 md:px-0 md:py-0" style="height: calc(100vh - 80px)">
    <div class="w-full max-w-sm">
        <form class="w-full border border-gray-400 shadow rounded bg-white py-4 px-6">
            <div class="text-gray-800 text-center text-2xl font-extrabold">
                TẠO TÀI KHOẢN
            </div>
            <div class="border-t border-gray-600 w-32 mx-auto mt-1"></div>
            <div id="thongbao"></div>
            <span>
                <div class="mt-4">
                    <label class="block text-gray-800 text-sm font-semibold mb-1">Email</label>
                    <input type="email" placeholder="Nhập địa chỉ Email" id="email"
                        class="border border-gray-400 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                    <span class="mt-1 flex items-center font-semibold tracking-wide text-red-500 text-xs"></span>
                </div>
            </span>
            <span>
                <div class="mt-4">
                    <label class="block text-gray-800 text-sm font-semibold mb-1">Tên tài khoản</label>
                    <input type="text" placeholder="Nhập tài khoản" id="username"
                        class="border border-gray-400 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                    <span class="mt-1 flex items-center font-semibold tracking-wide text-red-500 text-xs"></span>
                </div>
            </span>

            <span>
                <div class="my-2">
                    <label class="block text-gray-800 text-sm font-semibold mb-1">Mật khẩu</label>
                    <input autocomplete="" type="password" id="password" placeholder="Nhập mật khẩu"
                        class="border border-gray-400 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                    <span class="mt-1 flex items-center font-semibold tracking-wide text-red-500 text-xs"></span>
                </div>
            </span>

            <span>
                <div class="my-2">
                    <label class="block text-gray-800 text-sm font-semibold mb-1">Nhập lại mật khẩu</label>
                    <input autocomplete="" type="password" id="repassword" placeholder="Nhập lại mật khẩu"
                        class="border border-gray-400 rounded bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                    <span class="mt-1 flex items-center font-semibold tracking-wide text-red-500 text-xs"></span>
                </div>
            </span>
            <span>
                <div class="my-2">
                    <label class="block text-gray-800 text-sm font-semibold mb-1">Captcha</label>
                    <div class="flex">
                        <input autocomplete="" type="text" id="captcha" placeholder="Nhập mã captcha đi nào" class="border border-gray-400 rounded w-full bg-white text-gray-800 appearance-none py-2 px-3 leading-tight focus:outline-none">
                        <img class="" src="<?=BASE_URL('/auth/gencaptcha')?>" id="imgcaptcha" onclick="ReloadCaptcha()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Click để đổi captcha khác!">
                    </div>
                    <span class="mt-1 flex items-center font-semibold tracking-wide text-red-500 text-xs"></span>
                </div>
            </span>
            <div class="mt-4 mb-2 flex justify-center flex-col">
                <button type="button" id="Register"
                    class="focus:outline-none h-10 bg-red-600 text-white flex items-center justify-center rounded w-full p-1 px-8 text-xl">
                    Đăng Ký
                </button>
                <a href="<?=BASE_URL('Auth/Login');?>"
                    class="mt-2 py-1 rounded border border-gray-400 bg-white text-gray-800 text-xl flex items-center justify-center relative"><i
                        class="absolute bx bxs-user-plus" style="left: 10px; top: 9px;"></i> Đăng Nhập</a>
            </div>
        </form>
    </div>
</div>
</div>


<script type="text/javascript">
$("#Register").on("click", function() {

    $('#Register').html('<i class="fa fa-spinner fa-pulse"></i> Đang xử lý...').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/Auth.php");?>",
        method: "POST",
        dataType:"JSON",
        data: {
            type: 'Register',
            username: $("#username").val(),
            password: $("#password").val(),
            email: $("#email").val(),
            repassword: $("#repassword").val(),
            captcha: $("#captcha").val()
        },
        success: function(response) {
            if (response.status == 'success') {
                Toast(response.status,response.msg);
                setTimeout(function () {
                            window.location ='/';
                        }, 1000);
            } else {
                Toast(response.status,response.msg)
            }
            $('#Register').html(
                    'Đăng Ký')
                .prop('disabled', false);
        }
    });
});
function ReloadCaptcha() {
        document.getElementById('imgcaptcha').src = '<?=BASE_URL('/auth/gencaptcha')?>';
    }
</script>


<?php
require_once "../../public/client/Footer.php";
?>