<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
$title = 'Bán ngọc NRO - Thông tin bot nạp | ' . $SIEUTHICODE->site('tenweb');
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Header.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Sidebar.php';
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bán ngọc NRO - Thông tin bot nạp</h1>
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
                        <a class="btn btn-primary btn-icon-left m-b-10" href="<?=BASE_URL('Admin/toolgame/nrogem-api-usernap/create');?>"
                            type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm mới</a>
                    </div>
                </section>

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Bán ngọc NRO - Thông tin bot nạp</h3>
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
                                            <th>Hệ số</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `gem_api_nro` ORDER BY `server_nro` ASC") as $info):?>
                                        <tr>
                                            <td><?=$info['id']?></td>
                                            <td><?=$info['server_nro'];?></td>
                                            <td><?=$info['factor']?></td>
                                            <td><?=format_cash($info['min_value'])?></td>
                                            <td><?=format_cash($info['max_value'])?></td>
                                            <td><?=display_status_product($info['status'])?></td>
                                            <td>
                                                <a class="btn btn-info btn-sm"
                                                    href="/Admin/toolgame/nrogem-api-usernap/edit/<?=$info['id']?>"><i
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
            url: '/Model/Admin/BotNapGemApi/Delete',
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
});
</script>



<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Footer.php';
?>