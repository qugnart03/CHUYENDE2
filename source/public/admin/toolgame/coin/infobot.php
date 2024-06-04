<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
$title = 'Bán vàng NRO - Bot | ' . $SIEUTHICODE->site('tenweb');
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Header.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Sidebar.php';
?>
<?php
if(isset($_POST['SaveSettings']) && $getUser['level'] == 'admin')
{
    if($SIEUTHICODE->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    if (check_img('logo_banvang') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../../../assets/storage/images/logo_' . $rand . '.png';
        $tmp_name = $_FILES['logo_banvang']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/logo_' . $rand . '.png'
            ], " `key` = 'logo_banvang' ");
        }
    }
    foreach ($_POST as $key => $value)
    {
        if($key == 'logo_banvang') continue;
        $SIEUTHICODE->update("options", array(
            'value' => $value
        ), " `key` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bán vàng NRO - Bot</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                </section>
                <section class="col-lg-6 text-right">
                    <div class="mb-3">
                        <a class="btn btn-primary btn-icon-left m-b-10" href="/Admin/toolgame/nrocoin-info-bot/create"
                            type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm mới</a>
                    </div>
                </section>

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Bán vàng NRO - Bot</h3>
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
                                <table id="datatable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Máy chủ</th>
                                            <th>Tên nhân vật</th>
                                            <th>Tiền(Ingame)</th>
                                            <th>Thỏi vàng</th>
                                            <th>Tổng vàng</th>
                                            <th>Địa điểm</th>
                                            <th>Khu vực</th>
                                            <th>Cập nhật</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `nrocoin_info_bot` ORDER BY `server_nro` ASC") as $info):?>
                                        <tr>
                                            <td><?=$info['id']?></td>
                                            <td><?=$info['server_nro'];?></td>
                                            <td><?=$info['player'];?></td>
                                            <td><?=format_cash($info['gem'])?></td>
                                            <td><?=format_cash($info['gold_bar'])?></td>
                                            <td><?=format_cash($info['gold_number'])?></td>
                                            <td><?=$info['location']?></td>
                                            <td><?=$info['zone']?></td>
                                            <td><?=$info['updated_at']?></td>
                                            <td><?=display_status_product($info['status'])?></td>
                                            <td>
                                                <a class="btn btn-info btn-sm"
                                                    href="/Admin/toolgame/nrocoin-info-bot/edit/<?=$info['id']?>"><i
                                                        class="fa fa-pen"></i></a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="delete_id(<?=$info['id']?>)"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẤU HÌNH THÔNG TIN
                            </h3>
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên danh mục</label>
                                            <input type="text" class="form-control" name="title_banvang"
                                                placeholder="" value="<?=$SIEUTHICODE->site('title_banvang')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giao dịch ảo</label>
                                            <input type="number" class="form-control" name="fake_coin" placeholder=""
                                                value="<?=$SIEUTHICODE->site('fake_coin')?>">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Thumbnail</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="logo_banvang">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px" src="<?=BASE_URL($SIEUTHICODE->site('logo_banvang'))?>" />
                                        <hr>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status_coin_nro">
                                        <option <?=$SIEUTHICODE->site('status_coin_nro') == 1 ? 'selected' : '';?>
                                            value="1">ON
                                        </option>
                                        <option <?=$SIEUTHICODE->site('status_coin_nro') == 0 ? 'selected' : '';?>
                                            value="0">
                                            OFF
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lưu ý</label>
                                    <textarea id="notice_banvang"
                                        name="notice_banvang"><?=$SIEUTHICODE->site('notice_banvang')?></textarea>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>




<script>
function delete_id(id) {
    let text = "Bạn có chắc muốn thực hiện thao tác này không?";
    if (confirm(text) == true) {
        $.ajax({
            url: '/Model/Admin/BotCoin/Delete',
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
CKEDITOR.replace("notice_banvang");
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>



<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Footer.php';
?>