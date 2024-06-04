<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
$title = 'Bán vàng NRO - Thông tin bot nạp | ' . $SIEUTHICODE->site('tenweb');
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Header.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Sidebar.php';
?>
<?php
if(isset($_GET['id']) && $getUser['level'] == 'admin')
{
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `coin_nro` WHERE `id` = '".Anti_xss($_GET['id'])."'  ");
    if(!$row)
    {
        new Redirect('/');
    }
}
else
{
    new Redirect('/');
}
if (isset($_POST['Update']) && $getUser['level'] == 'admin') {
    if ($SIEUTHICODE->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $SIEUTHICODE->update("coin_nro", [
        'server_nro' => Anti_xss($_POST['server_nro']),
        'factor' => Anti_xss($_POST['factor']),
        'min_value' => Anti_xss($_POST['min_value']),
        'max_value' => Anti_xss($_POST['max_value']),
        'status' => Anti_xss($_POST['status'])
    ]," `id` = '".$row['id']."' ");
    if ($isInsert) {
        insert_log($getUser['id'],"Chỉnh sửa thông tin bán vàng (ID ".$row['id'].").");
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){window.history.back().location.reload();}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bán vàng NRO - Thông tin bot nạp - Cập nhật</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('Admin/Home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Bán vàng NRO - Thông tin bot nạp - Cập nhật</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                    <div class="mb-3">
                        <a class="btn btn-danger btn-icon-left m-b-10"
                            href="<?=base_url('Admin/toolgame/nrocoin-usernap');?>" type="button"><i
                                class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-blog mr-1"></i>
                                Bán vàng NRO - Thông tin bot nạp
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Máy chủ</label>
                                            <input type="number" class="form-control" name="server_nro"
                                                placeholder="Máy chủ" value="<?=$row['server_nro']?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Hệ số</label>
                                            <input type="number" class="form-control" name="factor"
                                                value="<?=$row['factor']?>" placeholder="Hệ số" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giá tiền tối thiểu</label>
                                            <input type="number" class="form-control" value="<?=$row['min_value']?>"
                                                name="min_value" placeholder="Giá tiền tối thiểu" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giá tiền tối đa</label>
                                            <input type="number" class="form-control" value="<?=$row['max_value']?>"
                                                name="max_value" placeholder="Giá tiền tối đa" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Trạng thái</label>
                                            <select class="form-control select2bs4" name="status" required>
                                                <option <?=$row['status'] == 1 ? 'selected' : '';?> value="1">Hiển thị
                                                </option>
                                                <option <?=$row['status'] == 0 ? 'selected' : '';?> value="0">
                                                    Ẩn
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="Update" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Footer.php';
?>