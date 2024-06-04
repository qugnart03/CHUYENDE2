<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
$title = 'Bán vàng NRO - Thống kê giao dịch | ' . $SIEUTHICODE->site('tenweb');
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Header.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Sidebar.php';
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
$transid = '';
$server = '';
$player = '';
$create_date = '';
$username = '';


if(!empty($_GET['transid'])){
    $transid = Anti_xss($_GET['transid']);
    $where .= ' AND `id` LIKE "%'.$transid.'%" ';
}
if(!empty($_GET['username'])){
    $username = Anti_xss($_GET['username']);
    if($idUser = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '$username' ")){
        $where .= ' AND `user_id` =  "'.$idUser['id'].'" ';
    }else{
        $where .= ' AND `user_id` =  "" ';
    }
}

if(!empty($_GET['server'])){
    $server = Anti_xss($_GET['server']);
    $where .= ' AND `server_nro` = "'.$server.'" ';
}
if(!empty($_GET['player'])){
    $player = Anti_xss($_GET['player']);
    $where .= ' AND `player` = "'.$player.'" ';
}
if(!empty($_GET['create_date'])){
    $create_date = Anti_xss($_GET['create_date']);
    $create_date_1 = $create_date;
    $create_date_1 = explode(' - ', $create_date_1);
    if($create_date_1[0] != $create_date_1[1]){
        $create_date_1 = [$create_date_1[0].' 00:00:00', $create_date_1[1].' 23:59:59'];
        $where .= " AND `created_at` >= '".$create_date_1[0]."' AND `created_at` <= '".$create_date_1[1]."' ";
    }
}


$listOrder = $SIEUTHICODE->get_list(" SELECT * FROM `history_coin_nro` WHERE $where ORDER BY id DESC LIMIT $from,$sotin1trang ");
$dataSumary = $SIEUTHICODE->get_list("SELECT * FROM `history_coin_nro` WHERE $where");
$totalGoldNumber = 0;
$totalGoldBar = 0;
$totalTransactions = 0;
$totalAmount = 0;
$status0Transactions = 0;
$status2Transactions = 0;
$status3Transactions = 0;
foreach ($dataSumary as $transaction) {
    $totalGoldNumber += $transaction['gold_number'];
    $totalGoldBar += $transaction['gold_bar'];
    $totalAmount += $transaction['cash'];
    $totalTransactions++;
    if ($transaction['status'] == 0) {
        $status0Transactions++;
    }
    if ($transaction['status'] == 2) {
        $status2Transactions++;
    }
    if ($transaction['status'] == 3) {
        $status3Transactions++;
    }
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bán vàng NRO - Thống kê giao dịch</h1>
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
                            <h3 class="card-title">Bán vàng NRO - Thống kê giao dịch</h3>
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
                                                <input type="text" class="form-control" value="<?=$transid;?>"
                                                    name="transid" placeholder="Mã giao dịch">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$username;?>"
                                                    name="username" placeholder="Khách hàng">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$server;?>"
                                                    name="server" placeholder="Máy chủ">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$player;?>"
                                                    name="player" placeholder="Tên nhân vật">
                                            </div>


                                            <div class="form-group col-12 col-sm-6 col-lg-3 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" name="create_date" value="<?=$create_date;?>"
                                                        class="form-control float-right" id="reservationtime">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <button type="submit" name="submit" value="filter"
                                                    class="btn btn-info"><i class="fa fa-search"></i>
                                                    Tìm kiếm
                                                </button>
                                                <a class="btn btn-danger"
                                                    href="/Admin/toolgame/nrocoin-logtransaction"><i
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
                                    Số giao dịch: <b id="total_record"><?=format_cash($totalTransactions)?></b> - Tổng tiền: <b id="total_price"><?=format_cash($totalAmount)?></b>
                                </div>
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Số vàng bán: <b><?=format_cash($totalGoldNumber)?></b>
                                </div>
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Số đơn chờ giao dịch: <b><?=format_cash($status0Transactions)?></b>
                                </div>
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Số đơn hoàn thành giao dịch: <b><?=format_cash($status2Transactions)?></b>
                                </div>
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Số đơn bị hủy giao dịch: <b><?=format_cash($status3Transactions)?></b>
                                </div>

                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">

                                </div>

                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Khách hàng</th>
                                            <th>Đơn hàng</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach ($listOrder as $row) {?>
                                        <tr>
                                            <td>
                                                <ul>
                                                    <li>Username: <b><a href="/"></a>
                                                            (<?=getRowRealtime('users',$row['user_id'],'username')?>)</b>
                                                    </li>

                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Mã giao dịch: <b>#<?=$row['id'];?></b></li>

                                                    <li>Máy chủ: <b><?=$row['server_nro']?> sao</b>
                                                    </li>
                                                    <li>Tên nhân vật: <b style="color:blue;"><?=$row['player'];?></b>
                                                    </li>
                                                    <li>Thanh toán: <b
                                                            style="color:red;"><?=format_cash($row['cash']);?>đ</b>
                                                    </li>
                                                    <li>Số vàng nhận: <b
                                                            style="color:green;"><?= format_cash($row['gold_number']); ?></b>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td><?=status_history_nro_admin($row['status']);?></td>
                                            <td><?=$row['updated_at'];?></td>
                                           
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">

                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <?php
                                $total = $SIEUTHICODE->num_rows(" SELECT * FROM `history_coin_nro` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(BASE_URL("Admin/toolgame/nrocoin-logtransaction?transid=$transid&username=$username&server=$server&player=$player&create_date=$create_date&"), $from, $total, $sotin1trang) . '</center>';}?>
                                </div>
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
            url: '/Model/Admin/BotNapCoin/Delete',
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
<script>
$(function() {
    $('#reservationtime').daterangepicker({
        locale: {
            format: 'YYYY/MM/DD/'
        }
    })

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
});
</script>


<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Footer.php';
?>