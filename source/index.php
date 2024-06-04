<?php
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/config/function.php";
$title = $SIEUTHICODE->site('tenweb');
require_once __DIR__ . "/public/client/Header.php";
require_once __DIR__ . "/public/client/Nav.php";
?>
<style>
.text-yellow {
    color: yellow;
}

@media (max-width: 768px) {
    .customcard {
        padding-top: 0.5rem;
    }
}
</style>
<div class="v-theme">
    <div class="my-6">
        <div class="w-full max-w-6xl mx-auto relative border-4 border-trueGray-800 bg-trueGray-800">
            <div class="flex md:flex-row-reverse flex-wrap">
                <div class="w-full md:w-4/6 pb-0">
                    <div class="ml-0 border-trueGray">
                        <div class="carousel carousel--left carousel--slidable">
                            <ul class="carousel__list">
                                <li data-index="0" class="carousel__item carousel__item--active">
                                    <span>
                                        <div><img class="object-center object-fill h-full w-full lazyLoad"
                                                data-src="<?=BASE_URL($SIEUTHICODE->site('banner'))?>"
                                                src="<?=BASE_URL('');?>/assets/img/index.svg" /></div>
                                    </span>
                                </li>
                            </ul>
                            <ol class="carousel__indicators carousel__indicators--disc">
                                <li data-slide-to="0" class="carousel__indicator carousel__indicator--active"></li>
                            </ol>
                            <button type="button" data-slide="prev"
                                class="carousel__control carousel__control--prev"></button>
                            <button type="button" data-slide="next"
                                class="carousel__control carousel__control--next"></button>
                        </div>
                    </div>

                </div>
                <!-- <div class="w-full md:w-2/6">
                    <div class="bg-trueGray-800 w-full customcard" style="min-height: 338px;">
                        <div class="flex color-grant font-bold">
                            <div class="cursor-pointer w-full bg-trueGray-900 tablinks" onclick="Tab('top')">
                                <h2 class="py-1 px-5 title-grant font-extrabold text-xl md:text-xl">
                                    TOP NẠP TIỀN </h2>
                            </div>
                            <div class="cursor-pointer w-full bg-trueGray-800 tablinks" onclick="Tab('nap')">
                                <h2 class="py-1 px-2 w-32 text-center title-grant font-extrabold text-xl md:text-xl">
                                    NẠP THẺ
                                </h2>
                            </div>
                        </div>
                        <span class="tabcontent bg-trueGray-900" id="nap" style="display:none;">
                            <form class="w-full form-header">
                                <div class="py-3 px-5">
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <select id="loaithe"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600">
                                                <option value="">Chọn nhà mạng</option>
                                                <option value="VIETTEL">VIETTEL</option>
                                                <option value="VINAPHONE">VINAPHONE</option>
                                                <option value="MOBIFONE">MOBIFONE</option>
                                                <option value="VNMB">Vietnammobile</option>
                                                <option value="ZING">Zing</option>
                                                <option value="GARENA2">Garena</option>
                                                <option value="GATE">GATE</option>
                                                <option value="VCOIN">Vcoin</option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-trueGray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    class="fill-current h-4 w-4">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </span>
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <select id="menhgia"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600">
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
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-trueGray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    class="fill-current h-4 w-4">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </span>
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <input type="text" id="pin" placeholder="Mã số thẻ"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600" />
                                        </div>
                                    </span>
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <input type="text" id="seri" placeholder="Số serial"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600" />
                                        </div>
                                    </span>
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <input type="text" id="captcha" placeholder="Mã captcha"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600" />
                                            <img class="" src="<?=BASE_URL('/auth/gencaptchav2')?>" id="imgcaptcha"
                                                onclick="ReloadCaptcha()" data-toggle="tooltip" data-placement="top"
                                                title="">
                                        </div>
                                    </span>
                                    <div class="mt-3">
                                        <button type="button" id="NapThe"
                                            class="homepayin uppercase flex items-center justify-center h-10 w-full ff-lalezar pt-1 text-2xl rounded focus:outline-none px-4 text-center btn-inner"
                                            style="color: rgb(51, 51, 51);">
                                            Nạp Ngay
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </span>
                        <div class="tabcontent bg-trueGray-900" id="top" style="display:block;">
                            <div class="v-list-top-card md:py-2 px-1 md:px-3">
                                <?php $i = 1;foreach ($SIEUTHICODE->get_list("SELECT * FROM `users` ORDER BY `total_money` DESC LIMIT 5 ") as $top) {?>
                                <div class="flex items-center justify-between px-2 py-3">
                                    <div class="flex items-center">
                                        <div class="v-star relative">
                                            <i class="bx text-3xl text-red-500 bxs-<?=$i == 1 ? 'star':'circle'?>"
                                                style="<?=$i == 1 ? 'color: red;':'color: #0ce3ac;'?>"></i>
                                            <span class="absolute font-bold text-dark" style="top: 4px; left: 11px;">
                                                <?=$i++;?> </span>
                                        </div>
                                        <span class="ml-1 text-yellow w-full font-bold truncate"
                                            style="max-width: 8rem;">
                                            <?=$top['username'];?>
                                        </span>
                                    </div>
                                    <div class="font-bold text-lg">
                                        <span class="bg-red-600 w-32 text-white rounded-sm text-center inline-block">
                                            <?=format_cash($top['total_money']);?><span
                                                class="text-xs"><sup>VNĐ</sup></span>
                                        </span>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="w-full md:w-2/6">
                    <div class="bg-trueGray-800 w-full customcard" style="min-height: 338px;">
                        <div class="flex color-grant font-bold">

                            <div class="cursor-pointer w-full bg-trueGray-900 tablinks" onclick="Tab('nap')">
                                <h2 class="py-1 px-2 w-32 text-center title-grant font-extrabold text-xl md:text-xl">
                                    NẠP THẺ
                                </h2>
                            </div>
                            <div class="cursor-pointer w-full bg-trueGray-800 tablinks" onclick="Tab('top')">
                                <h2 class="py-1 px-5 title-grant font-extrabold text-xl md:text-xl">
                                    TOP T.<?=date('m')?> </h2>
                            </div>
                            <div style="display: none" class="cursor-pointer w-full bg-trueGray-800 tablinks" onclick="Tab('thuong')">
                                <h4 class="py-1 px-5 title-grant font-extrabold text-xl md:text-xl">
                                    THƯỞNG </h4>
                            </div>
                        </div>
                        <span class="tabcontent bg-trueGray-900" id="nap" style="display:block;">
                            <form class="w-full form-header">
                                <div class="py-3 px-5">
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <select id="loaithe"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600">
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
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-trueGray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    class="fill-current h-4 w-4">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </span>
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <select id="menhgia"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600">
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
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-trueGray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    class="fill-current h-4 w-4">
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </span>
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <input type="text" id="pin" placeholder="Mã số thẻ"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600" />
                                        </div>
                                    </span>
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <input type="text" id="seri" placeholder="Số serial"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600" />
                                        </div>
                                    </span>
                                    <span class="mb-2 block">
                                        <div class="flex items-center relative">
                                            <input type="text" id="captcha" placeholder="Mã captcha"
                                                class="border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600" />
                                            <img class="" src="<?=BASE_URL('/auth/gencaptchav2')?>" id="imgcaptcha"
                                                onclick="ReloadCaptcha()" data-toggle="tooltip" data-placement="top"
                                                title="">
                                        </div>
                                    </span>
                                    <div class="mt-3">
                                        <button type="button" id="NapThe"
                                            class="homepayin uppercase flex items-center justify-center h-10 w-full ff-lalezar pt-1 text-2xl rounded focus:outline-none px-4 text-center btn-inner"
                                            style="color: rgb(51, 51, 51);">
                                            Nạp THẺ NGAY
                                        </button>
                                    </div>
                                    
                                    <p class="mt-2 border-2 rounded block w-full bg-trueGray-900 focus:border-yellow-500 focus:bg-trueGray-900 text-white appearance-none w-full py-2 px-3 leading-tight focus:outline-none border-trueGray-600">Vui lòng chọn đúng mệnh giá. Đối với trường hợp nhập sai, chúng tôi sẽ không chịu bất cứ trách nhiệm nào</p>

                                    <!--UPDATE BUTTON NAPBANKING-->
                                     <div class="mt-3">
                                        <button type="button" id="NAPBANKING"
                                            class="homepayin uppercase flex items-center justify-center h-10 w-full ff-lalezar pt-1 text-2xl rounded focus:outline-none px-4 text-center btn-inner"
                                            style="color: rgb(51, 51, 51);">
                                            <a href="/nap-bank">Nạp MOMO VÀ ATM</a>
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </span>
                        <div class="tabcontent bg-trueGray-900" id="top" style="display:none;">
                            <div class="v-list-top-card md:py-2 px-1 md:px-3">
                                <?php $i = 1;
                                 $day = date('m-Y');
                                foreach ($SIEUTHICODE->get_list("SELECT SUM(amount) as total, username
                                    FROM `bank_auto`
                                    WHERE DATE_FORMAT(time, '%m-%Y') = '{$day}'
                                    GROUP BY `username`
                                    ORDER BY `total` DESC
                                    LIMIT 7;
                                    ") as $top) {?>
                                <div class="flex items-center justify-between px-2 py-3">
                                    <div class="flex items-center">
                                        <div class="v-star relative">
                                            <i class="bx text-3xl text-red-500 bxs-<?=$i == 1 ? 'star':'circle'?>"
                                                style="<?=$i == 1 ? 'color: red;':'color: #0ce3ac;'?>"></i>
                                            <span class="absolute font-bold text-dark" style="top: 4px; left: 11px;">
                                                <?=$i++;?> </span>
                                        </div>
                                        <span class="ml-1 text-yellow w-full font-bold truncate"
                                            style="max-width: 8rem;">
                                            <?=$top['username'];?>
                                        </span>
                                    </div>
                                    <div class="font-bold text-lg">
                                        <span class="bg-red-600 w-32 text-white rounded-sm text-center inline-block">
                                            <?=format_cash($top['total']);?><span
                                                class="text-xs"><sup>VNĐ</sup></span>
                                        </span>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        <div class="tabcontent bg-trueGray-900" id="thuong" style="display:none;">
                            <div class="v-list-top-card md:py-2 px-1 md:px-3">
                                <?=$SIEUTHICODE->site('thuong_top')?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($SIEUTHICODE->site('outstanding') == "1"): ?>

    <style>
    .slick-carousel {
        display: flex;
        flex-direction: row;
    }

    .slick-slide {
        flex: 0 0 auto;
        transform: scale(0.98);
        transition: transform 0.3s;

    }

    .slick-slide img {
        width: 100%;
        height: auto;
    }

    .slick-track {
        margin-bottom: 0;
    }
    
    </style>
    <link href="<?=BASE_URL('template/theme/');?>assets/frontend/css/slick.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?=BASE_URL('template/theme/');?>assets/frontend/js/slick.js">
    </script>
    <div class="pb-0">
        <div class="v-card w-full max-w-6xl mx-auto">
            <div class="md:mx-0">
                <div class="mb-4 py-4 md:p-4 bg-box-dark">
                    <div class="mb-6 block">
                        <div
                            class="fade-in py-2 block uppercase md:py-4 text-center md:text-3xl text-2xl font-extrabold text-yellow-400 text-fill">
                            DỊCH VỤ NỔI BẬT
                        </div>
                        <div class="mb-2"><span class="mx-auto block w-40 border-2 border-red-500"></span></div>
                    </div>
                    <div class="slick-carousel">
                        <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `blogs` WHERE `display` = '1' AND `type`='noibat' ORDER BY `stt` ASC") as $blog):?>
                        <div class="slick-slide ">
                            <div class="hover:shadow-lg relative rounded">
                                <a href="<?=$blog['link'];?>">
                                    <img data-src="<?=BASE_URL($blog['image']);?>"
                                        src="<?=BASE_URL('');?>/assets/img/index.svg"
                                        class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                </a>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <script>
                    $(document).ready(function() {
                        $('.slick-carousel').slick({
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            autoplay: true,
                            autoplaySpeed: 3000,
                            arrows: false,
                            dots: false,
                            responsive: [{
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 2,
                                }
                            }]
                        });
                    });
                    </script>
                </div>

            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if ($SIEUTHICODE->site('status_noti_sell') == "ON"): ?>
    <div class="pb-8">
        <div class="v-card w-full max-w-6xl mx-auto">
            <div class="md:mx-0">
                <div class="py-2">
                    <div class="">
                        <div class="py-4 bg-box-dark w-full">
                            <marquee>
                                <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `history_buy` ORDER BY `updated_at` DESC LIMIT 10") as $history) : ?>

                                <a style="text-align:center;"><span class="text-white"><strong
                                            style="color: rgb(247, 176, 60);"><?= hashName($history['username']) ?></strong>
                                        đã
                                        mua tài khoản #<?= $history['id_acc'] ?> giá
                                        <?= format_cash($history['cash']) ?>đ
                                        <sup class="text-muted">đ</sup> - <span class="text-muted"><i> cách đây
                                                <?= timeAgo($history['updated_at']) ?></span></a>
                                <?php endforeach; ?>
                            </marquee>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if ($SIEUTHICODE->site('status_minigame') == "1"): ?>
    <div class="pb-0">
        <div class="v-card w-full max-w-6xl mx-auto">
            <div class="md:mx-0">
                <div class="">
                    <div class="mb-16">
                        <div class="mb-4 py-4 md:p-4 bg-box-dark">
                            <div class="mb-6 block">
                                <div
                                    class="fade-in py-2 block uppercase md:py-4 text-center md:text-3xl text-2xl font-extrabold text-yellow-400 text-fill">
                                    MINIGAME QUÀ KHỦNG
                                </div>
                                <div class="mb-2"><span class="mx-auto block w-40 border-2 border-red-500"></span></div>
                            </div>
                            <div class="fade-in grid grid-cols-8 gap-2 px-2 md:px-0">
                                <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `minigame` WHERE `status` = '1' ") as $game) {
                                 $detail = json_decode($game['detail'], true);  
                                 $count_game_w = 0;
                                $result = $SIEUTHICODE->get_row("SELECT COUNT(*) AS total FROM `history_minigame` WHERE `type_category` = '{$game['type_category']}'");
                                if ($result !== null && isset($result['total'])) {
                                    $count_game_w = $result['total'];
                                }  
                                ?>
                                <div
                                    class="hover:shadow-lg card-stc col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2 xl:col-span-2 relative rounded border border-gray-300">
                                    <!---->
                                    <a href="/<?= to_slug($game['type']) ?>/<?= $game['type_category'] ?>">
                                        <?php if($detail['tag'] != ''):?>
                                        <div class="stc-Tag"> <img class="lazyLoad" src="<?=BASE_URL($detail['tag'])?>">
                                        </div>
                                        <?php endif;?>
                                        <img data-src="<?=BASE_URL($detail['thumb']);?>"
                                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                                            class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                        <div class="py-1">
                                            <div class="py-1 font-bold text-md px-1 truncate text-center uppercase"
                                                style="color: rgb(247, 176, 60);">
                                                <?= $detail['name_product'] ?>
                                            </div>
                                            <ul
                                                class="px-2 flex items-center justify-center font-medium rounded-sm w-full font-medium text-white">
                                                <span>
                                                    Số lượt chơi:
                                                    <b><?=format_cash((isset($detail['fake_spin']) ? $detail['fake_spin'] : 0) + $count_game_w)?></b>
                                                </span>
                                                <!---->
                                            </ul>
                                            <div class="flex px-2 mt-2 justify-center">
                                                <!---->
                                                <button type="button"
                                                    style="display:none"
                                                    class="border-2 btn-cash text-center px-1 w-20 h-8 py-1 rounded font-semibold text-sm ml-1 focus:outline-none cursor-default">
                                                    <b><?=format_cash($detail['cash'])?> đ </b>
                                                </button>
                                                <button type="button"
                                                    class="border-2 btn-sale text-center px-1 w-20 h-8 py-1 rounded font-semibold text-sm ml-1 focus:outline-none cursor-default">
                                                    <b><?=format_cash(calculateDiscount($detail['cash'],$detail['sale_cash']))?>
                                                        đ </b>
                                                </button>
                                            </div>

                                            <div class="mt-2 mb-2 px-2 py-1 flex items-center justify-center">
                                                <a class="focus:outline-none acc-lien-minh-tu-chon-bb2716012b"
                                                    href="/<?= to_slug($game['type']) ?>/<?= $game['type_category'] ?>">
                                                    <div>
                                                        <style scoped="">
                                                        .acc-lien-minh-tu-chon-bb2716012b:hover {
                                                            filter: brightness(130%);
                                                        }
                                                        </style>
                                                    </div> <img src="<?=BASE_URL($SIEUTHICODE->site('nut_choingay'))?>"
                                                        class="lazyLoad isLoaded">
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if ($SIEUTHICODE->site('status_banacc') == "ON"): ?>
    <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `category` WHERE `display` = '1' ORDER BY `stt` ASC") as $category):?>
    <div class="pb-0">
        <div class="v-card w-full max-w-6xl mx-auto">
            <div class="md:mx-0">
                <div class="">
                    <div class="mb-16">
                        <div class="mb-4 py-4 md:p-4 bg-box-dark">
                            <div class="mb-6 block">
                                <div
                                    class="fade-in py-2 block uppercase md:py-4 text-center md:text-3xl text-2xl font-extrabold text-yellow-400 text-fill">
                                    <?=$category['title']?>
                                </div>
                                <div class="mb-2"><span class="mx-auto block w-40 border-2 border-red-500"></span></div>
                            </div>
                            <div class="fade-in grid grid-cols-8 gap-2 px-2 md:px-0">
                                <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `groups` WHERE `display` = '1' AND `category` = '".Anti_xss($category['id'])."'  ") as $group) { 
                                $detail = json_decode($group['detail'],true);
                                   $count_account_groups = 0;
                                    $acc = $SIEUTHICODE->get_row("SELECT COUNT(*) AS total FROM `accounts` WHERE `groups` = '".$group['id']."' AND `status`='on'");
                                    if ($acc !== null && isset($acc['total'])) {
                                        $count_account_groups = $acc['total'];
                                    }  
                                ?>
                                <div
                                    class="hover:shadow-lg card-stc col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2 xl:col-span-2 relative rounded border border-gray-300">
                                    <!---->
                                    <a href="<?=BASE_URL('Accounts/'.$group['id']);?>">
                                        <?php if($detail['tag'] != ''):?>
                                        <div class="stc-Tag"> <img class="lazyLoad" src="<?=BASE_URL($detail['tag'])?>">
                                        </div>
                                        <?php endif;?>
                                        <img data-src="<?=BASE_URL($detail['thumb']);?>"
                                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                                            class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                        <div class="py-1">
                                            <div class="py-1 font-bold text-md px-1 truncate text-center uppercase"
                                                style="color: rgb(247, 176, 60);">
                                                <?=$detail['name_product'];?>
                                            </div>

                                            <div class="text-center px-2 justify-center text-white">
                                                <p>
                                                    Số tài khoản: <?=$count_account_groups?>
                                                </p>
                                                <p>Tài khoản đã bán:
                                                    <?=format_cash($group['fake'] + $SIEUTHICODE->num_rows("SELECT * FROM `accounts` WHERE `groups`='".$group['id']."' AND `status` = 'off'"))?>
                                                </p>
                                            </div>
                                            <div class="mt-2 mb-2 px-2 py-1 flex items-center justify-center">
                                                <a class="focus:outline-none acc-lien-minh-tu-chon-bb2716012b"
                                                    href="<?=BASE_URL('Accounts/'.$group['id']);?>">
                                                    <div>
                                                        <style scoped="">
                                                        .acc-lien-minh-tu-chon-bb2716012b:hover {
                                                            filter: brightness(130%);
                                                        }
                                                        </style>
                                                    </div> <img src="<?=BASE_URL($SIEUTHICODE->site('nut_muangay'))?>" class="lazyLoad isLoaded">
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php }?>
                                <!--LIÊN QUÂN-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach;?>
    <?php endif;?>
    <?php if ($SIEUTHICODE->site('status_dichvu') == "ON"): ?>
    <div class="pb-10">
        <div class="v-card w-full max-w-6xl mx-auto">
            <div class="md:mx-0">
                <div class="py-2">
                    <div class="mb-16">
                        <div class="mb-4 py-4 md:p-4 bg-box-dark">
                            <div class="mb-6 block">
                                <div
                                    class="fade-in py-2 block uppercase md:py-4 text-center md:text-3xl text-2xl font-extrabold text-yellow-400 text-fill">
                                    DANH SÁCH DỊCH VỤ
                                </div>
                                <div class="mb-2"><span class="mx-auto block w-40 border-2 border-red-500"></span></div>
                            </div>
                            <div class="fade-in grid grid-cols-8 gap-2 px-2 md:px-0">
                                <?php if($SIEUTHICODE->site('status_nro_coin_lau') == 1):?>
                                <div
                                    class="hover:shadow-lg card-stc col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2 xl:col-span-2 relative rounded border border-gray-300">
                                    <a href="/dich-vu-auto/ban-vang-nro-lau">
                                        <img data-src="<?=BASE_URL($SIEUTHICODE->site('logo_banvang_lau'))?>"
                                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                                            class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                        <div class="py-1">
                                            <div class="py-1 font-bold text-md px-1 truncate text-center uppercase"
                                                style="color: rgb(247, 176, 60);">
                                                <?=$SIEUTHICODE->site('title_banvang_lau')?>
                                            </div>
                                            <div class="flex px-2 justify-center text-white">
                                                <span>Tổng giao dịch:
                                                    <?=format_cash($SIEUTHICODE->site('fake_coin_lau') + $SIEUTHICODE->num_rows("SELECT * FROM `history_coin_nro_lau`"))?></span>
                                            </div>
                                            <div class="mt-2 mb-2 px-2 py-1 flex items-center justify-center">
                                                <a class="focus:outline-none acc-lien-minh-tu-chon-bb2716012b"
                                                    href="/dich-vu-auto/ban-vang-nro-lau">
                                                    <div>
                                                        <style scoped="">
                                                        .acc-lien-minh-tu-chon-bb2716012b:hover {
                                                            filter: brightness(130%);
                                                        }
                                                        </style>
                                                    </div> <img src="<?=BASE_URL($SIEUTHICODE->site('nut_muangay'))?>" class="lazyLoad isLoaded">
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php endif;?>
                                <?php if($SIEUTHICODE->site('status_coin_nro') == 1):?>
                                <div
                                    class="hover:shadow-lg card-stc col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2 xl:col-span-2 relative rounded border border-gray-300">
                                    <a href="/dich-vu-auto/ban-vang-nro">
                                        <img data-src="<?=BASE_URL($SIEUTHICODE->site('logo_banvang'))?>"
                                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                                            class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                        <div class="py-1">
                                            <div class="py-1 font-bold text-md px-1 truncate text-center uppercase"
                                                style="color: rgb(247, 176, 60);">
                                                <?=$SIEUTHICODE->site('title_banvang')?>
                                            </div>
                                            <div class="flex px-2 justify-center text-white">
                                                <span>Tổng giao dịch:
                                                    <?=format_cash($SIEUTHICODE->site('fake_coin') + $SIEUTHICODE->num_rows("SELECT * FROM `history_coin_nro`"))?></span>
                                            </div>
                                            <div class="mt-2 mb-2 px-2 py-1 flex items-center justify-center">
                                                <a class="focus:outline-none acc-lien-minh-tu-chon-bb2716012b"
                                                    href="/dich-vu-auto/ban-vang-nro">
                                                    <div>
                                                        <style scoped="">
                                                        .acc-lien-minh-tu-chon-bb2716012b:hover {
                                                            filter: brightness(130%);
                                                        }
                                                        </style>
                                                    </div> <img src="<?=BASE_URL($SIEUTHICODE->site('nut_muangay'))?>" class="lazyLoad isLoaded">
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php endif;?>
                                <?php if($SIEUTHICODE->site('status_gem_nro') == 1):?>
                                <div
                                    class="hover:shadow-lg card-stc col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2 xl:col-span-2 relative rounded border border-gray-300">
                                    <a href="/dich-vu-auto/ban-ngoc-nro">
                                        <img data-src="<?=BASE_URL($SIEUTHICODE->site('logo_banngoc'))?>"
                                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                                            class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                        <div class="py-1">
                                            <div class="py-1 font-bold text-md px-1 truncate text-center uppercase"
                                                style="color: rgb(247, 176, 60);">
                                                <?=$SIEUTHICODE->site('title_banngoc')?>
                                            </div>
                                            <div class="flex px-2 justify-center text-white">
                                                <span>Tổng giao dịch:
                                                    <?=format_cash($SIEUTHICODE->site('fake_gem') + $SIEUTHICODE->num_rows("SELECT * FROM `history_gem_nro`"))?></span>
                                            </div>
                                            <div class="mt-2 mb-2 px-2 py-1 flex items-center justify-center">
                                                <a class="focus:outline-none acc-lien-minh-tu-chon-bb2716012b"
                                                    href="/dich-vu-auto/ban-ngoc-nro">
                                                    <div>
                                                        <style scoped="">
                                                        .acc-lien-minh-tu-chon-bb2716012b:hover {
                                                            filter: brightness(130%);
                                                        }
                                                        </style>
                                                    </div> <img src="<?=BASE_URL($SIEUTHICODE->site('nut_muangay'))?>" class="lazyLoad isLoaded">
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php endif;?>
                                <?php if($SIEUTHICODE->site('status_gem_api_nro') == 1):?>
                                <div
                                    class="hover:shadow-lg card-stc col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2 xl:col-span-2 relative rounded border border-gray-300">
                                    <a href="/dich-vu-auto/ky-ngoc-nro">
                                        <img data-src="<?=BASE_URL($SIEUTHICODE->site('logo_banngoc_api'))?>"
                                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                                            class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                        <div class="py-1">
                                            <div class="py-1 font-bold text-md px-1 truncate text-center uppercase"
                                                style="color: rgb(247, 176, 60);">
                                                <?=$SIEUTHICODE->site('title_banngoc_api')?>
                                            </div>
                                            <div class="flex px-2 justify-center text-white">
                                                <span>Tổng giao dịch:
                                                    <?=format_cash($SIEUTHICODE->site('fake_gemapi') + $SIEUTHICODE->num_rows("SELECT * FROM `history_gem_api_nro`"))?></span>
                                            </div>
                                            <div class="mt-2 mb-2 px-2 py-1 flex items-center justify-center">
                                                <a class="focus:outline-none acc-lien-minh-tu-chon-bb2716012b"
                                                    href="/dich-vu-auto/ky-ngoc-nro">
                                                    <div>
                                                        <style scoped="">
                                                        .acc-lien-minh-tu-chon-bb2716012b:hover {
                                                            filter: brightness(130%);
                                                        }
                                                        </style>
                                                    </div> <img src="<?=BASE_URL($SIEUTHICODE->site('nut_muangay'))?>" class="lazyLoad isLoaded">
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php endif;?>
                                <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `category_caythue` WHERE `display` = '1' ") as $category) {?>
                                <div
                                    class="hover:shadow-lg card-stc col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2 xl:col-span-2 relative rounded border border-gray-300">

                                    <a href="<?=BASE_URL('dich-vu/' . $category['id']);?>">
                                        <img data-src="<?=BASE_URL($category['img']);?>"
                                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                                            class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                        <div class="py-1">
                                            <div class="py-1 font-bold text-md px-1 truncate text-center uppercase"
                                                style="color: rgb(247, 176, 60);">
                                                <?=$category['title'];?>
                                            </div>
                                            <div class="flex px-2 justify-center text-white">
                                                <span>Tổng giao dịch:
                                                    <?=format_cash($category['fake'] + $SIEUTHICODE->num_rows("SELECT * FROM `orders_caythue` WHERE `dichvu_id`='".$category['id']."'"))?></span>
                                            </div>
                                            <div class="mt-2 mb-2 px-2 py-1 flex items-center justify-center">
                                                <a class="focus:outline-none acc-lien-minh-tu-chon-bb2716012b"
                                                    href="<?=BASE_URL('dich-vu/' . $category['id']);?>">
                                                    <div>
                                                        <style scoped="">
                                                        .acc-lien-minh-tu-chon-bb2716012b:hover {
                                                            filter: brightness(130%);
                                                        }
                                                        </style>
                                                    </div> <img src="<?=BASE_URL($SIEUTHICODE->site('nut_muangay'))?>" class="lazyLoad isLoaded">
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php }?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>

    <div class="animated modal fadeIn is-visible fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"
        style="z-index: 999;" id="indexModal">
        <div
            class="modal-dialog fixed shadow-inner max-w-md md:max-w-lg relative pin-b pin-x align-top m-auto justify-center bg-white w-full h-auto md:shadow-lg flex flex-col">
            <div class="modal-content">
                <div class="text-red-600 font-bold text-lg text-center mb-3 p-3 uppercase border-b border-gray-300">
                    Thông báo
                </div>
                <div class="overflow-auto p-2 md:px-4" style="max-height: 600px;">
                    <div class="relative px-2 pb-4 text-gray-900">
                        <div class="md:px-4 overflow-auto p-2" style="max-height:400px">
                            <div class="pb-4 px-2 relative text-gray-900">
                                <?=$SIEUTHICODE->site('thongbao');?>
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
                        'NẠP NGAY')
                    .prop('disabled', false);
            }
        });
    });

    function ReloadCaptcha() {
        document.getElementById('imgcaptcha').src = '<?=BASE_URL('/auth/gencaptchav2')?>';
    }
    </script>

    <script type="text/javascript">
    function FuncHideModal() {
        var x = document.getElementById("indexModal");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function FuncHideModalEvent() {
        var x = document.getElementById("event");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    </script>
    <?php
require_once __DIR__ . "/public/client/Footer.php";
?>