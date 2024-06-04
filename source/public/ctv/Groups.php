<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUẢN LÝ NHÓM | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>

<?php
if(isset($_GET['id']) && $getUser['level'] == 'ctv')
{
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `category` WHERE `id` = '".Anti_xss($_GET['id'])."' AND `display`='1' ");
    if(!$row)
    {
        admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 500);
    }
}
else
{
    admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 0);
}
?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nhóm chuyên mục <?=$row['title'];?></h1>
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
                            <h3 class="card-title">DANH SÁCH NHÓM</h3>
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
                                            <th>ẢNH</th>
                                            <th>TÊN NHÓM</th>
                                            <th>GIÁ TRỊ</th>
                                            <th>HIỂN THỊ</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach($SIEUTHICODE->get_list(" SELECT * FROM `groups` WHERE `category` = '".Anti_xss($_GET['id'])."'  ORDER BY id DESC ") as $row){
                                        $detail = json_decode($row['detail'],true);
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td width="10%"><img width="100%" src="<?=BASE_URL($detail['thumb']);?>" /></td>
                                            <td><?=$detail['name_product'];?></td>
                                            <td><?=format_cash($SIEUTHICODE->get_row(" SELECT SUM(`money`) FROM `accounts` WHERE `groups` = '".$row['id']."' AND `username_post` ='".$getUser['username']."' ")['SUM(`money`)'] ?? 0);?>
                                            </td>
                                            <td><?=display($row['display']);?></td>
                                            <td>
                                            
                                                <a type="button"
                                                    href="<?=BASE_URL('Ctv/Accounts/');?><?=$row['id'];?>"
                                                    class="btn btn-dark"><i class="fas fa-file-medical"></i>
                                                    <span>DANH SÁCH ACCOUNT</span></a>
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
        <!-- /.row -->
    </section>
    <!-- /.content -->
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
    $("#datatable2").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>



<?php 
    require_once(__DIR__."/Footer.php");
?>