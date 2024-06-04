<?php
$title ="LẬT HÌNH MAY MẮN";
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/public/client/Header.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/public/client/Nav.php');
    $type = Anti_xss($_GET['type']);
    $query = $SIEUTHICODE->get_row("SELECT detail FROM `minigame` WHERE `type_category` = '{$type}'");
    if(!$query){
        admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 500);
    }
    $detail = json_decode($query['detail'], true);
    $data_detail = $detail['data'];
?>

<div class="py-6">
    <div class="w-full max-w-6xl mx-auto v-layout-item px-4 md:px-2 bg-box-dark">
        <div class="grid grid-cols-12 gap-4 w-full mb-8 rounded p-0 md:p-2">
            <div class="col-span-12 sm:col-span-8 md:col-span-8 lg:col-span-8 xl:col-span-8">
                <div class="py-6 bg-white rounded"
                    style="background: url('/assets/images/image-80b4d779-df50-4cd3-ae4d-e1bef2222efc.jpeg') center bottom / cover no-repeat;">
                    <h2
                        class="game__title uppercase text-fill font-bold text-2xl md:text-3xl px-2 md:px-5 text-center md:text-left mb-2">
                        <?=$detail['name_product']?>
                    </h2>
                    <div class="grid grid-cols-12 w-full gap-2">
                        <div
                            class="col-span-4 sm:col-span-8 md:col-span-8 lg:col-span-8 xl:col-span-8 py-2 md:py-0 pl-3 md:pl-5 roboto text-sm font-semibold">
                            <span
                                class="game__user-online relative inline-block border-2 border-green-400 bg-green-100 rounded text-green-600 px-2 shadow">
                                Đang chơi: <?=rand(000,999)?>
                                <i class="relative bx bxs-user" style="top: 1px;"></i>
                            </span>
                        </div>
                        <div
                            class="col-span-8 sm:col-span-4 md:col-span-4 lg:col-span-4 xl:col-span-4 pr-3 md:px-5 roboto text-sm font-semibold flex items-center justify-end">
                            <div>
                                <button onclick="openModal('modalThele')"
                                    class="thele game__rule relative inline-block border-2 border-red-400 bg-red-100 rounded text-red-600 px-3 mr-1 uppercase font-semibold shadow">
                                    Thể lệ
                                </button>
                                <button type="button" onclick="location.href='/History/Minigame';"
                                    class="game__history relative inline-block border-2 border-red-400 bg-red-100 rounded text-red-600 px-3 uppercase font-semibold shadow">
                                    Lịch sử
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-8">
                        <div class="receiver px-3 md:px-5">
                            <marquee class="game__winner relative top-0 md:top-2 flex items-center">
                                <span class="game__list-winner-1 mr-2 text-sm font-bold text-white">
                                    Danh sách trúng thưởng:
                                </span>
                                <?php
                                $sql_show = "SELECT * FROM `log_wheel` WHERE `type` = '{$type}' ORDER BY `id` DESC LIMIT 14";
                                foreach($SIEUTHICODE->get_list($sql_show) as $info){
                                    $arr_history = json_decode($info['detail'], true);
                                    $name = mb_substr($arr_history['name'], 5);
                            ?>
                                <span class="inline-block text-sm font-medium text-white">
                                    <b class="game__list-winner-2 text-red-600"><i class="relative bx bxs-user"
                                            style="top: 1px;"></i>
                                        <?='*****'.$name?></b>
                                    - <?=$arr_history['msg']?>
                                    (<?=timeAgo($info['create_date'])?>)
                                    <span class="mx-3">
                                        -
                                    </span>
                                </span>
                                <?php } ?>
                            </marquee>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-2">
                        <div class="col-span-12 md:col-span-6">
                            <!---->
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <!---->
                        </div>
                    </div>
                    <div class="mt-8 flex justify-center">
                        <div class="relative max-w-md item item-left">
                            <section class="rotation mb-8">
                                <div class="grid grid-cols-12 gap-4">

                                    <?php
                            for($i=0;$i<count($data_detail);$i++){
                        ?>
                                    <div data-v-00440bb7="<?=$i?>"
                                        class="cursor-pointer flip-container relative col-span-4 flipped v-flip-<?=$i?>">
                                        <img data-v-00440bb7="<?=$i?>"
                                            class="front shake-text cursor-pointer lazyLoad isLoaded"
                                            src="<?=BASE_URL($detail['vongquay'])?>" />
                                        <img data-v-00440bb7="<?=$i?>" class="back shake-text lazyLoad isLoaded"
                                            style="display: block;" data-src="<?=BASE_URL($data_detail[$i]['item'])?>" src="<?=BASE_URL('');?>/assets/img/index.svg" />
                                    </div>

                                    <?php } ?>

                                </div>
                            </section>
                            <div class="w-full mb-4">
                                <div class="flex justify-center">
                                    <select id="numrolllop"
                                        class="w-56 block border-2 bg-white border-yellow-500 h-10 px-3 rounded focus:outline-none">
                                        <option value="1">Úp thẻ - Giá <?=number_format(calculateDiscount($detail['cash'],$detail['sale_cash']))?>đ</option>
                                       

                                    </select>
                                </div>
                            </div>
                            <div class="my-4 flex justify-center">
                                <img class="play lazyLoad" data-src="<?=BASE_URL($SIEUTHICODE->site('nut_lathinh'))?>" src="<?=BASE_URL('');?>/assets/img/index.svg" style="height: auto; width: 60%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-4 md:col-span-4 lg:col-span-4 xl:col-span-4">
                <!---->
                <div class="mb-5">
                    <div
                        class="bg-red-500 text-white font-semibold py-2 h-12 rounded uppercase w-full relative text-center flex px-3 justify-between items-center">
                        <span class="ml-1"> Nạp tiền </span>
                        <div>
                            <button onclick="location.href='/nap-the-cao'"
                                class="font-semibold px-2 py-1 rounded bg-white text-gray-600 text-sm inline-flex items-center">
                                <i class="relative text-base bx bxs-dollar-circle mr-1"
                                    style="top: 0px; left: -1px;"></i>
                                Thẻ cào
                            </button>
                            <button onclick="location.href='/nap-bank'"
                                class="font-semibold px-2 py-1 rounded bg-white text-gray-600 text-sm inline-flex items-center"
                                data-toggle="modal" data-target="#chargeModal">
                                <i class="relative text-base bx bxs-bank mr-1" style="top: 0px; left: -1px;"></i>
                                Bank/Momo
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <h2 class="text-xl font-bold text-white">CÓ THỂ BẠN QUAN TÂM</h2>
                    <div class="rounded">
                        <div class="py-2 md:pb-4">
                            <div class="grid grid-cols-12 gap-y-4">

                                <?php 
                      
                            foreach($SIEUTHICODE->get_list("SELECT DISTINCT `type_category`,`id`,`detail`,`type`,`type_category`,`stt` FROM `minigame` ORDER BY RAND() LIMIT 2", 0) as $query_w){
                                $detail_w = json_decode($query_w['detail'], true);
                                $count_game_w = 0;
                                $result = $SIEUTHICODE->get_row("SELECT COUNT(*) AS total FROM `history_minigame` WHERE `type_category` = '{$query_w['type_category']}'");
                                if ($result !== null && isset($result['total'])) {
                                    $count_game_w = $result['total'];
                                }
                        ?>

                                <div class="col-span-12 shadow-sm rounded-b-sm mb-2"
                                    style="padding: 1px; padding: 1px;border: 3px solid white;">
                                    <a href="/<?=to_slug($query_w['type'])?>/<?=$query_w['type_category']?>" class="">
                                        <div class="col-span-5"><img
                                                class="w-full rounded-t-sm md:rounded-t lazyLoad isLoaded"
                                                data-src="<?=BASE_URL($detail_w['thumb'])?>" src="<?=BASE_URL('');?>/assets/img/index.svg" /></div>
                                        <div class="col-span-12 px-2 py-3 h-28 relative">
                                            <h4 class="sub-interface-title uppercase text-sm font-semibold text-gray-800 mb-0"
                                                style="color: rgb(247, 176, 60);">
                                                <?=$detail_w['name_product']?>
                                            </h4>
                                            <div class="my-1 text-xs text-gray-600 sub-interface-info">
                                                <!---->
                                                <p>
                                                    <span class="text-white">
                                                        Đã chơi:
                                                        <b
                                                            class="text-red-500"><?=number_format($count_game_w+20000)?></b>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="absolute bottom-2 right-2 left-2 mt-2">
                                                <button class="eKJDZl new text-xs border px-1.5"><span> Dùng
                                                        xu khóa để thử vận may nào ! </span></button>
                                                <!---->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<div class="animated modal fadeIn out fixed z-50 pin bg-smoke-dark flex p-2 md:p-0 top-0 left-0 bottom-0 right-0"
    style="z-index: 999;" id="modalThele">
    <div
        class="animated fadeInDown fixed shadow-inner max-w-md relative pin-b pin-x align-top m-auto justify-center bg-white rounded w-full h-auto md:shadow-lg flex flex-col">
        <div class="modal-content">
            <div
                class="text-red-600 font-bold text-lg text-center mb-3 p-3 uppercase border-b bg-gray-300 border-gray-300">
                Thông báo
            </div>
            <span
                class="absolute cursor-pointer text-gray-800 px-3 rounded-full border-4 border-white w-8 h-8 flex justify-center text-white text-sm items-center bg-gray-800"
                onclick="closeModal('modalThele')" style="top: -15px;right: -5px;z-index: 100;"><i
                    class="bx bx-x"></i></span>
            <div class="overflow-auto p-2 md:px-4" style="max-height: 600px;">
                <div class="relative px-2 pb-4 text-gray-900">
                    <div class="md:px-4 overflow-auto p-2" style="max-height:400px">
                        <div class="pb-4 px-2 relative">
                            <?=$detail['thele']?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(() => {
    var typeRoll = "play";
    var type = '<?=$type?>';
    //var roll_check = false;
    $('body').delegate('.play', 'click', (e) => {
        e.preventDefault();
        $("img.back").each(function() {
            roll_check = true;
            $(this).hide();
            $("img.front").attr("src", '<?=BASE_URL($detail['vongquay'])?>');
            $('img.front').removeClass("active");
            $('img.front').removeClass("noactive");
            $("img.front").addClass("item-play");
            $(this).parent().removeClass('flipped');
        });
    })

    var roll_check = true;
    var numrollbyorder = 1;
    var num_loop = 4;
    var angle_gift = "";
    //var num_gift = $("#numgift").val();
    var gift_detail = "";
    var gift_list = "";
    var numrolllop = $("#numrolllop").val();
    var num_roll_remain = 0;
    var angles = 0;
    $("body").delegate(".item-play", "click", function() {
        $("img.front").removeClass("item-play");
        $("img.front").removeClass("active");
        $("img.front").addClass("noactive");
        $(this).removeClass("noactive");
        $(this).addClass("active");
        if (roll_check) {
            roll_check = false;
            $.ajax({
                url: "/Minigame/Wheel",
                dataType: "json",
                data: {
                    numrolllop: numrolllop,
                    typeRoll: typeRoll,
                    type: type,
                },
                type: "post",
                success: function(data) {
                    if (data.status == "error") {
                        $(".content-popup").text(data.msg);
                        openModal('modalMinigame');
                        $(".continue").parent().show();
                        return;
                    }
                    if (data.status == "login") {
                        $(".content-popup").text("Vui lòng đăng nhập");
                        openModal('modalMinigame');
                        return;
                    }
                    numrollbyorder = parseInt(data.numrollbyorder) + 1;
                    gift_detail = data.msg;
                    totalVP = data.msg.totalVP;
                    gift_list = data.listgift;
                    gift_list = shuffle(gift_list);
                    $("img.front.active").attr("src", gift_detail.image);
                    $("img.front.active").css({
                        transform: "rotateY(180deg)"
                    });
                    $("img.front.active").prev().addClass("transparent");
                    $("img.front.active").parent().css({
                        transform: "rotateY(180deg)"
                    });

                    setTimeout(function() {
                        var i = 0;

                        $(".img.front.noactive").each(function() {
                            $(this).attr("src", gift_list[i].image);
                            //$(this).css({ transform: "rotateY(180deg)" });
                            $(this).prev().addClass("transparent");
                            //$(this).parent().css({ transform: "rotateY(180deg)" });
                            i++;
                        });
                    }, 1600);

                    num_roll_remain = gift_detail.num_roll_remain;
                    $(".content-popup").html("Kết quả: " + gift_detail.name);
                    setTimeout(function() {
                        openModal('modalMinigame');
                    }, 1600);
                },
                error: function() {
                    $(".content-popup").text("Có lỗi xảy ra. Vui lòng thử lại!");
                    openModal('modalMinigame');
                    roll_check = true;
                },
            });
        }
    });

    function shuffle(array) {
        var currentIndex = array.length,
            temporaryValue,
            randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {
            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    }
})
</script>
<?php require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/public/client/Footer.php');?>