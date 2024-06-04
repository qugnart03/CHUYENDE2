<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
$title = 'Thống kê nạp Ví - ATM | ' . $SIEUTHICODE->site('tenweb');
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
$telco = '';
$amount = '';
$create_date = '';
$username = '';
$pin = '';
$serial = '';

if(!empty($_GET['transid'])){
    $transid = Anti_xss($_GET['transid']);
    $where .= ' AND `tid` LIKE "%'.$transid.'%" ';
}
if(!empty($_GET['username'])){
    $username = Anti_xss($_GET['username']);
    $where .= ' AND `username` =  "'.$username.'" ';
}

if(!empty($_GET['create_date'])){
    $create_date = Anti_xss($_GET['create_date']);
    $create_date_1 = $create_date;
    $create_date_1 = explode(' - ', $create_date_1);
    if($create_date_1[0] != $create_date_1[1]){
        $create_date_1 = [$create_date_1[0].' 00:00:00', $create_date_1[1].' 23:59:59'];
        $where .= " AND `time` >= '".$create_date_1[0]."' AND `time` <= '".$create_date_1[1]."' ";
    }
}


$listOrder = $SIEUTHICODE->get_list(" SELECT * FROM `bank_auto` WHERE $where ORDER BY id DESC LIMIT $from,$sotin1trang ");
$dataSumary = $SIEUTHICODE->get_list("SELECT * FROM `bank_auto` WHERE $where");
$totalTransactions = 0;
$totalAmount = 0;
foreach ($dataSumary as $transaction) {
    $totalAmount += $transaction['amount'];
    $totalTransactions++;
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thống kê nạp Ví - ATM</h1>
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
                            <h3 class="card-title">Thống kê nạp Ví - ATM</h3>
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
                                                <a class="btn btn-danger" href="/Admin/Bank/Transaction"><i
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
                                    Số giao dịch: <b id="total_record"><?=format_cash($totalTransactions)?></b> - Tổng
                                    tiền: <b id="total_price"><?=format_cash($totalAmount)?></b>
                                </div>

                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Thời gian</th>
                                            <th>Mã giao dịch</th>
                                            <th>Khách hàng</th>
                                            <th>Số tiền</th>
                                            <th>Thực nhận</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach ($listOrder as $row) {?>
                                        <tr>
                                            <td>
                                                <?=$row['time'];?>
                                            </td>
                                            <td><?=$row['tid'];?></td>
                                            <td>
                                                <ul>
                                                    <li>Username: <b><a href="/"></a>
                                                            (<?=$row['username']?>)</b>
                                                    </li>

                                                </ul>
                                            </td>
                                           
                                            <td><?=format_cash($row['amount'])?></td>
                                            <td><?=format_cash($row['cusum_balance'])?></td>
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
                                $total = $SIEUTHICODE->num_rows(" SELECT * FROM `bank_auto` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(BASE_URL("Admin/Bank/Transaction?transid=$transid&username=$username&create_date=$create_date&"), $from, $total, $sotin1trang) . '</center>';}?>
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