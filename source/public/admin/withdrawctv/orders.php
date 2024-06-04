<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
$title = 'Đơn rút tiền CTV | ' . $SIEUTHICODE->site('tenweb');
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
$create_date = '';
$stk = '';
$username = '';
$banks = '';

if(!empty($_GET['username'])){
    $username = Anti_xss($_GET['username']);
    $dataUser = $SIEUTHICODE->get_row("SELECT * FROM `users` WHERE `username` = '$username'");
    $where .= ' AND `user_id` = "' . $dataUser['id'] . '" ';
}
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



$listOrder = $SIEUTHICODE->get_list(" SELECT * FROM `withdraw_ctv` WHERE $where ORDER BY id DESC LIMIT $from,$sotin1trang ");
$dataSumary = $SIEUTHICODE->get_list("SELECT * FROM `withdraw_ctv` WHERE $where");
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
                    <h1>Đơn rút tiền CTV</h1>
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
                                                <input type="text" class="form-control" value="<?=$username;?>" name="username"
                                                    placeholder="Tài khoản CTV">
                                            </div>
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
                                                <a class="btn btn-danger" href="/Admin/WithdrawCTV/Orders"><i
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
                                            <th>Thao tác</th>
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
                                            <td><button class="btn btn-info"
                                                    onclick="show(<?=$row['id'];?>,<?=$row['status'];?>,`<?=$row['reason'];?>`)"><i
                                                        class="fa fa-eye"></i></button></td>
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
                                $total = $SIEUTHICODE->num_rows(" SELECT * FROM `withdraw_ctv` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(BASE_URL("Admin/WithdrawCTV/Orders?&username=$username&stk=$stk&create_date=$create_date&bank=$banks&"), $from, $total, $sotin1trang) . '</center>';}?>
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

<div class="modal fade" id="modal-diamond">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-form-label">Ghi chú</label>
                    <textarea class="form-control" id="note"></textarea>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-form-label">Trạng thái</label>
                    <input type="hidden" id="iddiamond">
                    <select class="form-control" id="status">
                        <option value="0">Chờ duyệt</option>
                        <option value="2">Đã thanh toán</option>
                        <option value="1">Đã hủy</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="change" onclick="change()">Lưu ngay</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>

            </div>
        </div>

    </div>
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

function show(id, status, note) {
    $('#iddiamond').val(id);
    $('#note').val(note);
    var selectElement = document.getElementById("status");
    console.log(selectElement);
    var options = selectElement.options;
    for (var i = 0; i < options.length; i++) {
        if (options[i].value == status) {
            options[i].selected = true;
        }
    }
    $('#modal-diamond').modal('show');
}

function change() {
    $('#change').html('Đang xử lý...').prop('disabled',
        true);
    $.ajax({
        url: "/Model/Admin/UpdateWithdraw",
        method: "POST",
        dataType: "JSON",
        data: {
            id: $("#iddiamond").val(),
            note: $("#note").val(),
            status: $("#status").val()
        },
        success: function(response) {
            if (response.status == 'success') {
                Toast(response.status, response.msg);
                setTimeout(function() {
                    window.location = '/Admin/WithdrawCTV/Orders';
                }, 1000);
            } else {
                Toast(response.status, response.msg)
            }
            $('#change').html(
                    'Lưu ngay')
                .prop('disabled', false);
        }
    });
}
</script>
<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Footer.php';
?>