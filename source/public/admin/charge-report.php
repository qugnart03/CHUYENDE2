<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
$title = 'Thống kê nạp thẻ | ' . $SIEUTHICODE->site('tenweb');
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
    $where .= ' AND `code` LIKE "%'.$transid.'%" ';
}
if(!empty($_GET['username'])){
    $username = Anti_xss($_GET['username']);
    if($idUser = $SIEUTHICODE->get_row(" SELECT * FROM `users` WHERE `username` = '$username' ")){
        $where .= ' AND `user_id` =  "'.$idUser['id'].'" ';
    }else{
        $where .= ' AND `user_id` =  "" ';
    }
}

if(!empty($_GET['telco'])){
    $telco = Anti_xss($_GET['telco']);
    $where .= ' AND `loaithe` = "'.$telco.'" ';
}
if(!empty($_GET['amount'])){
    $amount = Anti_xss($_GET['amount']);
    $where .= ' AND `menhgia` = "'.$amount.'" ';
}
if(!empty($_GET['pin'])){
    $pin = Anti_xss($_GET['pin']);
    $where .= ' AND `pin` = "'.$pin.'" ';
}
if(!empty($_GET['serial'])){
    $serial = Anti_xss($_GET['serial']);
    $where .= ' AND `seri` = "'.$serial.'" ';
}
if(!empty($_GET['create_date'])){
    $create_date = Anti_xss($_GET['create_date']);
    $create_date_1 = $create_date;
    $create_date_1 = explode(' - ', $create_date_1);
    if($create_date_1[0] != $create_date_1[1]){
        $create_date_1 = [$create_date_1[0].' 00:00:00', $create_date_1[1].' 23:59:59'];
        $where .= " AND `createdate` >= '".$create_date_1[0]."' AND `createdate` <= '".$create_date_1[1]."' ";
    }
}


$listOrder = $SIEUTHICODE->get_list(" SELECT * FROM `cards` WHERE $where ORDER BY id DESC LIMIT $from,$sotin1trang ");
$dataSumary = $SIEUTHICODE->get_list("SELECT * FROM `cards` WHERE $where");
$totalTransactions = 0;
$totalAmount = 0;
$status0Transactions = 0;
$status2Transactions = 0;
$status3Transactions = 0;
foreach ($dataSumary as $transaction) {
    $totalAmount += $transaction['thucnhan'];
    $totalTransactions++;
    if ($transaction['status'] == 'xuly') {
        $status0Transactions++;
    }
    if ($transaction['status'] == 'thanhcong') {
        $status2Transactions++;
    }
    if ($transaction['status'] == 'thatbai') {
        $status3Transactions++;
    }
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thống kê nạp thẻ</h1>
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
                            <h3 class="card-title">Thống kê nạp thẻ</h3>
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
                                                <input type="text" class="form-control" value="<?=$pin;?>"
                                                    name="pin" placeholder="Mã thẻ">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$serial;?>"
                                                    name="serial" placeholder="serial">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <select id="status" class="form-control datatable-input select2bs4"
                                                    name="status">
                                                    <option value="" selected="selected">-- Tất cả trạng thái --
                                                    </option>
                                                    <option value="1">Thẻ đúng</option>
                                                    <option value="0">Thẻ sai</option>
                                                    <option value="2">Chờ xử lý</option>

                                                </select>
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <select id="telco" class="form-control datatable-input select2bs4"
                                                    name="telco">
                                                    <option value="" selected="selected">-- Tất cả loại thẻ --</option>
                                                    <option <?=$telco == 'VIETTEL' ? 'selected' : '';?> value="VIETTEL">VIETTEL</option>
                                                    <option <?=$telco == 'VIETNAMMOBILE' ? 'selected' : '';?> value="VIETNAMMOBILE">VIETNAMMOBILE</option>
                                                    <option <?=$telco == 'VINAPHONE' ? 'selected' : '';?> value="VINAPHONE">VINAPHONE</option>
                                                    <option <?=$telco == 'MOBIFONE' ? 'selected' : '';?> value="MOBIFONE">MOBIFONE</option>
                                                    <option <?=$telco == 'GARENA' ? 'selected' : '';?> value="GARENA">GARENA</option>
                                                    <option <?=$telco == 'VCOIN' ? 'selected' : '';?> value="VCOIN">VCOIN</option>
                                                    <option <?=$telco == 'GATE' ? 'selected' : '';?> value="GATE">GATE</option>
                                                    <option <?=$telco == 'ZING' ? 'selected' : '';?> value="ZING">ZING</option>
                                                    <option <?=$telco == 'VIETNAMOBILE' ? 'selected' : '';?> value="VIETNAMOBILE">VIETNAMOBILE</option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <select id="amount" class="form-control datatable-input select2bs4" name="amount">
                                                    <option value="" selected="selected">-- Tất cả mệnh giá --</option>
                                                    <option <?=$amount == '10000' ? 'selected' : '';?> value="10000">10,000</option>
                                                    <option <?=$amount == '20000' ? 'selected' : '';?> value="20000">20,000</option>
                                                    <option <?=$amount == '30000' ? 'selected' : '';?> value="30000">30,000</option>
                                                    <option <?=$amount == '50000' ? 'selected' : '';?> value="50000">50,000</option>
                                                    <option <?=$amount == '100000' ? 'selected' : '';?> value="100000">100,000</option>
                                                    <option <?=$amount == '200000' ? 'selected' : '';?> value="200000">200,000</option>
                                                    <option <?=$amount == '300000' ? 'selected' : '';?> value="300000">300,000</option>
                                                    <option <?=$amount == '500000' ? 'selected' : '';?> value="500000">500,000</option>
                                                    <option <?=$amount == '1000000' ? 'selected' : '';?> value="1000000">2,000,000</option>
                                                </select>
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
                                                <a class="btn btn-danger" href="/Admin/Charge-report"><i
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

                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Số thẻ xử lý: <b><?=format_cash($status0Transactions)?></b>
                                </div>
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Số thẻ đúng: <b><?=format_cash($status2Transactions)?></b>
                                </div>
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Số thẻ sai: <b><?=format_cash($status3Transactions)?></b>
                                </div>

                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">

                                </div>

                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Thời gian</th>
                                            <th>Khách hàng</th>
                                            <th>Mã thẻ / Serial</th>
                                            <th>Mệnh giá</th>
                                            <th>Thực nhận</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach ($listOrder as $row) {?>
                                        <tr>
                                            <td>
                                                <?=$row['createdate'];?>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Username: <b><a href="/"></a>
                                                            (<?=getRowRealtime('users',$row['user_id'],'username')?>)</b>
                                                    </li>

                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Loại thẻ: <?=loaithe($row['loaithe']);?></li>

                                                    <li>Mã thẻ: <b><?=$row['pin']?></b>
                                                    </li>
                                                    <li>Serial: <b><?=$row['seri'];?></b>
                                                    </li>

                                                </ul>
                                            </td>
                                            <td><?=format_cash($row['menhgia'])?></td>
                                            <td><?=format_cash($row['thucnhan'])?></td>
                                            <td><?=status($row['status']);?></td>


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
                                $total = $SIEUTHICODE->num_rows(" SELECT * FROM `cards` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(BASE_URL("Admin/Charge-report?transid=$transid&username=$username&telco=$telco&amount=$amount&pin=$pin&serial=$serial&create_date=$create_date&"), $from, $total, $sotin1trang) . '</center>';}?>
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