<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUẢN LÝ THÀNH VIÊN | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
?>
<?php

$sotin1trang = 10;
if(isset($_GET['page'])){
    $page = Anti_xss(intval($_GET['page']));
}
else{
    $page = 1;
}

$from = ($page - 1) * $sotin1trang;
$where = ' `id` > 0 ';
$order_by = ' ORDER BY id DESC ';
$username = '';
$email = '';
$status = '';
$money = '';
$ck = '';
$ip = '';
$userid = '';
$total_money = '';

if(!empty($_GET['userid'])){
    $id = Anti_xss($_GET['userid']);
    $where .= ' AND `id` = '.$id.' ';
}
if(!empty($_GET['username'])){
    $username = Anti_xss($_GET['username']);
    $where .= ' AND `username` LIKE "%'.$username.'%" ';
}

if(!empty($_GET['email'])){
    $email = Anti_xss($_GET['email']);
    $where .= ' AND `email` LIKE "%'.$email.'%" ';
}

if(!empty($_GET['status'])){
    $status = Anti_xss($_GET['status']);
    if($status == 1){
        $where .= ' AND `banned` = 0 ';
    }else if($status == 2){
        $where .= ' AND `banned` = 1 ';
    }
}

if(!empty($_GET['money'])){
    $money = Anti_xss($_GET['money']);
    if($money == 1){
        $order_by = ' ORDER BY `money` ASC ';
    }else if($money == 2){
        $order_by = ' ORDER BY `money` DESC ';
    }
}
if(!empty($_GET['ck'])){
    $ck = Anti_xss($_GET['ck']);
    if($ck == 1){
        $order_by = ' ORDER BY `chietkhau` ASC ';
    }else if($ck == 2){
        $order_by = ' ORDER BY `chietkhau` DESC ';
    }
}
if(!empty($_GET['total_money'])){
    $total_money = Anti_xss($_GET['total_money']);
    if($total_money == 1){
        $order_by = ' ORDER BY `total_money` ASC ';
    }else if($total_money == 2){
        $order_by = ' ORDER BY `total_money` DESC ';
    }
}

if(!empty($_GET['ip'])){
    $ip = Anti_xss($_GET['ip']);
    $where .= ' AND `ip` LIKE "%'.$ip.'%" ';
}

$listUsers = $SIEUTHICODE->get_list("SELECT * FROM `users` WHERE $where $order_by LIMIT $from,$sotin1trang ");
$dataSumary = $SIEUTHICODE->get_list("SELECT * FROM `users` WHERE $where");

$totalTransactions = 0;
$totalAmount = 0;
$totalBanned = 0;
$statusAdmin = 0;
foreach ($dataSumary as $transaction) {
    $totalAmount += $transaction['money'];
    $totalTransactions++;
    if ($transaction['banned'] == 1) {
        $totalBanned++;
    }
    if ($transaction['level'] == 'admin') {
        $statusAdmin++;
    }
}
?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý thành viên</h1>
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
                            <h3 class="card-title">DANH SÁCH THÀNH VIÊN</h3>
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
                            <div class="row mb-2">
                                <div class="col-sm-12 mb-3">
                                    <form action="" name="formSearch" method="GET">
                                        <div class="row">
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$userid;?>"
                                                    name="userid" placeholder="ID Khách hàng">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$username;?>"
                                                    name="username" placeholder="Tài khoản khách hàng">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="email" class="form-control" value="<?=$email;?>"
                                                    name="email" placeholder="Email khách hàng">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$ip;?>" name="ip"
                                                    placeholder="Địa chỉ IP">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <select name="status" class="form-control select2bs4">
                                                    <option value="">Trạng thái
                                                    </option>
                                                    <option <?=$status == 2 ? 'selected' : '';?> value="2">Banned
                                                    </option>
                                                    <option <?=$status == 1 ? 'selected' : '';?> value="1">Active
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <select name="money" class="form-control select2bs4">
                                                    <option value="">Số dư khả dụng
                                                    </option>
                                                    <option <?=$money == 1 ? 'selected' : '';?> value="1">Tăng dần
                                                    </option>
                                                    <option <?=$money == 2 ? 'selected' : '';?> value="2">Giảm dần
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <select name="total_money" class="form-control select2bs4">
                                                    <option value="">Tổng nạp
                                                    </option>
                                                    <option <?=$total_money == 1 ? 'selected' : '';?> value="1">Tăng dần
                                                    </option>
                                                    <option <?=$total_money == 2 ? 'selected' : '';?> value="2">Giảm dần
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <select name="ck" class="form-control select2bs4">
                                                    <option value="">Chiết khấu giảm giá
                                                    </option>
                                                    <option <?=$ck == 1 ? 'selected' : '';?> value="1">Tăng dần
                                                    </option>
                                                    <option <?=$ck == 2 ? 'selected' : '';?> value="2">Giảm dần
                                                    </option>
                                                </select>
                                            </div>


                                            <div class="col-sm-4 mb-2">
                                                <button type="submit" name="submit" value="filter"
                                                    class="btn btn-info"><i class="fa fa-search"></i>
                                                    Tìm kiếm
                                                </button>
                                                <a class="btn btn-danger" href="/Admin/Users"><i
                                                        class="fa fa-trash"></i>
                                                    Reset
                                                </a>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Tổng thành viên: <b id="total_record"><?=format_cash($totalTransactions)?></b> -
                                    Tổng tiền: <b id="total_price"><?=format_cash($totalAmount)?></b>
                                </div>
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Tài khoản bị khóa: <b><?=format_cash($totalBanned)?></b>
                                </div>
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Tài khoản Admin: <b><?=format_cash($statusAdmin)?></b>
                                </div>

                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tài khoản</th>
                                            <th>Ví</th>
                                            <th>Bảo mật</th>
                                            <th>Admin</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($listUsers as $row) { ?>
                                        <tr>

                                            <td>
                                                <ul>
                                                    <li>Tên đăng nhập: <b><?=$row['username'];?></b>
                                                        [ID <b><?=$row['id'];?></b>]</li>
                                                    <li>Địa chỉ Email: <b style="color:green"><?=$row['email'];?></b>
                                                    </li>

                                                    <li>Banned: <?=display_banned($row['banned']);?></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Số dư khả dụng: <b
                                                            style="color:blue"><?=format_cash($row['money']);?></b>
                                                    </li>
                                                    <li>Tổng số tiền nạp: <b
                                                            style="color:red"><?=format_cash($row['total_money']);?></b>
                                                    </li>
                                                    <li>Chiết khấu giảm giá: <b><?=$row['chietkhau'];?>%</b></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>IP: <b><?=$row['ip'];?></b></li>

                                                    <li>Ngày tham gia: <b><?=$row['createdate'];?></b></li>
                                                    <li>Hoạt động gần đây: <b><?=$row['time'];?></b></li>
                                                </ul>
                                            </td>
                                            <td><?=($row['level']);?></td>

                                            <td>
                                                <a aria-label="" href="<?=BASE_URL('Admin/User/Edit/'.$row['id']);?>"
                                                    style="color:white;"
                                                    class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </a>
                                                <button style="color:white;" onclick="delete_id(<?=$row['id'];?>)"
                                                    class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                </button>
                                                <a aria-label="" href="<?=BASE_URL('Admin/Login-User/'.$row['id']);?>"
                                                    style="color:white;" target="_blank"
                                                    class="btn btn-primary btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-sign-in mr-1"></i><span class="">Login</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <?php
                                $total = $SIEUTHICODE->num_rows(" SELECT * FROM `users` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(BASE_URL("Admin/Users?username=$username&userid=$userid&email=$email&status=$status&money=$money&ck=$ck&ip=$ip&total_money=$total_money&"), $from, $total, $sotin1trang) . '</center>';}?>
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
            url: '/Model/Admin/DeleteUser',
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
    require_once("../../public/admin/Footer.php");
?>