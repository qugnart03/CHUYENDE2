<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    require_once("../../config.php");
    $title = 'QUẢN LÝ NGÂN HÀNG | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>
<?php

if (isset($_POST['ThemNganHang']) && $getUser['level'] == 'admin') {
    if ($SIEUTHICODE->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $url_image = '';
    if (check_img('image') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/bank/'.$rand.'.png';
        $tmp_name = $_FILES['image']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $url_image = 'assets/storage/images/bank/'.$rand.'.png';
        }
    }
    $isInsert = $SIEUTHICODE->insert("bank", [
        'image'         => $url_image,
        'short_name'    => Anti_xss($_POST['short_name']),
        'accountNumber' => Anti_xss($_POST['accountNumber']),
        'accountName'   => Anti_xss($_POST['accountName'])
    ]);
    if ($isInsert) {
        insert_log($getUser['id'],"Thêm ngân hàng (".$_POST['short_name']." - ".$_POST['account_number'].") vào hệ thống.");
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){window.history.back().location.reload();}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}


if(isset($_POST['btnSaveOption']) && $getUser['level'] == 'admin')
{
    if($SIEUTHICODE->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    foreach ($_POST as $key => $value)
    {
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
                    <h1>Cấu hình Nạp Ví - ATM</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-university mr-1"></i>
                                THÔNG TIN THANH TOÁN NGÂN HÀNG & VÍ ĐIỆN TỬ
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
                                THÊM NGÂN HÀNG
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
                                        <option value="<?=$key;?>"><?=$value;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image" required>
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số tài khoản</label>
                                    <input type="text" class="form-control" name="accountNumber"
                                        placeholder="Nhập số tài khoản" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên chủ tài khoản</label>
                                    <input type="text" class="form-control" name="accountName"
                                        placeholder="Nhập tên chủ tài khoản" required>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="ThemNganHang" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Thêm Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cấu hình Nạp Ví - ATM</h3>
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
                            <form action="" method="POST">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2bs4" name="status_napbank">
                                                <option
                                                    <?=$SIEUTHICODE->site('status_napbank') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                                <option
                                                    <?=$SIEUTHICODE->site('status_napbank') == 0 ? 'selected' : '';?>
                                                    value="0">
                                                    OFF
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>API MBBANK (<a href="https://api.sieuthicode.net" target="_blank">Xem
                                                    Ngay</a>)</label>
                                            <input type="text" name="api_bank"
                                                value="<?=$SIEUTHICODE->site('api_bank');?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>API ACB (<a href="https://api.sieuthicode.net" target="_blank">Xem
                                                    Ngay</a>)</label>
                                            <input type="text" name="token_acb"
                                                value="<?=$SIEUTHICODE->site('token_acb');?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>API VIETCOMBANK (<a href="https://api.sieuthicode.net" target="_blank">Xem
                                                    Ngay</a>)</label>
                                            <input type="text" name="token_vcb"
                                                value="<?=$SIEUTHICODE->site('token_vcb');?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>API MOMO (<a href="https://api.sieuthicode.net" target="_blank">Xem
                                                    Ngay</a>)</label>
                                            <input type="text" name="api_momo"
                                                value="<?=$SIEUTHICODE->site('api_momo');?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nội dung nạp tiền</label>
                                            <input type="text" name="noidung_naptien"
                                                value="<?=$SIEUTHICODE->site('noidung_naptien');?>"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chiết khấu khuyến mãi</label>
                                            <input type="text" name="ck_bank"
                                                placeholder="Khuyến mãi thêm bao nhiêu % khi nạp tiền qua ngân hàng, ví điện tử"
                                                value="<?=$SIEUTHICODE->site('ck_bank');?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Lưu ý</label>
                                            <textarea id="luuy_napbank"
                                                name="luuy_napbank"><?=$SIEUTHICODE->site('luuy_napbank')?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                    <span>LƯU</span></button>
                            </form>
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
CKEDITOR.replace("luuy_napbank");
</script>

<?php 
    require_once(__DIR__."/Footer.php");
?>