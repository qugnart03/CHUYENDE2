<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'TÀI KHOẢN ĐÃ BÁN | '.$SIEUTHICODE->site('tenweb');
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
$idacc = '';
$create_date = '';
$username = '';
$username_post = '';
$type_category = '';
if(!empty($_GET['idacc'])){
    $idacc = Anti_xss($_GET['idacc']);
    $where .= ' AND `id_acc` LIKE "%'.$idacc.'%" ';
}
if(!empty($_GET['username'])){
    $username = Anti_xss($_GET['username']);
    $where .= ' AND `username` LIKE "%'.$username.'%" ';
}
if(!empty($_GET['username_post'])){
    $username_post = Anti_xss($_GET['username_post']);
    $where .= ' AND `username_post` LIKE "%'.$username_post.'%" ';
}
if(!empty($_GET['type_category'])){
    $type_category = Anti_xss($_GET['type_category']);
    $where .= ' AND `type_category` LIKE "%'.$type_category.'%" ';
}
if(!empty($_GET['create_date'])){
    $create_date = Anti_xss($_GET['create_date']);
    $create_date_1 = $create_date;
    $create_date_1 = explode(' - ', $create_date_1);
    if($create_date_1[0] != $create_date_1[1]){
        $start_timestamp = strtotime($create_date_1[0] . ' 00:00:00');
        $end_timestamp = strtotime($create_date_1[1] . ' 23:59:59');
        
        $where .= " AND `created_at` >= '".$start_timestamp."' AND `created_at` <= '".$end_timestamp."' ";
    }
}



$listOrder = $SIEUTHICODE->get_list(" SELECT * FROM `history_buy` WHERE $where ORDER BY id DESC LIMIT $from,$sotin1trang ");
$dataSumary = $SIEUTHICODE->get_list("SELECT * FROM `history_buy` WHERE $where");
$totalTransactions = 0;
$totalAmount = 0;
$totalAmountReal = 0;
foreach ($dataSumary as $transaction) {
    $totalAmount += $transaction['cash'];
    $totalAmountReal += $transaction['cash'] - $transaction['cash'] * $SIEUTHICODE->site('chietkhau_banacc') / 100;
    $totalTransactions++;
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách tài khoản đã bán</h1>
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
                            <h3 class="card-title">DANH SÁCH TÀI KHOẢN ĐÃ BÁN</h3>
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
                                                <input type="text" class="form-control" value="<?=$idacc;?>"
                                                    name="idacc" placeholder="Mã số acc">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$username;?>"
                                                    name="username" placeholder="Tên người mua">
                                            </div>
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?=$username_post;?>"
                                                    name="username_post" placeholder="Tên người bán">
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
                                            <div class="input-group mb-3 col-12 col-sm-6 col-lg-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <select id="status" class="form-control datatable-input select2bs4"
                                                    name="type_category">
                                                    <option value="" selected="selected">-- Tất cả danh mục --
                                                    </option>
                                                    <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `groups` WHERE `display`= '1'") as $groups):
                                                    $groups_detail = json_decode($groups['detail'],true);
                                                    ?>
                                                    <option value="<?=$groups['type_category']?>" <?=$type_category = $groups['type_category'] ? 'selected':''?>><?=$groups_detail['name_product']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <button type="submit" name="submit" value="filter"
                                                    class="btn btn-info"><i class="fa fa-search"></i>
                                                    Tìm kiếm
                                                </button>
                                                <a class="btn btn-danger" href="/Admin/Account-Sold"><i
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
                                    Tổng số nick đã bán: <b id="total_record"><?=format_cash($totalTransactions)?></b> -
                                    Doanh thu (Giá gốc): <b id="total_price"><?=format_cash($totalAmount)?></b> - Doanh
                                    thu của CTV (Được hưởng): <b id="total_price"><?=format_cash($totalAmountReal)?></b>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ID Tài Khoản</th>
                                            <th>Loại Tài Khoản</th>
                                            <th>Tài khoản</th>
                                            <th>Người Mua</th>
                                            <th>Người Bán</th>
                                            <th>Giá</th>
                                            <th>Thời Gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach ($listOrder as $row){
                                        $detail = json_decode($row['detail'], true);
                                        $arr_detail = $detail['data'];
                                    ?>
                                        <tr>
                                            <td><?=$row['id'];?></td>
                                            <td>#<?=$row['id_acc'];?></td>

                                            <td><?=$detail['name_product']?></td>
                                            <td><?=decodecryptData($arr_detail[0]['taikhoan'])?></td>
                                            <td><b style="color:green"><?=$row['username'];?></b></td>
                                            <td><b style="color:blue"><?=$row['username_post'];?></b></td>

                                            <td><b style="color:red"><?=format_cash($row['cash']);?></b></td>
                                            <td><?=date('H:i d-m-Y',$row['created_at']);?></td>
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
                                $total = $SIEUTHICODE->num_rows(" SELECT * FROM `history_buy` WHERE $where ORDER BY id DESC ");
                                if ($total > $sotin1trang){echo '<center>' . pagination(BASE_URL("Ctv/Account-Sold?idacc=$idacc&username=$username&username_post=$username_post&type_category=$type_category&create_date=$create_date&"), $from, $total, $sotin1trang) . '</center>';}?>
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
</script>
<?php 
    require_once(__DIR__."/Footer.php");
?>