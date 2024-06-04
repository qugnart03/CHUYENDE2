<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CHỈNH SỬA TÀI KHOẢN | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>
<?php

if(isset($_GET['id']) && $getUser['level'] == 'admin')
{
    $id = Anti_xss($_GET['id']);
    $query = $SIEUTHICODE->get_row(" SELECT * FROM `accounts` WHERE `id` = '".Anti_xss($_GET['id'])."'  ");
    if(!$query)
    {
        admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 500);
    }
    $query_product = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `type_category` = '{$query['type_category']}'");
    $detail_product = json_decode($query_product['detail'], true);
    $detail = json_decode($query['detail'], true);
    $arr_data = $detail['data'];
}
else
{
    admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 0);
}
?>



<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa tài khoản</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">CHỈNH SỬA TÀI KHOẢN [<?=$id?>]</h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-data" id="form-update">
                                <input hidden name="id" value="<?=$id?>">
                                <input hidden name="type_category" value="<?=$query['type_category']?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Loại tài khoản</label>
                                            <select class="form-control select2bs4" name="type">
                                                <option value="ACCOUNT"
                                                    <?=$query['type'] == 'ACCOUNT' ? 'selected="selected"' : ''?>>
                                                    Tài khoản</option>
                                                <option value="RANDOM"
                                                    <?=$query['type'] == 'RANDOM' ? 'selected="selected"' : ''?>>Vận
                                                    may</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Loại trò chơi</label>
                                            <select class="form-control select2bs4" name="type_category" disabled>
                                                <?php
                                                foreach($SIEUTHICODE->get_list("SELECT DISTINCT `type_category`,`detail` FROM `groups` WHERE `type` IN ('ACCOUNT','RANDOM')", 0) as $info){
                                                    $detail = json_decode($info['detail'], true);
                                            ?>
                                                <option value="<?=$info['type_category']?>"
                                                    <?=$info['type_category'] == $query['type_category'] ? 'selected="selected"' : ''?>>
                                                    <?=$detail['name_product']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Giá tiền</label>
                                            <input class="form-control" name="cash" type="number" placeholder="Giá tiền"
                                                value="<?=$query['money']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Khuyến mại</label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" placeholder="Khuyến mại"
                                                    name="sale" value="<?=$query['sale']?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control select2bs4" name="status">
                                                <option value="on"
                                                    <?=$query['status'] == 'on' ? 'selected="selected"' : ''?>>Chưa
                                                    bán</option>
                                                <option value="off"
                                                    <?=$query['status'] == 'off' ? 'selected="selected"' : ''?>>Đã
                                                    bán</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php for ($i=0; $i < count($arr_data); $i++) { ?>
                                    <?php if($arr_data[$i]['type'] == 'password'){?>
                                    <?php if($getUser['level'] == '3'){?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?=$arr_data[$i]['label']?></label>
                                            <input class="form-control" type="text" value="*********" disabled>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <?php } ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?=$arr_data[$i]['label']?></label>
                                            <?php if($arr_data[$i]['type'] == 'input' || $arr_data[$i]['type'] == 'number' || $arr_data[$i]['type'] == 'password'){?>
                                            <input class="form-control" name="<?=$arr_data[$i]['name']?>"
                                                placeholder="<?=$arr_data[$i]['label']?>" type="text"
                                                value="<?=decodecryptData($arr_data[$i]['value'])?>">
                                            <?php }elseif($arr_data[$i]['type'] == 'select'){ ?>
                                            <select class="form-control select2bs4" name="<?=$arr_data[$i]['name']?>">
                                                <?php 
                                                        $explode = explode('|', $detail_product['data'][$i]['value']);
                                                        for ($a=0; $a < count($explode); $a++) {
                                                    ?>
                                                <option value="<?=$explode[$a]?>"
                                                    <?=decodecryptData($arr_data[$i]['value']) == $explode[$a] ? 'selected="selected"' : ''?>>
                                                    <?=$explode[$a]?></option>
                                                <?php } ?>
                                            </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if($query['type'] == 'ACCOUNT'):?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nội dung bằng hình ảnh</label>
                                            <center>
                                                <span class="btn-file">
                                                    <input name="image[]" type="file" class="form-control" multiple>
                                                </span>
                                                <br>
                                            </center>
                                            <?php 
                                                $arr_image = json_decode($query['image'], true);
                                                for ($i=0; $i < count($arr_image); $i++) {
                                            ?>
                                            <img class="w-15 active lazyLoad" src="<?=BASE_URL($arr_image[$i])?>"
                                                height="80px" width="128px">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                </div>
                                <button type="button" id="EditAccount" class="btn btn-success btn-block btn-lg shadow-lg mt-3"
                                    onclick="Update()">Xác nhận</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<script>
function Update() {
    $('#EditAccount').html('<i class="fas fa-spinner fa-pulse"></i> Đang xử lý...').prop('disabled',
        true);
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
    $.ajax({
        url: '/Model/Admin/Account/Edit',
        type: 'POST',
        dataType: 'JSON',
        data: new FormData($('form#form-update')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            Toast(data.status, data.msg);
            $('#EditAccount').html(
                    'Xác nhận')
                .prop('disabled', false);
        }
    });
}
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>






<?php 
    require_once(__DIR__."/Footer.php");
?>