<script>
$(document).ready(function() {
    $('.select2').select2();
});
$(function() {
    $("img.lazyLoad").lazyload({
        effect: "fadeIn"
    });
});
$(document).ready(function() {
    $(".dropdown-profile").on("click", (event) => {
        console.log("click");
        $(".dropdown-content").toggleClass("open");
    });

    $(document).click(function(e) {
        $('.dropdown-profile')
            .not($('.dropdown-profile').has($(e.target)))
            .children('.dropdown-content')
            .removeClass('open');
    })
})

function openEvent() {
    $.ajax({
        url: '/ajaxs/Event.php',
        dataType: 'json',
        type: 'POST',
        success: function(data) {
            $('.modal-body').html(data.msg);
            openModal('event');
        }
    });
}
</script>
<div class="animated modal fadeIn out fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"
    style="z-index: 999;" id="modalLogout">
    <div
        class="modal-dialog fixed shadow-inner max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">
        <div class="modal-content">
            <div class="text-red-600 font-bold text-lg text-center mb-3 p-3 uppercase border-b border-gray-300">
                Bạn có muốn đăng xuất?
            </div>

            <div class="overflow-auto p-2 md:px-4" style="max-height: 600px;">
                <div class="relative px-2 pb-4 text-gray-900">
                    <div class="md:px-4 overflow-auto p-2" style="max-height:400px">
                        <div class="pb-4 px-2 relative content-popup">
                            <p>Chọn "Đăng xuất" bên dưới nếu bạn đã sẵn sàng kết thúc phiên hiện tại của mình.</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="border-t border-gray-300 flex p-3 md:px-3 justify-end">
                <div class="flex items-center">
                    <a href="<?=BASE_URL('Auth/Logout')?>"
                        class="transition duration-200 hover:bg-lime-700 hover:border-lime-700 bg-lime-600 focus:outline-none border-2 border-lime-600 py-1 px-3 rounded font-bold text-white">
                        Đăng xuất
                    </a>
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
<div class="animated modal fadeIn out fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"
    style="z-index: 999;" id="modalMinigame">
    <div
        class="modal-dialog fixed shadow-inner max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">
        <div class="modal-content">
            <div class="text-red-600 font-bold text-lg text-center mb-3 p-3 uppercase border-b border-gray-300">
                Thông báo
            </div>

            <div class="overflow-auto p-2 md:px-4" style="max-height: 600px;">
                <div class="relative px-2 pb-4 text-gray-900">
                    <div class="md:px-4 overflow-auto p-2" style="max-height:400px">
                        <div class="pb-4 px-2 relative content-popup">

                        </div>

                    </div>
                </div>
            </div>
            <div class="border-t border-gray-300 flex p-3 md:px-3 justify-end">
                <div class="flex items-center">
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
<div class="animated modal fadeIn out fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"
    style="z-index: 999;" id="event">
    <div
        class="modal-dialog fixed shadow-inner max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">
        <div class="modal-content">
            <div class="text-red-600 font-bold text-lg text-center mb-3 p-3 uppercase border-b border-gray-300">
                Thông báo
            </div>
            <div class="overflow-auto p-2 md:px-4" style="max-height: 600px;">
                <div class="relative px-2 pb-4 text-gray-900">
                    <div class="md:px-4 overflow-auto p-2" style="max-height:400px">
                        <div class="pb-4 px-2 relative text-gray-900 modal-body">

                        </div>

                    </div>
                </div>
            </div>
            <div class="border-t border-gray-300 flex p-3 md:px-3 justify-end">
                <div class="flex items-center">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="<?=BASE_URL('template/theme/');?>assets/frontend/js/slick.js"></script>
<script src="<?=BASE_URL('template/theme/');?>assets/frontend/js/hs.core.js"></script>
<script src="<?=BASE_URL('template/theme/');?>assets/frontend/js/hs.slick-carousel.js"></script>
<script src="<?=BASE_URL('template/theme/');?>assets/frontend/js/footer.js?v=<?=time()?>"></script>
<script src="<?=BASE_URL('template/theme/');?>assets/frontend/js/kun.js?v=<?=time()?>"></script>
<script src="<?=BASE_URL('template/theme/');?>assets/frontend/js/backtotop.js"></script>
<script src="<?=BASE_URL('template/');?>toastify/toastify.js"></script>
<?=$SIEUTHICODE->site('javascript_footer');?>
<script>
var hscheck = false;
$(document).ready(() => {
    $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');
    $("#sliderSyncingNav .js-slide img").on("click", function() {
        openModal('viewModal');
        if (hscheck != 1) {
            $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel2');
            hscheck = true;
        }

    })
})
</script>
<script type="text/javascript">
function copyText(elementId) {
    const textToCopy = document.getElementById(elementId).textContent;
    const textarea = document.createElement("textarea");
    textarea.value = textToCopy;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    document.body.removeChild(textarea);
    copy("Đã sao chép: " + textToCopy)
}

function copy(text) {
    Toast('success', text)
}
</script>
<script>
function closeModal(id) {
    var modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('isVisible');
        modal.classList.add('out');
    };
}

function openModal(id) {
    var modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('out');
        modal.classList.add('isVisible');
    };
}

function Toast(status, msg) {
    if (status == 'error') {
        var color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    } else {
        var color = "linear-gradient(to right, #00b09b, #96c93d)";
    }
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: color,
    }).showToast();
}
</script>
<!-- <svg viewBox="0 0 120 28">
    <defs>
        <filter id="goo">
            <feGaussianBlur in="SourceGraphic" stdDeviation="1" result="blur" />
            <feColorMatrix in="blur" mode="matrix" values="
           1 0 0 0 0
           0 1 0 0 0
           0 0 1 0 0
           0 0 0 13 -9" result="goo" />
        </filter>
        <path id="wave"
            d="M 0,10 C 30,10 30,15 60,15 90,15 90,10 120,10 150,10 150,15 180,15 210,15 210,10 240,10 v 28 h -240 z" />
    </defs>
    <use id="wave3" class="wave" xlink:href="#wave" x="0" y="-2"></use>
    <use id="wave2" class="wave" xlink:href="#wave" x="0" y="0"></use>
    <g class="gooeff" filter="url(#goo)">
        <circle class="drop drop1" cx="20" cy="2" r="8.8" />
        <circle class="drop drop2" cx="25" cy="2.5" r="7.5" />
        <circle class="drop drop3" cx="16" cy="2.8" r="9.2" />
        <circle class="drop drop4" cx="18" cy="2" r="8.8" />
        <circle class="drop drop5" cx="22" cy="2.5" r="7.5" />
        <circle class="drop drop6" cx="26" cy="2.8" r="9.2" />
        <circle class="drop drop1" cx="5" cy="4.4" r="8.8" />
        <circle class="drop drop2" cx="5" cy="4.1" r="7.5" />
        <circle class="drop drop3" cx="8" cy="3.8" r="9.2" />
        <circle class="drop drop4" cx="3" cy="4.4" r="8.8" />
        <circle class="drop drop5" cx="7" cy="4.1" r="7.5" />
        <circle class="drop drop6" cx="10" cy="4.3" r="9.2" />
        <circle class="drop drop1" cx="1.2" cy="5.4" r="8.8" />
        <circle class="drop drop2" cx="5.2" cy="5.1" r="7.5" />
        <circle class="drop drop3" cx="10.2" cy="5.3" r="9.2" />
        <circle class="drop drop4" cx="3.2" cy="5.4" r="8.8" />
        <circle class="drop drop5" cx="14.2" cy="5.1" r="7.5" />
        <circle class="drop drop6" cx="17.2" cy="4.8" r="9.2" />
        <use id="wave1" class="wave" xlink:href="#wave" x="0" y="1" />
    </g>
</svg> -->
<div class="py-5" style="background: #1b1a1a;">
    <div
        class="mt-2 mb-12 md:mb-0 px-4 md:px-0 relative max-w-6xl w-full mx-auto text-white grid grid-cols-12 gap-4 font-semibold text-gray-300">
        <div class="col-span-12 md:col-span-4 font-bold uppercase mb-2">

            <?=$SIEUTHICODE->site('custom_footer');?>
        </div>
        <div class="col-span-12 md:col-span-5 py-2">
            <h2 class="text-2xl mb-2">VỀ CHÚNG TÔI</h2>
            <p class="text-base font-medium mb-2">
                Chúng tôi luôn lấy uy tín đặt trên hàng đầu đối với khách hàng, hy vọng chúng tôi sẽ được phục vụ các
                bạn. Cảm ơn!
            </p>
            <p>
                Thời gian hỗ trợ: <br>
                <span class="font-medium">
                    Sáng: <?=$SIEUTHICODE->site('from_time');?> | Chiều: <?=$SIEUTHICODE->site('to_time');?>
                </span>
            </p>
        </div>
        <div class="col-span-12 md:col-span-3 py-2">
            <h3 class="text-2xl uppercase mb-2">
                <?=$SIEUTHICODE->site('tenweb');?>
            </h3>
            HỆ THỐNG BÁN ACC TỰ ĐỘNG<br>
            ĐẢM BẢO UY TÍN VÀ CHẤT LƯỢNG.<br>
            <a href="<?=$SIEUTHICODE->site('facebook');?>" target="_blank"><img
                    src="https://cdns.diongame.com/static/messenger-01.svg" style="max-width: 220px;"></a>
        </div>
    </div>
</div>
<!-- <div class="py-2 text-white font-medium" style="background: #151212;">
    <div class="max-w-6xl mx-auto text-center">
        Powered By <a href="https://sieuthicode.net" style="color:#ee4d2d"><b>SIEUTHICODE.NET</b></a>,
        All
        Rights Reserved</b>
    </div>
</div> -->
<!-- <div class="flex justify-center py-8 footer-bg" style="border-top: 2px solid rgba(51, 51, 51, 0.25);">
    <div class="container-x w-full text-white flex flex-wrap font-semibold text-gray-300">
        <div class="md:w-1/2 w-full mb-2 px-4 font-bold">
            HỆ THỐNG BÁN ACC TỰ ĐỘNG
            <br>
            ĐẢM BẢO UY TÍN VÀ CHẤT LƯỢNG.
        </div>
        <div class="md:w-1/2 w-full mb-2 px-4">
            CHÚNG TÔI LUÔN LẤY UY TÍN LÀM HÀNG ĐẦU ĐỐI VỚI KHÁCH HÀNG. HI VỌNG SẼ
            ĐƯỢC PHỤC VỤ CÁC BẠN. CẢM ƠN!
        </div>
    </div>
</div>
<div class="py-2 text-white font-medium" style="background: #151212" bis_skin_checked="1">
    <div class="max-w-6xl mx-auto text-center" bis_skin_checked="1"> Copyright 2021 - 2023. SieuThiCode.Net - Thực hiện bởi
        <a href="https://www.facebook.com/nguyennhatloc">Nguyễn Nhật Lộc</a>
    </div>
</div> -->
<!-- <div class="hotline-phone-ring-wrap">
    <div class="hotline-phone-ring">
        <div class="hotline-phone-ring-circle"></div>
        <div class="hotline-phone-ring-circle-fill"></div>
        <div class="hotline-phone-ring-img-circle">
            <a href="tel:<?=$SIEUTHICODE->site('hotline')?>" class="pps-btn-img">
                <img src="/assets/img/icon-call.png" alt="Gọi điện thoại" width="50">
            </a>
        </div>
    </div>
</div> -->
<style>
@media only screen and (max-width: 640px) {
    #bonus {
        width: 35% !important;
    }
}

#bonus {
    position: fixed;
    bottom: 15px;
    left: 15px;
    width: 13%;
    z-index: 1000;
    cursor: pointer;
}
</style>
<?php if ($SIEUTHICODE->site('status_event') == 1): ?>
<?php if (!isset($getUser) || $SIEUTHICODE->num_rows("SELECT * FROM `log_lixi` WHERE `username` = '{$getUser['username']}'") < 1): ?>
<div id="bonus" title="Click để nhận thưởng!">
    <img onclick="openEvent();" class="lazyLoad" src="<?=BASE_URL($SIEUTHICODE->site('img_event'))?>">
</div>
<?php endif;?>



<?php endif;?>
<button type="button"
    class="cd-top h-10 w-10 border-2 border-blue-600 fixed opacity-90 rounded text-2xl text-white bg-blue-500 rounded-full font-bold flex items-center justify-center focus:outline-none"
    style="right:2%;bottom:14%;"><i class="bx bx-up-arrow-alt"></i></button>

</html>