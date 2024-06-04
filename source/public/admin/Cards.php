<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
$title = 'QUẢN LÝ NẠP THẺ | ' . $SIEUTHICODE->site('tenweb');
require_once "../../public/admin/Header.php";
require_once "../../public/admin/Sidebar.php";
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nạp thẻ cào</h1>
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
                            <h3 class="card-title">LỊCH SỬ NẠP THẺ</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>USERNAME</th>
                                            <th>SERI</th>
                                            <th>PIN</th>
                                            <th>LOẠI THẺ</th>
                                            <th>MỆNH GIÁ</th>
                                            <th>THỰC NHẬN</th>
                                            <th>THỜI GIAN</th>
                                            <th>TRẠNG THÁI</th>
                                            <th>GHI CHÚ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$i = 0;
foreach ($SIEUTHICODE->get_list(" SELECT * FROM `cards` ORDER BY id DESC ") as $row) {
    ?>
                                        <tr>
                                            <td><?=$i;?> <?php $i++;?></td>
                                            <td><a
                                                    href="<?=BASE_URL('Admin/User/Edit/' . $row['user_id']);?>"><?=getRowRealtime('users', $row['user_id'], 'username');?></a>
                                            </td>
                                            <td><?=$row['seri'];?></td>
                                            <td><?=$row['pin'];?></td>
                                            <td><?=loaithe($row['loaithe']);?></td>
                                            <td><?=format_cash($row['menhgia']);?></td>
                                            <td><?=format_cash($row['thucnhan']);?></td>
                                            <td><span class="badge badge-dark"><?=$row['createdate'];?></span></td>
                                            <td><?=status($row['status']);?></td>
                                            <td><?=$row['note'];?></td>
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
    // Summernote
    $('.textarea').summernote()
})
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>



<?php
require_once "./Footer.php";
?>