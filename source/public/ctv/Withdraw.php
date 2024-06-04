<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Rút tiền CTV | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
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
$create_date = '';
$stk = '';
$banks = '';

if(!empty($_GET['stk'])){
    $stk = Anti_xss($_GET['stk']);
    $where .= ' AND `stk` LIKE "%'.$stk.'%" ';
}
if(!empty($_GET['bank'])){
    $banks = Anti_xss($_GET['bank']);
    $where .= ' AND `bank` LIKE "%'.$banks.'%" ';
}
if(!empty($_GET['create_date'])){
    $create_date = Anti_xss($_GET['create_date']);
    $create_date_1 = $create_date;
    $create_date_1 = explode(' - ', $create_date_1);
    if($create_date_1[0] != $create_date_1[1]){
        $create_date_1 = [$create_date_1[0].' 00:00:00', $create_date_1[1].' 23:59:59'];
        $where .= " AND `create_gettime` >= '".$create_date_1[0]."' AND `create_gettime` <= '".$create_date_1[1]."' ";
    }
}



$listOrder = $SIEUTHICODE->get_list(" SELECT * FROM `withdraw_ctv` WHERE $where AND `user_id` = '".$getUser['id']."' ORDER BY id DESC LIMIT $from,$sotin1trang ");
$dataSumary = $SIEUTHICODE->get_list("SELECT * FROM `withdraw_ctv` WHERE $where AND `user_id` = '".$getUser['id']."'");
$totalTransactions = 0;
$totalAmount = 0;
$status0Transactions = 0;
$status2Transactions = 0;
$status3Transactions = 0;
foreach ($dataSumary as $transaction) {
    $totalAmount += $transaction['amount'];
    $totalTransactions++;
    if ($transaction['status'] == '0') {
        $status0Transactions++;
    }
    if ($transaction['status'] == '2') {
        $status2Transactions++;
    }
    if ($transaction['status'] == '1') {
        $status3Transactions++;
    }
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rút tiền CTV</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <b>TẠO YÊU CẦU RÚT TIỀN</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Ngân hàng:</label>
                                <div class="col-lg-8 fv-row">
                                    <select class="form-control select2bs4" id="bank">
                                        <option value="">-- Chọn ngân hàng cần rút --</option>
                                        <?php foreach(explode(PHP_EOL,$SIEUTHICODE->site('listbank_ctv')) as $bank):?>
                                        <option value="<?=$bank?>"><?=$bank?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Số tài khoản:</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="stk" class="form-control"
                                        placeholder="Nhập số tài khoản cần rút">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Chủ tài khoản:</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="name" class="form-control"
                                        placeholder="Nhập tên chủ tài khoản">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Số tiền cần rút:</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="number" id="amount" class="form-control"
                                        placeholder="Nhập số dư cần rút">

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 fv-row text-center">
                                    <button type="button" id="btnRutTien" class="btn btn-danger btn-sm"><i
                                            class="fas fa-money-check-alt"></i>
                                        RÚT NGAY</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="callout callout-info">
                        <h5>Lưu ý</h5>
                        <?=$SIEUTHICODE->site('notice_withdraw_ctv')?>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-5">
                                <b>THÔNG TIN CHI TIẾT</b>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4 align-self-center" for="email">Email:</label>
                                <div class="col-sm-8">
                                    <b><?=$getUser['email']?></b>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4 align-self-center" for="email">Số dư khả
                                    dụng:</label>
                                <div class="col-sm-8">
                                    <b style="color: blue;"><?=format_cash($getUser['money'])?>đ</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">LỊCH SỬ RÚT TIỀN</h3>
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
                                                <input type="text" class="form-control" value="<?=$stk;?>" name="stk"
                                                    placeholder="Số tài khoản">
                                            </div>

                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$banks;?>" name="bank"
                                                    placeholder="Ngân hàng">
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
                                                <a class="btn btn-danger" href="/Ctv/Withdraw"><i
                                                        class="fa fa-trash"></i>
                                                    Reset
                                                </a>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-12 m--margin-bottom-10-tablet-and-mobile" style="font-size: 14px ">
                                    Tổng số đơn đã rút: <b id="total_record"><?=format_cash($totalTransactions)?></b> -
                                    Đang xử lý: <b><?=format_cash($status0Transactions ?? 0)?></b> - Đã hủy:
                                    <b><?=format_cash($status1Transactions ?? 0)?></b> - Đã thanh toán:
                                    <b><?=format_cash($status3Transactions ?? 0)?></b>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Mã giao dịch</th>
                                            <th>CTV</th>
                                            <th>Thông tin</th>
                                            <th>Số tiền</th>
                                            <th>Nội dung</th>
                                            <th>Trạng thái</th>
                                            <th>Thời Gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach ($listOrder as $row){
                                    ?>
                                        <tr>
                                            <td><?=$row['trans_id'];?></td>
                                            <td><?=getRowRealTime('users',$row['user_id'],'username');?></td>

                                            <td>
                                                <ul>
                                                    <li>Ngân hàng: <?=$row['bank']?></li>
                                                    <li>Số tài khoản: <?=$row['stk']?></li>
                                                    <li>Chủ tài khoản: <?=$row['name']?></li>
                                                </ul>
                                            </td>
                                            <td><b style="color:red"><?=format_cash($row['amount']);?></b></td>
                                            <td><textarea class="form-control"><?=$row['reason'];?></textarea></td>
                                            <td><?=status_withdraw($row['status']);?></td>
                                            <td><?=$row['update_gettime'];?></td>
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
                                $total = $SIEUTHICODE->num_rows(" SELECT * FROM `withdraw_ctv` WHERE $where AND `user_id` = '".$getUser['id']."' ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(BASE_URL("Ctv/Withdraw?stk=$stk&create_date=$create_date&bank=$banks&"), $from, $total, $sotin1trang) . '</center>';}?>
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
$("#btnRutTien").on("click", function() {
    $('#btnRutTien').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',
        true);
    $.ajax({
        url: "/Model/Withdraw/Ctv",
        method: "POST",
        dataType: "JSON",
        data: {
            bank: $('#bank').val(),
            stk: $('#stk').val(),
            name: $('#name').val(),
            amount: $('#amount').val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                Toast(respone.status, respone.msg);
            } else {
                Toast(respone.status, respone.msg);
            }
            $('#btnRutTien').html('<i class="fas fa-money-check-alt"></i> RÚT NGAY')
                .prop('disabled', false);
        }
    })
});
</script>
<?php 
    require_once(__DIR__."/Footer.php");
?>