<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once("../../config.php");
    $title = 'QUẢN LÝ NGÂN HÀNG | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>
<?php
if (isset($_GET['id']) && $getUser['level'] == 'admin') {
    $id = Anti_xss($_GET['id']);
    $row = $SIEUTHICODE->get_row("SELECT * FROM `bank` WHERE `id` = '$id' ");
    if (!$row) {
        new Redirect('/');
    }
} else {
    new Redirect('/');
}
if (isset($_POST['LuuNganHang']) && $getUser['level'] == 'admin') {
    if ($SIEUTHICODE->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if (check_img('image') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/bank/'.$rand.'.png';
        $tmp_name = $_FILES['image']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $SIEUTHICODE->update('bank', [
                'image'  => 'assets/storage/images/bank/'.$rand.'.png'
            ], " `id` = '$id' ");
        }
    }
    $isUpdate = $SIEUTHICODE->update("bank", [
        'short_name' => Anti_xss($_POST['short_name']),
        'accountNumber' => Anti_xss($_POST['accountNumber']),
        'accountName' => Anti_xss($_POST['accountName'])
    ], " `id` = '$id' ");
    if ($isUpdate) {
        insert_log($getUser['id'],"Cập nhật thông tin ngân hàng (".$_POST['short_name']." - ".$_POST['account_number'].") vào hệ thống.");
        die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Lưu thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh sửa ngân hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('/Admin/Home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa ngân hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-university mr-1"></i>
                                DANH SÁCH NGÂN HÀNG
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
                        <div class="card-body p-0">
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th>ShortName</th>
                                        <th>Account Number</th>
                                        <th>Account Name</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `bank`  ") as $bank) {?>
                                    <tr>
                                        <td><?=$bank['id'];?></td>
                                        <td><?=$bank['short_name'];?></td>
                                        <td><?=$bank['accountNumber'];?></td>
                                        <td><?=$bank['accountName'];?></td>
                                        <td><a aria-label="" href="<?=BASE_URL('Admin/Bank/Edit/'.$bank['id']);?>"
                                                style="color:white;" class="btn btn-info btn-sm btn-icon-left m-b-10"
                                                type="button">
                                                <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                            </a>
                                            <button style="color:white;" onclick="delete_id('<?=$bank['id'];?>')"
                                                class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <section class="col-lg-5 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-university mr-1"></i>
                                CHỈNH SỬA NGÂN HÀNG
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
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngân hàng</label>
                                    <select class="form-control select2bs4" name="short_name" required>
                                        <option value="">Chọn ngân hàng</option>
                                        <?php foreach ($config_listbank as $key => $value) {?>
                                        <option <?=$row['short_name'] == $key ? 'selected' : '';?> value="<?=$key;?>">
                                            <?=$value;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <img class="w-100" src="<?=BASE_URL($row['image']);?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số tài khoản</label>
                                    <input type="text" class="form-control" name="accountNumber"
                                        placeholder="Nhập số tài khoản" value="<?=$row['accountNumber'];?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên chủ tài khoản</label>
                                    <input type="text" class="form-control" name="accountName"
                                        placeholder="Nhập tên chủ tài khoản" value="<?=$row['accountName'];?>" required>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="LuuNganHang" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                <a class="btn btn-danger btn-icon-left m-b-10" href="/Admin/Bank" type="button"><i
                                        class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
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
            url: '/Model/Admin/DeleteBank',
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
</script>
<?php 
    require_once(__DIR__."/Footer.php");
?>