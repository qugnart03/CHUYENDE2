<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'TÀI KHOẢN TRẢ THƯỞNG | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách tài khoản trả thưởng</h1>
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
                            <h3 class="card-title">DANH SÁCH TÀI KHOẢN TRẢ THƯỞNG</h3>
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
                            <div class="align-items-center justify-content-between mb-1" style="text-align: right;">
                                <a href="javascript:" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                                    data-toggle="modal" data-target="#AddAccount"><i
                                        class="fas fa-plus fa-sm text-white-50"></i> Thêm tài khoản</a>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Loại tài khoản</th>
                                            <th>Người đăng</th>
                                            <th>Tài khoản</th>
                                            <th>Mật khẩu</th>
                                            <th>Vị trí ô</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    // foreach($SIEUTHICODE->get_list(" SELECT * FROM `account_reward` ORDER BY id DESC ") as $row){
                                    //     $query_product = $SIEUTHICODE->get_row("SELECT * FROM `minigame` WHERE `type_category` = '{$row['type_category']}'");
                                    //     $detail_product = json_decode($query_product['detail'], true);                 
                                     foreach($SIEUTHICODE->get_list(" SELECT * FROM `account_reward` ORDER BY id DESC ") as $row){
                                        $query_product = $SIEUTHICODE->get_row("SELECT * FROM `minigame` WHERE `id` = '{$row['ID_TYPE']}'");
                                        $detail_product = json_decode($query_product['detail'], true);                  
                                    ?>
                                        <tr>
                                            <td><?=$row['id'];?></td>
                                            <td>#<?=$detail_product['name_product'];?></td>

                                            <td><?=$row['username_post']?></td>
                                            <td><?=$row['taikhoan'];?></td>
                                            <td><?=$row['matkhau'];?></td>
                                            <td><?=$row['vitri'];?></td>
                                            <td><?=status_type($row['status'])?></td>
                                            <td><button type="button" class="btn btn-danger btn-sm" onclick="delete_id(<?=$row['id']?>)"><i class="fa fa-trash"></i></button></td>
                                            <td><?=date('H:i d-m-Y',$row['created_at']);?></td>
                                        </tr>
                                        <?php }?>
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

<div class="modal fade" id="AddAccount" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Đăng tài khoản </h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-data">
                    <input hidden name="type" value="upload">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Loại tài khoản</label>
                                <select class="form-control select2bs4" name="type_category">
                                    <option value="">Chọn loại tài khoản</option>
                                    <?php
                                        foreach ($SIEUTHICODE->get_list("SELECT DISTINCT `type_category`,`detail` FROM `minigame` WHERE `id` != '0' AND `type` IN ('VONGQUAY', 'BINGO3', 'LATHINH', 'MOQUA')", 0) as $info) {
                                            $detail = json_decode($info['detail'], true);
                                        ?>
                                    <option value="<?= $info['type_category'] ?>"><?= $detail['name_product'] ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Thông tin tài khoản</label>
                                <textarea class="form-control" type="text" name="info"
                                    placeholder="Tài khoản|Mật khẩu|Vị trí&#10;Mỗi dòng là 1 tài khoản"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="upload" class="btn btn-success ml-3" onclick="Upload()"><i
                        class="fa fa-check"></i> Thêm
                    ngay nào!</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">

                    Thoát
                </button>
            </div>
        </div>
    </div>
</div>
<script>
function Upload() {
    $('#upload').html('<i class="fa fa-spinner fa-pulse"></i> Đang xử lý').prop('disabled',
        true);
    var data = $(".form-data").serialize();
    $.ajax({
        url: '/Model/Account/UploadReward',
        type: 'POST',
        dataType: 'JSON',
        data: data,
        success: function(data) {
            Toast(data.status, data.msg);
            $('#upload').html(
                    '<i class="fa fa-check"></i> Thêm ngay nào!')
                .prop('disabled', false);
        }
    });
}

function delete_id(id) {
    let text = "Bạn có chắc muốn thực hiện thao tác này không?";
    if (confirm(text) == true) {
        $.ajax({
            url: '/Model/Account/UploadReward',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id,
                type: 'delete'
            },
            success: function(data) {
                Toast(data.status, data.msg);
            }
        });
    }
}
</script>
<script>
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