<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
error_reporting(0);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = Anti_xss($_POST['type']);
    $arr_data = array();
    $current_page = isset($_POST['page']) ? (int) Anti_xss($_POST['page']) : 1;
    $price = isset($_POST['price']) ? Anti_xss($_POST['price']) : "";
    $id = isset($_POST['id']) ? (int) Anti_xss($_POST['id']) : '';
// lấy giá trị name ở bộ lọc
    $sql_query = "SELECT * FROM `accounts` WHERE `type_category` = '{$type}' AND `status` = 'on'";
    $query = $SIEUTHICODE->get_row($sql_query);
    if ($query) {
        $detail_query = json_decode($query['detail'], true);
        
    }else{
        die('<div class="col-span-12 flex justify-center h-48 items-center font-semibold text-white">
        Không tìm thấy tài khoản hoặc đã được bán hết. Vui lòng liên hệ
        Fanpage ở dưới để được bổ sung, Xin cám ơn!
    </div>');
    }
    //$detail_query = json_decode($query['detail'], true); // lấy detail
    $arr_query = $detail_query['data']; // lấy data trong detail
    // print_r($arr_query);
    $sql = array();
    for ($a = 0; $a < count($arr_query); $a++) { // vòng lặp data detail
        if ($arr_query[$a]['show'] == 'on') { // check hiện thị của data
            //$$arr_query[$a]['name'] = Anti_xss($_POST[$arr_query[$a]['name']]); // lấy giá trị từ bên ngoại
            $name = Anti_xss($_POST[$arr_query[$a]['name']]);
            $arr_name = $arr_query[$a]['name']; // biến này đéo chạy nên phải ghi như thế
      
            if ($name != null) {
                $sql[] = "AND JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(`detail`, '$.data[$a]'), '$.$arr_name')) = '{$name}'"; // câu lệnh lọc giá trị array đa mảng
            }
        }
    }
    $implode = implode("", $sql); // nối câu lệnh

// đóng lấy bộ lọc
    if ($current_page < 1) {
        $current_page = 1;
    }

    $sql_id = "";
    if ($id) {
        $sql_id = " AND `id` = '{$id}'";
    }
//sql search price
    $sql_price = "";
    if ($price == 'duoi-50k') {
        $sql_price = "AND `money` < 50000 ";
    } elseif ($price == 'tu-50k-200k') {
        $sql_price = "AND `money` BETWEEN 50000 AND 200000 ";
    } elseif ($price == 'tu-200k-500k') {
        $sql_price = "AND `money` BETWEEN 200000 AND 500000 ";
    } elseif ($price == 'tu-500k-1-trieu') {
        $sql_price = "AND `money` BETWEEN 500000 AND 1000000 ";
    } elseif ($price == 'tren-1-trieu') {
        $sql_price = "AND `money` >= 1000000 ";
    } elseif ($price == 'tren-5-trieu') {
        $sql_price = "AND `money` >= 5000000 ";
    } elseif ($price == 'tren-10-trieu') {
        $sql_price = "AND `money` >= 10000000 ";
    } else {
        $sql_price = '';
    }
    $sql_acc = "SELECT * FROM `accounts` WHERE `type_category` = '{$type}' AND `status` = 'on' $sql_id $sql_price $implode";
    $total_records = $SIEUTHICODE->num_rows($sql_acc);
    $limit = 16; // giới hạn số lượng trên 1 trang
    if ($limit < 0) {
        $limit = 0;
    }
    $total_page = ceil($total_records / $limit);
    if (!$total_page) {
        $total_page = 1;
    }
    if ($current_page < 1) {
        $current_page = 1;
    }
    if ($current_page > $total_page) {
        $current_page = $total_page;
    }
    $start = ($current_page - 1) * $limit;
    $range = 6; // độ dài của nút trang
    $middle = ceil($range / 2);
    if ($total_page < $range) {
        $min = 1;
        $max = $total_page;
    } else {
        $min = $current_page - $middle + 1;
        $max = $current_page + $middle - 1;
        if ($min < 1) {
            $min = 1;
            $max = $range;
        } else if ($max > $total_page) {
            $max = $total_page;
            $min = $total_page - $range + 1;
        }
    }
    $sql_show = "SELECT * FROM `accounts` WHERE `type_category` = '{$type}' AND `status` = 'on' $sql_id $sql_price $implode  ORDER BY `id` DESC LIMIT $start, $limit";
    if ($total_records > 0) {
        foreach ($SIEUTHICODE->get_list($sql_show) as $info) {
            $check = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `type_category` = '{$info['type_category']}'"); // lấy dữ liệu từ product
            $detail_product = json_decode($check['detail'], true); // get detail product
            $arr_img = json_decode($info['image'], true); // ảnh ở list_account
            $detail = json_decode($info['detail'], true); // detail list_account
            ?>
<div
    class="fade-in col-span-12 card-stc sm:col-span-4 md:col-span-3 lg:col-span-3 xl:col-span-3 relative border border-transparent hover:border-red-500 transition duration-200 rounded" > <!--style="height:400px"-->
    <a href="/views/account/<?=$info['id']?>" class="">
        <div class="mb-20">
            <span class="absolute v-text-1 bg-red-700 text-white font-bold text-sm inline-block px-2 rounded-sm"
                style="right: 5px; top: 5px;">MS <?=$info['id']?></span>
            <?php if ($check['type'] == 'ACCOUNT') {?>
            <img class="h-56 md:h-40 w-full object-fill object-center rounded-t-sm lazyLoad isLoaded"
                src="<?=BASE_URL($arr_img[0]);?>">
            <?php } else {?>
            <img class="h-56 md:h-40 w-full object-fill object-center rounded-t-sm lazyLoad isLoaded"
                src="<?=BASE_URL($detail_product['thumb'])?>">
            <?php }?>
            <div class="my-2 py-1 px-2"> <!--relative-->
                <div class="grid grid-cols-12 gap-y-1 leading-6 text-white text-xs"
                    style="font-size: 15px; font-weight: 500;">

                    <?php
for ($i = 0; $i < count($detail['data']); $i++) {
                if ($detail['data'][$i]['show'] == 'on') {
                    ?>
                    <div class="col-span-12 text-base md:text-sm">
                        <p>
                            <i class="relative bx bx-caret-right" style="top: 1px;"></i>
                            <?=$detail['data'][$i]['label']?>:
                            <b class="text-white"> <?=decodecryptData($detail['data'][$i]['value'])?> </b>
                        </p>
                    </div>

                    <?php }
            }?>

                </div>
            </div>
        </div>


        <div class="right-0 bottom-0 left-0 p-2" > <!--non absolute-->
            <div class="rounded-b-sm px-2 py-1">
                <ul class="rounded-sm w-full font-medium">
                    <span class="w-full text-center inline-block px-2">
                        <?php if ($check['type'] == 'ACCOUNT'): ?>
                            <?php if($info['sale'] != 0):?>
                        <span class="text-white inline-block text-xs line-through">
                            <?=format_cash($info['money'])?><small>đ</small></span>
                            <?php endif;?>
                        <span class="text-red-500 text-lg font-extrabold">
                            <?=format_cash($info['money'] -($info['money']*$info['sale']/100))?><small>đ</small></span></span>
                    <?php else: ?>
                    <span class="text-red-500 text-lg font-extrabold">
                        <?=format_cash($info['money'])?><small>đ</small></span></span>
                    <?php endif;?>
                </ul>
            </div>

            <?php if ($check['type'] == 'ACCOUNT'): ?>

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


<?php }
    } else {?>
<div class="col-span-12 flex justify-center h-48 items-center font-semibold text-white">
    Không tìm thấy tài khoản hoặc đã được bán hết. Vui lòng liên hệ
    Fanpage ở dưới để được bổ sung, Xin cám ơn!
</div>
<?php }?>

</div>
<!-- qua trang -->
<div class="col-span-12 flex justify-center items-center font-semibold text-gray-700">
    <div class="pb-8 mb-8">
        <div class="min-w-max">
            <section class="flex justify-between py-1 text-gray-700 font-montserrat select-none">
            <?php
$tong = $SIEUTHICODE->num_rows("SELECT * FROM `accounts` WHERE `type_category` = '{$type}' AND `status` = 'on' $sql_id $sql_price $implode  ORDER BY `id` ASC");
    if ($tong > $limit) {
        echo '<center>' . pagination_account('', $start, $tong, $limit) . '</center>';
    }?>  
            </section>
        </div>
    </div>
</div>
</div>
<?php } else {
    die(json_encode(array('message' => "The requested resource does not support http method 'GET'.")));
}
?>
<!-- kết thúc else qua trang -->