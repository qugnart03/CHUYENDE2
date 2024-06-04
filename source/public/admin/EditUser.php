<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CHỈNH SỬA THÀNH VIÊN | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
?>
<?php
if(isset($_GET['id']) && $getUser['level'] == 'admin')
{
    $user = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `id` = '".Anti_xss($_GET['id'])."'  ");
    if(!$user)
    {
        new Redirect('/');
    }
}
else
{
    new Redirect('/');
}

if(isset($_POST['btnCongTien']) && isset($_POST['value']) && isset($user['username']) && $getUser['level'] == 'admin')
{
    $value = Anti_xss($_POST['value']);
    $ghichu = Anti_xss($_POST['ghichu']);
    if($value <= 0)
    {
        admin_msg_error("Vui lòng nhập số tiền hợp lệ", "", 2000);
    }
    $create = $SIEUTHICODE->insert("dongtien", [
        'sotientruoc' => $user['money'],
        'sotienthaydoi' => $value,
        'sotiensau' => $user['money'] + $value,
        'thoigian' => gettime(),
        'noidung' => 'Admin cộng tiền ('.$ghichu.')',
        'username' => $user['username']
    ]);
    if($create)
    {
        $SIEUTHICODE->cong("users", "money", $value, " `username` = '".$user['username']."' ");
        $SIEUTHICODE->cong("users", "total_money", $value, " `username` = '".$user['username']."' ");
        admin_msg_success("Cộng tiền thành công!", "", 2000);
    }
    else
    {
        admin_msg_error("Vui lòng liên hệ kỹ thuật Zalo 0978364572", "", 12000);
    }
    
}

if(isset($_POST['btnTruTien']) && isset($_POST['value']) && isset($user['username']) && $getUser['level'] == 'admin')
{
    $value = Anti_xss($_POST['value']);
    $ghichu = Anti_xss($_POST['ghichu']);
    if($value <= 0)
    {
        admin_msg_error("Vui lòng nhập số tiền hợp lệ", "", 2000);
    }
    $create = $SIEUTHICODE->insert("dongtien", [
        'sotientruoc' => $user['money'],
        'sotienthaydoi' => $value,
        'sotiensau' => $user['money'] - $value,
        'thoigian' => gettime(),
        'noidung' => 'Admin trừ tiền ('.$ghichu.')',
        'username' => $user['username']
    ]);
    if($create)
    {
        $SIEUTHICODE->tru("users", "money", $value, " `username` = '".$user['username']."' ");
        $SIEUTHICODE->tru("users", "total_money", $value, " `username` = '".$user['username']."' ");
        admin_msg_success("Trừ tiền thành công!", "", 2000);
    }
    else
    {
        admin_msg_error("Vui lòng liên hệ kỹ thuật Zalo 0978364572", "", 12000);
    }
    
}
if(isset($_POST['btnSaveUser']) && isset($_GET['id']) && $getUser['level'] == 'admin')
{
    if($SIEUTHICODE->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    $token = Anti_xss($_POST['token']);
    $otp = Anti_xss($_POST['otp']);
    $level = Anti_xss($_POST['level']);
    $banned = Anti_xss($_POST['banned']);
    $maxprice = Anti_xss($_POST['maxprice']);
    $password = Anti_xss($_POST['password']);
    $group = ($_POST['group']);
    $group_string = null;
    if ($group !== null) {
        $group_string = Anti_xss(implode(',', $group));
    }
    $isUpdate = $SIEUTHICODE->update("users", array(
        'otp'           => $otp,
        'token'         => $token,
        'level'         => $level,
        'banned'        => $banned,
        'role'        => $group_string,
        'login_attempts' => 0,
        'maxprice'        => $maxprice
    ), " `id` = '".$user['id']."' ");
    if($isUpdate){
        if (!empty($_POST['password'])) {
            $SIEUTHICODE->update("users", array(
                'password'      => TypePassword($password)
            ), " `id` = '".$user['id']."' ");
        }
        die('<script type="text/javascript">if(!alert("Cập nhật thông tin thành công")){window.history.back().location.reload();}</script>');
    }else{
        die('<script type="text/javascript">if(!alert("Cập nhật thông tin thất bại")){window.history.back().location.reload();}</script>');
    }
    
}
?>



<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa thành viên</h1>
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
                            <h3 class="card-title">
                                <i class="fas fa-user-edit mr-1"></i>
                                CHỈNH SỬA THÀNH VIÊN
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
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Username (*)</label>
                                        <input type="text" class="form-control" value="<?=$user['username'];?>"
                                            name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email (*)</label>
                                        <input type="email" class="form-control" value="<?=$user['email'];?>"
                                            name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>OTP</label>
                                        <input type="text" class="form-control" value="<?=$user['otp'];?>" name="otp">
                                    </div>
                                    <div class="form-group">
                                        <label>Token (*)</label>
                                        <input type="text" class="form-control" value="<?=$user['token'];?>"
                                            name="token" required>
                                        <i>Không được để lộ Token của thành viên tránh hacker chiếm quyền đăng nhập bằng
                                            token.</i>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mật khẩu (*)</label>
                                                <input type="text" class="form-control" placeholder="**********"
                                                    name="password">
                                                <i>Nhập mật khẩu cần thay đổi, hệ thống sẽ tự động mã hoá (để trống nếu
                                                    không muốn
                                                    thay đổi)</i>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Secret Key Google 2FA</label>
                                                <input type="text" class="form-control"
                                                    value="<?=$user['SecretKey_2fa'];?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ON/OFF Google 2FA (*)</label>
                                                <select class="form-control select2bs4" name="status_2fa">
                                                    <option <?=$user['status_2fa'] == 1 ? 'selected' : '';?> value="1">
                                                        ON
                                                    </option>
                                                    <option <?=$user['status_2fa'] == 0 ? 'selected' : '';?> value="0">
                                                        OFF</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Chiết khấu giảm giá (*)</label>
                                                <input type="text" class="form-control" value="<?=$user['chietkhau'];?>"
                                                    name="chietkhau">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Level (*)</label>
                                                <select class="form-control select2bs4" name="level">
                                                    <option value="admin"
                                                        <?=$user['level'] == 'admin' ? 'selected' : '';?>>Admin
                                                    </option>
                                                    <option value="ctv" <?=$user['level'] == 'ctv' ? 'selected' : '';?>>
                                                        Cộng tác viên
                                                    </option>
                                                    <option value="member"
                                                        <?=$user['level'] == 'member' ? 'selected' : '';?>>Member
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cộng tác viên được phép đăng acc vào danh mục</label>
                                                <select class="form-control select2bs4" name="group[]" multiple>
                                                    <?php 
                                                    // Phân tách chuỗi thành mảng các giá trị
                                                    $selected_roles = explode(',', $user['role']);
                                                    foreach($SIEUTHICODE->get_list("SELECT * FROM `groups` WHERE `display` = 1") as $group):
                                                        $detail = json_decode($group['detail'], true);
                                                        // Kiểm tra xem ID có trong danh sách cần chọn không
                                                        $selected = in_array($group['id'], $selected_roles) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?=$group['id']?>" <?=$selected?>>
                                                        <?=$detail['name_product']?></option>
                                                    <?php endforeach;?>
                                                </select>


                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tối đa số tiền acc CTV được phép đăng</label>
                                                <input type="number" class="form-control" value="<?=$user['maxprice'];?>" name="maxprice">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Banned (*)</label>
                                                    <select class="form-control select2bs4" name="banned">
                                                        <option <?=$user['banned'] == 1 ? 'selected' : '';?> value="1">
                                                            Banned</option>
                                                        <option <?=$user['banned'] == 0 ? 'selected' : '';?> value="0">
                                                            Live
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Money</label>
                                                <input type="text" class="form-control"
                                                    value="<?=format_cash($user['money']);?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Total Money</label>
                                                <input type="text" class="form-control"
                                                    value="<?=format_cash($user['total_money']);?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Used Money</label>
                                                <input type="text" class="form-control"
                                                    value="<?=format_cash($user['total_money']-$user['money']);?>"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>IP Login</label>
                                                <input type="text" class="form-control" value="<?=$user['ip'];?>"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Device Login</label>
                                                <input type="text" class="form-control" value="<?=$user['device'];?>"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Login</label>
                                                <input type="text" class="form-control"
                                                    value="<?=$user['createdate'];?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Login</label>
                                                <input type="text" class="form-control"
                                                    value="<?=date('H:i:s d-m-Y',$user['time']);?>" readonly>
                                            </div>
                                        </div>
                                    </div><br>
                                </div>
                                <div class="card-footer clearfix">
                                    <button name="btnSaveUser" class="btn btn-info btn-icon-left m-b-10"
                                        type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-money-bill-alt mr-1"></i>
                                CỘNG TIỀN
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
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Số tiền cộng</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="value" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Ghi chú</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <textarea class="form-control" name="ghichu" rows="3"
                                                placeholder="Nhập ghi chú cộng tiền nếu có"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <button name="btnCongTien" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-paper-plane mr-1"></i>Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-money-bill-alt mr-1"></i>
                                TRỪ TIỀN
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
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Số tiền trừ</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="value" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Ghi chú</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <textarea class="form-control" name="ghichu" rows="3"
                                                placeholder="Nhập ghi chú trừ tiền nếu có"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <button name="btnTruTien" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-paper-plane mr-1"></i>Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DÒNG TIỀN</h3>
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
                                            <th>STT</th>
                                            <th>SỐ TIỀN TRƯỚC</th>
                                            <th>SỐ TIỀN THAY ĐỔI</th>
                                            <th>SỐ TIỀN HIỆN TẠI</th>
                                            <th>THỜI GIAN</th>
                                            <th>NỘI DUNG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach($SIEUTHICODE->get_list(" SELECT * FROM `dongtien` WHERE `username` = '".$user['username']."' ORDER BY id DESC ") as $values){
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=format_cash($values['sotientruoc']);?></td>
                                            <td><?=format_cash($values['sotienthaydoi']);?></td>
                                            <td><?=format_cash($values['sotiensau']);?></td>
                                            <td><span class="badge badge-dark px-3"><?=$values['thoigian'];?></span>
                                            </td>
                                            <td><?=$values['noidung'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>SỐ TIỀN TRƯỚC</th>
                                            <th>SỐ TIỀN THAY ĐỔI</th>
                                            <th>SỐ TIỀN HIỆN TẠI</th>
                                            <th>THỜI GIAN</th>
                                            <th>NỘI DUNG</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">LỊCH SỬ HOẠT ĐỘNG</h3>
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
                                            <th>STT</th>
                                            <th>HÀNH ĐỘNG</th>
                                            <th>IP</th>
                                            <th>THIẾT BỊ</th>
                                            <th>THỜI GIAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach($SIEUTHICODE->get_list(" SELECT * FROM `logs` WHERE `user_id` = '".$user['id']."' ORDER BY id DESC ") as $row){
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$row['action'];?></td>
                                            <td><?=$row['ip'];?></td>
                                            <td><?=$row['device'];?></td>
                                            <td><span class="badge badge-dark px-3"><?=$row['create_date'];?></span>
                                            </td>
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
    </section>
</div>



<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $("#datatable1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>






<?php 
    require_once("../../public/admin/Footer.php");
?>