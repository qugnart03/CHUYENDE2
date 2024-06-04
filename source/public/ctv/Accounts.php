<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUẢN LÝ NHÓM | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>

<?php

if(isset($_GET['id']) && $getUser['level'] == 'ctv')
{
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `groups` WHERE `id` = '".Anti_xss($_GET['id'])."'  ");
    if(!$row)
    {
        admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 500);
    }
    $detail = json_decode($row['detail'], true);
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
                    <h1>Danh sách tài khoản <?=$detail['name_product'];?></h1>
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
                            <h3 class="card-title">THÊM TÀI KHOẢN MỚI</h3>
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
                            <form class="form-data" id="form-data">
                                <input hidden name="type_category" value="<?=$row['type_category']?>">
                                <div class="row">
                                    <?php if($row['type'] == 'RANDOM'):?>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nhập dữ liệu</label>
                                            <?php
                                                $placeholder = "";
                                            for ($i=0; $i < count($detail['data']); $i++){
                                                $placeholder .= $detail['data'][$i]['label'];
                                                if($i < count($detail['data']) - 1){
                                                    $placeholder .= "|";
                                                } 
                                            }
                                            ?>
                                            <textarea type="text" class="form-control" name="data"
                                                placeholder="<?=$placeholder?>"></textarea>
                                        </div>
                                    </div>
                                    <?php else:?>

                                    <?php
                                    for ($i=0; $i < count($detail['data']); $i++) {
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?=$detail['data'][$i]['label']?></label>
                                            <?php if($detail['data'][$i]['type'] == 'input' || $detail['data'][$i]['type'] == 'password'):?>

                                            <input class="form-control" type="text"
                                                placeholder="<?=$detail['data'][$i]['label']?>"
                                                name="<?=$detail['data'][$i]['name']?>">
                                            <?php elseif($detail['data'][$i]['type'] == 'number'):?>

                                            <input class="form-control" type="number"
                                                placeholder="<?=$detail['data'][$i]['label']?>"
                                                name="<?=$detail['data'][$i]['name']?>">`
                                            <?php elseif($detail['data'][$i]['type'] == 'select'):?>
                                            <select class="form-control select2bs4"
                                                name="<?=$detail['data'][$i]['name']?>">
                                                <?php 
                                        $value = $detail['data'][$i]['value'];
                                            $ArrayValue = explode("|", $value);
                                            foreach ($ArrayValue as $optionValue) {
                                                echo '<option value="' . $optionValue . '">' . $optionValue . '</option>';
                                            }
                                            ?>
                                            </select>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Giá tiền</label>
                                            <div class="input-group mb-3">
                                                <input type="number" name="cash" class="form-control"
                                                    placeholder="Giá tiền">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Khuyến mại</label>
                                            <div class="input-group mb-3">
                                                <input type="number" name="sale" class="form-control"
                                                    placeholder="Khuyến mại" value="0">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label>Hình ảnh</label>
                                            <img class="w-100 active" id="img_1"
                                                src="https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png">
                                            <center>
                                                <span class="btn btn-default btn-file">
                                                    <input name="image[]" type="file" class="form-control"
                                                        onchange="document.getElementById('img_1').src = window.URL.createObjectURL(this.files[0])"
                                                        multiple>
                                                </span>
                                            </center>
                                        </div>
                                    </div>
                                    <?php endif;?>

                                </div>
                                <button type="button" class="btn btn-success ml-3" onclick="Upload()"><i
                                        class="fa fa-check"></i> Thêm ngay nào!</button>


                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DANH SÁCH TÀI KHOẢN</h3>
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
                            <div class="table-responsive">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Loại tài khoản</th>
                                            <th>Người đăng</th>
                                            <th>Tài khoản</th>
                                            <th>Hình ảnh</th>
                                            <th>Giá tiền</th>
                                            <th>Khuyến mại</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian</th>
                                            <th>Chỉnh sửa</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `accounts` WHERE `groups` = '".$row['id']."' AND `username_post`='".$getUser['username']."' ORDER BY `id` DESC") as $info):
                                        $query_product = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `type_category` = '{$info['type_category']}'");
                                        $detail_product = json_decode($query_product['detail'], true);
                                        $detail = json_decode($info['detail'], true);
                                        $arr_img = json_decode($info['image'], true); 
                                        $arr_detail = $detail['data'];
                                        ?>
                                        <tr>
                                            <td><?=$info['id']?></td>
                                            <td><?=$detail_product['name_product'];?></td>
                                            <td><?=$info['username_post']?></td>
                                            <td><?=decodecryptData($arr_detail[0]['value'])?></td>
                                            <td>
                                                <?php if ($info['type'] == 'ACCOUNT') {?>
                                                <img width="100px"
                                                    src="<?=BASE_URL($arr_img[0]);?>">
                                                <?php } else {?>
                                                <img width="100px"
                                                    src="<?=BASE_URL($detail_product['thumb'])?>">
                                                <?php }?>
                                            </td>
                                            <td><?=format_cash($info['money'])?></td>
                                            <td><?=format_cash($info['sale'])?>%</td>
                                            <td><?=status_type($info['status'])?></td>
                                            <td><?=date('H:i d-m-Y',$info['created_at']);?></td>
                                            <td><a class="btn btn-info btn-sm"
                                                    href="/Ctv/Account/Edit/<?=$info['id']?>" target="_blank"><i
                                                        class="fa fa-pen"></i></a></td>
                                            <td><button type="button" class="btn btn-danger btn-sm"
                                                    onclick="delete_id(<?=$info['id']?>)"><i
                                                        class="fa fa-trash"></i></button></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>




<script>
function Upload() {
    $("#button").html(
        '<button type="button" class="btn btn-success ml-3" disabled> Đang xử lý <i class="fas fa-spinner fa-pulse"></i></button>'
    );
    $.ajax({
        url: '/Model/Ctv/Account/Upload',
        type: 'POST',
        dataType: 'JSON',
        data: new FormData($('form#form-data')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            if (data.status == 'success') {
                $("#button").html(
                    '<button type="button" class="btn btn-success ml-3" onclick="Upload()"><i class="fa fa-check"></i> Thêm ngay nào!</button>'
                );
                Toast(data.status, data.msg);
                filter_datatable();
                document.getElementById("form-data").reset();
                $("#img_1").attr("src",
                    "https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png"
                );
            } else {
                Toast(data.status, data.msg);
            }
        }
    });
}

function delete_id(id) {
    let text = "Bạn có chắc muốn thực hiện thao tác này không?";
    if (confirm(text) == true) {
        $.ajax({
            url: '/Model/Ctv/Account/Delete',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id
            },
            success: function(data) {
                Toast(data.status, data.msg);
            }
        });
    }
}
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $("#datatable1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $("#datatable2").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>



<?php 
    require_once(__DIR__."/Footer.php");
?>