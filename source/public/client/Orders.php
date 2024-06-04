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
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `accounts` WHERE `id` = '".Anti_xss($_GET['id'])."' AND `status`='on' ");
    if(!$row)
    {
        new Redirect('/');
    }
    $detail = json_decode($row['detail'], true);
    $check = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `type_category` = '{$row['type_category']}'"); // lấy dữ liệu từ product
    $detail_product = json_decode($check['detail'], true); // get detail product
}
else
{
    new Redirect('/');
}

?>
<link href="<?=BASE_URL('template/theme/');?>assets/frontend/css/slick.css" rel="stylesheet" type="text/css" />
<style>
.d-flex {
    display: flex;
}

.slick-current img {
    --border-opacity: 1;
    border-color: rgba(220, 38, 38, var(--border-opacity));
}

.slick-active {
    display: block;
}

.u-slick--transform-off.slick-transform-off .slick-track {
    -webkit-transform: none !important;
    transform: none !important;
}

@media (min-width: 768px) {
    .md\:h-72 {
        height: 18rem;
    }
}

.max-w-7xl {
    max-width: 40rem;
}

@media (min-width: 768px) {
    .md\:col-span-7 {
        grid-column: span 7/span 7;
    }
}

.arrow-right {
    right: 5px;
}

.arrow-left,
.arrow-right {
    top: 45%;
    z-index: 99;
    background: rgb(255 255 255/47%);
}
</style>

<div class="mt-12 mb-10 relative w-full max-w-6xl mx-auto text-white pb-8 px-2 md:px-2 bg-box-dark">
    <div class="md:bg-white grid grid-cols-12 gap-4 md:p-3 rounded">
        <!--<div class="col-span-12 md:col-span-7 mt-2">-->
            <!--<div>-->
            <!--    <div class="relative">-->
            <!--        <span-->
            <!--            class="absolute inline-block px-2 rounded text-sm cursor-pointer font-semibold text-white bg-gray-800"-->
            <!--            style="bottom: 5px; left: 5px;z-index:2;"> Click để phóng to</span>-->
            <!--        <div id="sliderSyncingNav" class="js-slick-carousel u-slick relative" data-infinite="true"-->
            <!--            data-arrows-classes="d-none d-lg-inline-block"-->
            <!--            data-arrow-left-classes="bx bx-chevron-left d-flex arrow-left absolute h-8 w-8 rounded inline-flex text-lg text-gray-800 items-center justify-center cursor-pointer"-->
            <!--            data-arrow-right-classes="bx bx-chevron-right d-flex arrow-right absolute h-8 w-8 rounded inline-flex text-lg text-gray-800 items-center justify-center cursor-pointer"-->
            <!--            data-nav-for="#sliderSyncingThumb">-->
            <!--            <?php if($row['type'] == 'ACCOUNT'):?>-->
            <!--            <?php foreach(json_decode($row['image'],true) as $img):?>-->
            <!--            <div class="js-slide">-->
            <!--                <img class="h-70 md:h-72 w-full object-fill object-center rounded cursor-pointer"-->
            <!--                    src="<?=BASE_URL($img)?>">-->
            <!--            </div>-->
            <!--            <?php endforeach;?>-->

            <!--            <?php else:?>-->
            <!--            <div class="js-slide">-->
            <!--                <img class="h-56 md:h-72 w-full object-fill object-center rounded cursor-pointer"-->
            <!--                    src="<?=BASE_URL($detail_product['thumb'])?>">-->
            <!--            </div>-->
            <!--            <?php endif ?>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="relative px-10 mt-4">-->
            <!--        <div id="sliderSyncingThumb"-->
            <!--            class="js-slick-carousel u-slick u-slick--slider-syncing u-slick--slider-syncing-size u-slick--gutters-1 u-slick--transform-off"-->
            <!--            data-infinite="true" data-slides-show="5" data-is-thumbs="true"-->
            <!--            data-nav-for="#sliderSyncingNav">-->
            <!--            <?php if($row['type'] == 'ACCOUNT'):?>-->
            <!--            <?php foreach(json_decode($row['image'],true) as $img):?>-->
            <!--            <div-->
            <!--                class="js-slide rounded h-12 text-white flex flex-col slick-current items-center justify-center cursor-pointer select-none">-->
            <!--                <img class="w-full h-12 object-fill object-center rounded border-2"-->
            <!--                    src="<?=BASE_URL($img)?>">-->
            <!--            </div>-->
            <!--            <?php endforeach;?>-->

            <!--            <?php else:?>-->
            <!--            <div-->
            <!--                class="js-slide rounded h-12 text-white flex flex-col slick-current items-center justify-center cursor-pointer select-none">-->
            <!--                <img class="w-full h-12 object-fill object-center rounded border-2"-->
            <!--                    src="<?=BASE_URL($detail_product['thumb'])?>">-->
            <!--            </div>-->
            <!--            <?php endif ?>-->


            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            
            
            
          
        <!--</div>-->
        <!-- Modal view -->
        <!--<div class="animated modal fadeIn out fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"-->
        <!--    style="z-index: 999;" id="viewModal">-->
        <!--    <div-->
        <!--        class="modal-dialog fixed shadow-inner max-w-7xl max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">-->
        <!--        <span-->
        <!--            class="absolute cursor-pointer text-gray-800 px-3 rounded-full border-4 border-white w-8 h-8 flex justify-center text-white text-sm items-center bg-gray-800"-->
        <!--            onclick="closeModal('viewModal')" style="top: -15px;right: -5px;z-index: 100;"><i-->
        <!--                class="bx bx-x"></i></span>-->
        <!--        <div class="modal-content">-->
        <!--            <div class="mx-auto grid grid-cols-12 gap-2 bg-white p-2">-->
        <!--                <div class="relative col-span-8">-->
        <!--                    <div id="sliderLarge" class="js-slick-carousel2 u-slick relative" data-infinite="true"-->
        <!--                        data-arrows-classes="d-none d-lg-inline-block"-->
        <!--                        data-arrow-left-classes="bx bx-chevron-left d-flex arrow-left absolute h-8 w-8 rounded inline-flex text-lg text-gray-800 items-center justify-center cursor-pointer"-->
        <!--                        data-arrow-right-classes="bx bx-chevron-right d-flex arrow-right absolute h-8 w-8 rounded inline-flex text-lg text-gray-800 items-center justify-center cursor-pointer"-->
        <!--                        data-nav-for="#sliderSmall">-->

        <!--                        <?php if($row['type'] == 'ACCOUNT'):?>-->
        <!--                        <?php foreach(json_decode($row['image'],true) as $img):?>-->
        <!--                        <div class="js-slide">-->
        <!--                            <img class="h-full w-full object-fill object-center rounded"-->
        <!--                                src="<?=BASE_URL($img)?>">-->
        <!--                        </div>-->
        <!--                        <?php endforeach;?>-->

        <!--                        <?php else:?>-->
        <!--                        <div class="js-slide">-->
        <!--                            <img class="h-full w-full object-fill object-center rounded"-->
        <!--                                src="<?=BASE_URL($detail_product['thumb'])?>">-->
        <!--                        </div>-->
        <!--                        <?php endif; ?>-->

        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="relative col-span-4">-->
        <!--                    <div class="mb-1 md:mb-3 md:mt-0 bg-red-700 text-white py-1 px-2 rounded">-->
        <!--                        <div class="uppercase font-bold text-xl">-->
        <!--                            Mã Số: <?=$row['id']?> </div>-->
        <!--                        <div class="text-xs text-red-100 relative font-medium uppercase">-->
        <!--                            <?=$detail_product['name_product']?>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <style>-->
        <!--                    #sliderSmall .slick-track {-->
        <!--                        width: auto !important;-->
        <!--                    }-->

        <!--                    #sliderSmall.u-slick--slider-syncing-size .slick-slide {-->
        <!--                        width: 5rem !important;-->
        <!--                    }-->
        <!--                    </style>-->
        <!--                    <div id="sliderSmall"-->
        <!--                        class="js-slick-carousel2 u-slick u-slick--slider-syncing u-slick--slider-syncing-size u-slick--gutters-1 u-slick--transform-off"-->
        <!--                        data-infinite="true" data-slides-show="<?=$i?>" data-is-thumbs="true"-->
        <!--                        data-nav-for="#sliderLarge" style="max-height: 46vh; overflow-y: auto;">-->

        <!--                        <?php if($row['type'] == 'ACCOUNT'):?>-->
        <!--                        <?php foreach(json_decode($row['image'],true) as $img):?>-->
        <!--                        <div class="js-slide col-span-3 cursor-pointer">-->
        <!--                            <img class="w-full h-16 border-2 object-fill object-center rounded hover:border-red-500 border-transparent"-->
        <!--                                src="<?=BASE_URL($img)?>">-->
        <!--                        </div>-->
        <!--                        <?php endforeach;?>-->

        <!--                        <?php else:?>-->
        <!--                        <div class="js-slide col-span-3 cursor-pointer">-->
        <!--                            <img class="w-full h-16 border-2 object-fill object-center rounded hover:border-red-500 border-transparent"-->
        <!--                                src="<?=BASE_URL($detail_product['thumb'])?>">-->
        <!--                        </div>-->
        <!--                        <?php endif; ?>-->

        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <div class="col-span-12 md:col-span-12 mt-2">
            <div class="my-3 md:mb-3 md:mt-0 bg-red-700 text-white py-1 px-2 rounded">
                <div class="uppercase font-bold text-xl">
                    Mã Số: <?=$row['id']?> </div>
                <div class="text-2xl text-red-100 relative font-semibold uppercase">
                    <?=$detail_product['name_product']?>
                </div>
            </div>

            <div class="rounded-t bg-red-100 py-2 px-2 flex items-center relative justify-between">  <!--justify-between-->
                
                
                <div class="text-red-600" style="margin-right:3rem" >
                    <div class="relative text-2xl font-semibold" style="top: 2px;">
                        <small><b class="font-bold">GIÁ GỐC</b></small>
                    </div>
                    <b class="text-2xl"><?=format_cash($row['money'])?><small>đ</small></b>
                </div>

                <div class="text-red-600">
                    <!--<div class="relative text-sm font-semibold" style="top: 2px"><small><b class="font-bold">GIẢM-->
                    <!--            <?=$row['sale']?>%</b></small>-->
                    <div class="relative text-2xl font-semibold" style="top: 2px"><small><b class="font-bold">GIẢM
                                <?=$row['sale']?>%</b></small>
                    </div> <b
                        class="text-2xl"><?=format_cash($row['money'] -($row['money']*$row['sale']/100))?><small>đ</small></b>
                </div>
            </div>
            <div>
                <div class="mb-3">
                    <?php
                        for ($i=0; $i < count($detail['data']); $i++) {
                            if($detail['data'][$i]['show'] == 'on'){
                    ?>
                    <div class="grid grid-cols-12 gap-2 p-2">
                        <div class="col-span-12">
                            <p>
                                <i class="relative bx bx-caret-right" style="top: 1px;"></i>
                                <?=$detail['data'][$i]['label']?>:
                                <b class="text-white"> <?=decodecryptData($detail['data'][$i]['value'])?> </b>
                            </p>
                        </div>
                    </div>

                    <?php } } ?>

                    
                </div>
                
                
            </div>
            <div class="grid grid-cols-12 gap-2 mb-2">
                <div class="col-span-6">
                    <button onclick="location.href='/nap-the-cao'" type="button"
                        class="bg-gray-500 text-center border border-gray-500 px-2 py-2 rounded text-white font-bold w-full focus:outline-none">
                        NẠP THẺ
                    </button>
                </div>
                <div class="col-span-6">
                    <button
                        class="px-2 rounded py-2 text-white font-bold bg-red-600 focus:outline-none hover:bg-red-500 rounded w-full"
                        data-open="modalAccept">
                        <span class="relative pl-8">
                            <i class="absolute text-3xl bx bxs-cart-add mr-1" style="top: -4px; left: -8px"></i> MUA
                            NGAY
                        </span>
                    </button>
                </div>
            </div>

        </div>
        
          <!--QUGNART-->
          <div class="col-span-12 md:col-span-12 p-2">
                
                <div class="text-white text-center md:text-xl">
				    </p><p style="margin-bottom:2rem">Sau khi thanh toán, quý khách vui lòng nhắn tin cho <a class="focus:outline-none cursor-pointer text-red-600 font-bold" href="https://www.facebook.com/profile.php?id=61557187034125" target="_blank">FANPAGE</a> hoặc liên hệ <a class="focus:outline-none cursor-pointer text-blue-600 font-bold" href="https://zalo.me/0337654363" target="_blank">ZALO</a> để nhận đầy đủ thông tin</p>
				    
                     <br>
                </div>
              
              
        <?php if($row['type'] == 'ACCOUNT'):?>
                        <?php foreach(json_decode($row['image'],true) as $img):?>
                            <img style="height:auto; margin-bottom:.5rem; border: 1px solid white"class="h-70 md:h-72 w-full object-fill object-center rounded cursor-pointer"
                                src="<?=BASE_URL($img)?>">
                        <?php endforeach;?>

                        <?php else:?>
                            <img class="h-56 md:h-72 w-full object-fill object-center rounded cursor-pointer"
                                src="<?=BASE_URL($detail_product['thumb'])?>">
                        <?php endif ?>
                        
                      <div class="text-white text-center md:text-xl mt-10">
                           <p>Cảm ơn quý khách đã ghé qua, chúng tôi làm việc với tiêu chí: <span class="text-red-600 font-bold">UY TÍN - TẬN TÂM - NHANH GỌN</span>. Một lần nữa xin cảm ơn quý khách!!! </p>
                      </div>  
       
        </div>
    </div>


    <div class="animated modal fadeIn out fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"
        style="z-index: 999;" id="modalAccept">
        <div
            class="modal-dialog fixed shadow-inner max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">
            <div class="modal-content">
                <div class="text-red-600 font-bold text-lg text-center mb-3 p-3 uppercase border-b border-gray-300">
                    XÁC NHẬN THANH TOÁN
                </div>

                <div class="modal-content">

                    <span class="absolute cursor-pointer text-3xl text-gray-800 pt-3 px-3"
                        style="right: -1px; top: -2px;" onclick="closeModal('modalAccept')"><i
                            class="bx bxs-x-square"></i></span>
                    <div class="py-4 px-2">
                        <div class="mb-2 font-extrabold">
                            <div class="border border-rounded-b">
                                <?php
                    for ($i = 0; $i < count($detail['data']); $i++) {
                    if ($detail['data'][$i]['show'] == 'on') {
                        ?>

                                <div class="grid grid-cols-12 gap-2 border-b p-2">
                                    <div class="col-span-12 text-base font-semibold">
                                        <p class="text-gray-700">
                                            <i class="relative bx bx-caret-right"
                                                style="top: 1px;"></i><?=$detail['data'][$i]['label']?>:
                                            <b class="text-red-600"> <?=decodecryptData($detail['data'][$i]['value'])?>
                                            </b>
                                        </p>
                                    </div>
                                </div>
                                <?php }
                }?>

                            </div>
                        </div>
                    </div>

                    <?php if(!isset($getUser)):?>
                    <div class="mb-4 px-2">
                        <div class="gap-2 mb-2 text-gray-700">
                            <span>VUI LÒNG ĐĂNG NHẬP ĐỂ MUA TÀI KHOẢN</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-2 px-2 mb-2">
                        <div class="col-span-8">
                            <button type="button" onclick="location.href='/Auth/Login'"
                                class="bg-red-500 border border-red-500 px-2 py-2 rounded text-white font-bold w-full focus:outline-none">
                                ĐĂNG NHẬP
                            </button>
                        </div>
                        <div class="col-span-4">
                            <button class="py-2 px-3 text-center text-gray-700 border rounded w-full focus:outline-none"
                                onclick="closeModal('modalAccept')">
                                ĐÓNG
                            </button>
                        </div>
                    </div>
                    <?php else:?>
                    <div class="mb-4 px-2">
                        <div class="grid grid-cols-12 gap-3 p-2 text-gray-800 font-bold">

                            <div class="col-span-6">
                                <span>Số dư của bạn</span>
                            </div>

                            <div class="col-span-6 text-right">
                                <?=format_cash($getUser['money'])?>đ
                                <a href="/nap-the-cao"><button class="px-1"><i
                                            class="text-red-500 relative text-xl bx bxs-plus-square"
                                            style="top: 3px;"></i></button></a>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-3 text-gray-700 font-bold text-sm p-2">

                            <div class="col-span-6 text-red-600">
                                <span>GIÁ TÀI KHOẢN</span>
                            </div>

                            <div class="col-span-6 text-right text-red-600 text-xl">
                                <?=format_cash($row['money'] -($row['money']*$row['sale']/100))?>đ
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-2 px-2 mb-2">
                        <div class="col-span-8">
                            <button type="button" id="btnThanhToan"
                                class="bg-red-500 border border-red-500 px-2 py-2 rounded text-white font-bold w-full focus:outline-none">
                                XÁC NHẬN MUA
                            </button>
                        </div>
                        <div class="col-span-4">
                            <button class="py-2 px-3 text-center text-gray-700 border rounded w-full focus:outline-none"
                                onclick="closeModal('modalAccept')">
                                ĐÓNG
                            </button>
                        </div>
                    </div>
                    <?php endif;?>
                </div>

            </div>
        </div>
    </div>

    <div class="animated modal fadeIn out fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"
        style="z-index: 999;" id="modalAccept1">
        <div
            class="modal-dialog fixed shadow-inner max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">
            <div class="modal-content">
                <h2 class="relative py-2 px-4 bg-gray-300 text-xl font-bold">
                    <p>XÁC NHẬN MUA TÀI KHOẢN #<?=$row['id']?></p>
                </h2>
                <span
                    class="absolute cursor-pointer text-gray-800 px-3 rounded-full border-4 border-white w-8 h-8 flex justify-center text-white text-sm items-center bg-gray-800"
                    onclick="closeModal('modalAccept')" style="top: -15px;right: -5px;z-index: 100;"><i
                        class="bx bx-x"></i></span>
                <div class="py-4 px-2">
                    <div class="mb-2 font-extrabold">
                        <div class="border border-rounded-b">
                            <?php
                    for ($i = 0; $i < count($detail['data']); $i++) {
                    if ($detail['data'][$i]['show'] == 'on') {
                        ?>

                            <div class="grid grid-cols-12 gap-2 border-b p-2">
                                <div class="col-span-12 text-base font-semibold">
                                    <p>
                                        <i class="relative bx bx-caret-right"
                                            style="top: 1px;"></i><?=$detail['data'][$i]['label']?>:
                                        <b class="text-red-600"> <?=decodecryptData($detail['data'][$i]['value'])?> </b>
                                    </p>
                                </div>
                            </div>
                            <?php }
                }?>

                        </div>
                    </div>
                </div>

                <?php if(!isset($getUser)):?>
                <div class="mb-4 px-2">
                    <div class="gap-2 mb-2 text-gray-700">
                        <span>VUI LÒNG ĐĂNG NHẬP ĐỂ MUA TÀI KHOẢN</span>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-2 px-2 mb-2">
                    <div class="col-span-8">
                        <button type="button" onclick="location.href='/Auth/Login'"
                            class="bg-red-500 border border-red-500 px-2 py-2 rounded text-white font-bold w-full focus:outline-none">
                            ĐĂNG NHẬP
                        </button>
                    </div>
                    <div class="col-span-4">
                        <button class="py-2 px-3 text-center border rounded w-full focus:outline-none" data-close>
                            ĐÓNG
                        </button>
                    </div>
                </div>
                <?php else:?>
                <div class="mb-4 px-2">
                    <div class="grid grid-cols-12 gap-3 p-2 text-gray-800 font-bold">

                        <div class="col-span-6">
                            <span>Số dư của bạn</span>
                        </div>

                        <div class="col-span-6 text-right">
                            <?=format_cash($getUser['money'])?>đ
                            <a href="/nap-the-cao"><button class="px-1"><i
                                        class="text-red-500 relative text-xl bx bxs-plus-square"
                                        style="top: 3px;"></i></button></a>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-3 text-gray-700 font-bold text-sm p-2">

                        <div class="col-span-6 text-red-600">
                            <span>GIÁ TÀI KHOẢN</span>
                        </div>

                        <div class="col-span-6 text-right text-red-600 text-xl">
                            <?=format_cash($row['money'] -($row['money']*$row['sale']/100))?>đ
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-2 px-2 mb-2">
                    <div class="col-span-8">
                        <button type="button" id="btnThanhToan"
                            class="bg-red-500 border border-red-500 px-2 py-2 rounded text-white font-bold w-full focus:outline-none">
                            XÁC NHẬN MUA
                        </button>
                    </div>
                    <div class="col-span-4">
                        <button class="py-2 px-3 text-center border rounded w-full focus:outline-none" data-close>
                            ĐÓNG
                        </button>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="mt-10 text-xl font-bold">TÀI KHOẢN ĐỒNG GIÁ</div>
    <div class="grid grid-cols-12 gap-3 py-2">
        <?php $sql_show_1 = "SELECT * FROM `accounts` WHERE `type_category` = '{$row['type_category']}' AND `status` = 'on' AND `money` = '{$row['money']}' ORDER BY RAND() LIMIT 12";
    foreach ($SIEUTHICODE->get_list($sql_show_1) as $info_1) {
        $check_1 = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `type_category` = '{$info_1['type_category']}' "); // lấy dữ liệu từ product
        $detail_product_1 = json_decode($check_1['detail'], true); // get detail product
        $arr_img_1 = json_decode($info_1['image'], true); // ảnh ở list_account
        $detail_1 = json_decode($info_1['detail'], true); // detail list_account
?>
        <div
            class="col-span-12 md:col-span-3 relative card-stc border border-transparent hover:border-red-500 transition duration-200 rounded">
            <a href="/views/account/<?=$info_1['id']?>" class="">
                <div class="relative mb-20">
                    <span
                        class="new-id absolute inline-flex items-center px-2 h-6 bg-red-600 text-white font-semibold rounded text-sm"
                        style="top: 8px; left: 8px;">
                        MS <?=$info_1['id']?>
                    </span>
                    <?php if ($check_1['type'] == 'ACCOUNT') {?>
                    <img class="h-56 md:h-40 w-full object-fill object-center rounded-t-sm lazyLoad isLoaded"
                        src="<?=BASE_URL($arr_img_1[0]);?>">
                    <?php } else {?>
                    <img class="h-56 md:h-40 w-full object-fill object-center rounded-t-sm lazyLoad isLoaded"
                        src="<?=BASE_URL($detail_product_1['thumb'])?>">
                    <?php }?>
                    <div class="my-2 py-1 px-2 relative">
                        <div class="grid grid-cols-12 gap-y-1 leading-6 text-gray-700 text-xs"
                            style="font-size: 15px; font-weight: 500;">
                            <?php
                    for ($i = 0; $i < count($detail_1['data']); $i++) {
                        if ($detail_1['data'][$i]['show'] == 'on') { ?>
                            <div class="col-span-12 text-base md:text-sm  text-white">
                                <p>
                                    <i class="relative bx bx-caret-right" style="top: 1px;"></i>
                                    <?=$detail_1['data'][$i]['label']?>:
                                    <b class="text-white"> <?=decodecryptData($detail_1['data'][$i]['value'])?> </b>
                                </p>
                            </div>
                            <?php }}?>

                        </div>
                    </div>
                </div>
                <div class="right-0 bottom-0 left-0 p-2">
                    <div class="rounded-b-sm px-2 py-1">
                        <ul class="rounded-sm w-full font-medium">
                            <span class="w-full text-center inline-block px-2">
                                <?php if ($check_1['type'] == 'ACCOUNT'): ?>
                                <?php if($info_1['sale'] != 0):?>
                                <span class="text-white inline-block text-xs line-through">
                                    <?=format_cash($info_1['money'])?><small>đ</small></span>
                                <?php endif;?>
                                <span class="text-red-500 text-lg font-extrabold">
                                    <?=format_cash($info_1['money'] -($info_1['money']*$info_1['sale']/100))?><small>đ</small></span></span>
                            <?php else: ?>
                            <span class="text-red-500 text-lg font-extrabold">
                                <?=format_cash($info_1['money'])?><small>đ</small></span></span>
                            <?php endif;?>
                        </ul>
                    </div>

                    <?php if ($check_1['type'] == 'ACCOUNT'): ?>

                    <div
                        class="w-full text-center cursor-pointer border rounded-b-sm border-red-500 hover:border-red-600 bg-red-500 transition duration-200 hover:bg-red-600 text-white uppercase font-semibold py-1 px-3">
                        Xem chi tiết
                    </div>

                    <?php else: ?>

                    <div
                        class="w-full text-center cursor-pointer border rounded-b-sm border-red-500 hover:border-red-600 bg-red-500 transition duration-200 hover:bg-red-600 text-white uppercase font-semibold py-1 px-3">
                        <i class="text-2xl bx bxs-cart-add"></i>
                    </div>

                    <?php endif;?>

                </div>

            </a>
        </div>
        <?php } ?>

    </div>
</div>
<script type="text/javascript">
$("#btnThanhToan").on("click", function() {
    $('#btnThanhToan').html('<i class="fa fa-spinner"></i> ĐANG XỬ LÝ').prop('disabled',
        true);

    $.ajax({
        url: "<?=BASE_URL("ajaxs/Orders.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            id: <?=$row['id'];?>
        },
        success: function(response) {
            if (response.status == 'success') {
                Toast(response.status, response.msg);
                setTimeout(function() {
                    window.location = '/History';
                }, 1000);
            } else {
                Toast(response.status, response.msg)
            }
            $('#btnThanhToan').html(
                    'XÁC NHẬN MUA')
                .prop('disabled', false);
        }
    });
});
</script>
<?php 
    require_once("../../public/client/Footer.php");
?>