<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
if (isset($_GET['id'])) {
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `groups` WHERE `id` = '" . Anti_xss($_GET['id']) . "'  ");
    if (!$row) {
        new Redirect('/');
    }
    $detail_query = json_decode($row['detail'], true);
    $data_detail = $detail_query['data'];
} else {
    new Redirect('/');
}
$title = $detail_query['name_product'].' | ' . $SIEUTHICODE->site('tenweb');
require_once "../../public/client/Header.php";
require_once "../../public/client/Nav.php";
?>
<div class="py-6">
    <div class="w-full max-w-6xl mx-auto v-layout-item text-gray-800 px-4 md:px-2 bg-box-dark">
        <div
            class="fade-in mb-2 md:mb-4 block uppercase md:py-4 text-center md:text-3xl text-2xl font-extrabold text-yellow-400 text-fill">
            <?=$detail_query['name_product'];?>
        </div>
        <div class="tw-mb-2 mb-2">
            <div class="text-xl bg-blue-100 text-gray-900 p-2 px-3 rounded mb-4 panel-body hidetext">
                <?=$detail_query['thele']?>
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
        <div class="mb-4">
            <form class="grid grid-cols-8 gap-2 md:gap-6">
                <div class="col-span-8 sm:col-span-2 flex">

                    <div class="flex items-center relative w-full">
                        <input type="number" id="id" placeholder="Ví dụ: 123421"
                            class="border-2 border-gray-300 rounded-none bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none" />
                    </div>
                </div>
                <div class="col-span-8 sm:col-span-2 flex">
                    <div class="flex items-center relative w-full">
                        <select id="price"
                            class="border-2 border-gray-300 rounded-none bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none select2">
                            <option value="">Tìm theo giá</option>
                            <option value="duoi-50k">Dưới 50K</option>
                            <option value="tu-50k-200k">Từ 50K - 200K</option>
                            <option value="tu-200k-500k">Từ 200K - 500K</option>
                            <option value="tu-500k-1-trieu">Từ 500K - 1 Triệu
                            </option>
                            <option value="tren-1-trieu">Trên 1 Triệu</option>
                            <option value="tren-5-trieu">Trên 5 Triệu</option>
                            <option value="tren-10-trieu">Trên 10 Triệu</option>
                        </select>
                        <!-- <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-4 w-4">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                </path>
                            </svg>
                        </div> -->
                    </div>
                </div>

                <?php
for ($i = 0; $i < count($data_detail); $i++) {
    if ($data_detail[$i]['show'] == 'on') {
        ?>

                <div class="col-span-8 sm:col-span-2 flex">
                    <div class="w-full relative">
                        <?php if ($data_detail[$i]['type'] == 'input') {?>
                        <div class="el-input">
                            <input type="text" id="<?=$data_detail[$i]['name']?>" autocomplete="off"
                                placeholder="<?=$data_detail[$i]['label']?>"
                                class="border-2 border-gray-300 rounded-none bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                        </div>
                        <?php } elseif ($data_detail[$i]['type'] == 'number') {?>
                        <div class="el-input">
                            <input type="text" id="<?=$data_detail[$i]['name']?>" autocomplete="off"
                                placeholder="<?=$data_detail[$i]['label']?>"
                                class="border-2 border-gray-300 rounded-none bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none">
                        </div>
                        <?php } elseif ($data_detail[$i]['type'] == 'select') {?>
                        <div class="flex -mr-px"> </div>
                        <div class="flex items-center relative w-full">
                            <select id="<?=$data_detail[$i]['name']?>"
                                class="border-2 border-gray-300 rounded-none bg-white text-gray-800 appearance-none w-full py-2 px-3 leading-tight focus:outline-none select2">
                                <option value=""><?=$data_detail[$i]['label']?></option>
                                <?php
                            $explode = explode('|', $data_detail[$i]['value']);
                                        for ($a = 0; $a < count($explode); $a++) {
                                            ?>
                                <option value="<?=$explode[$a]?>"><?=$explode[$a]?></option>
                                <?php }?>
                            </select>
                            <!-- <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    class="fill-current h-4 w-4">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                    </path>
                                </svg>
                            </div> -->
                        </div>

                        <?php }?>
                    </div>
                </div>
                <?php }}?>
                <div class="col-span-8 sm:col-span-2 flex items-center">
                    <button type="button" onclick="fitler()"
                        class="mr-1 bg-red-600 text-white w-full rounded-none font-bold py-2 px-4 rounded focus:outline-none">
                        <i class="relative bx bxs-filter-alt mr-1" style="top: 2px;"></i> Tìm kiếm
                    </button>

                    <button onclick="load_account()" type="button"
                        class="bg-gray-700 w-full text-white rounded-none py-2 px-4 font-bold rounded focus:outline-none">
                        Tất cả
                    </button>

                </div>
            </form>
        </div>
        <div class="my-2"></div>
        <div class="my-6 v-item-account">
            <div class="grid grid-cols-12 gap-2 md:gap-4" id="list_account">

            </div>

        </div>
    </div>
</div>

</div>
<script>
page = 1;
id = "";
price = "";
<?php
for ($i = 0; $i < count($data_detail); $i++) {
    if ($data_detail[$i]['show'] == 'on') {
        ?>
<?=$data_detail[$i]['name']?> = "";
<?php }}?>
type = "<?=$row['type_category']?>";

function load_account() {
    $("#list_account").hide();
    $.ajax({
        type: 'POST',
        url: '/List/Account',
        data: {
            page: page,
            id: id,
            price: price,
            <?php
for ($i = 0; $i < count($data_detail); $i++) {
    if ($data_detail[$i]['show'] == 'on') {
        ?>
            <?=$data_detail[$i]['name']?>: <?=$data_detail[$i]['name']?>,
            <?php }}?>
            type: type
        },
        success: function(response) {
            $("#list_account").html('');
            $('#list_account').empty().append(response);
            $("#list_account").show();
        }
    });
}

function fitler() {
    id = $("#id").val();
    price = $("#price").val();
    <?php
for ($i = 0; $i < count($data_detail); $i++) {
    if ($data_detail[$i]['show'] == 'on') {
        ?>
    <?=$data_detail[$i]['name']?> = $("#<?=$data_detail[$i]['name']?>").val();
    <?php }}?>
    load_account();
}
load_account();
</script>
<?php
require_once "../../public/client/Footer.php";
?>