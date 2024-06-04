<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Lịch sử rút kim cương / quân huy | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lịch sử rút kim cương / quân huy</h1>
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
                            <h3 class="card-title">LỊCH SỬ RÚT</h3>
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
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Chi tiết</th>
                                            <th>Số tiền</th>
                                            <th>Số K/C</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach($SIEUTHICODE->get_list(" SELECT * FROM `withdraw` ORDER BY id DESC ") as $row){
                                        $detail = json_decode($row['detail'],true);
                                    ?>
                                        <tr>
                                            <td><?=$row['id'];?></td>
                                            <td><?=getRowRealtime('users',$row['user_id'],'username');?></td>
                                            <td><?=decodecryptData($detail['datagame']);?></td>
                                            <td><?=$detail['amount'];?></td>
                                            <td><?=$detail['diamond'];?></td>
                                            <td><?=his_admin($row['status'])?></td>
                                            <td><span
                                                    class="badge badge-dark"><?=date('H:i:s d-m-Y',$row['create_date']);?></span>
                                            </td>
                                            <td><button class="btn btn-info" onclick="show(<?=$row['id'];?>,<?=$row['status'];?>)"><i
                                                        class="fa fa-eye"></i></button></td>
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
                    <label for="inputEmail3" class="col-form-label">Trạng thái</label>
                    <input type="hidden" id="iddiamond">
                    <select class="form-control" id="status">
                        <option value="1">Chờ duyệt</option>
                        <option value="2">Thành công</option>
                        <option value="3">Thất bại</option>
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
function show(id,status) {
    $('#iddiamond').val(id);
    var selectElement = document.getElementById("status");
    var options = selectElement.options;
    for (var i = 0; i < options.length; i++) {
        if (options[i].value == status) {
            options[i].selected = true;
        }
    }
    $('#modal-diamond').modal('show');
}
function change(){
    $('#change').html('Đang xử lý...').prop('disabled',
        true);
    $.ajax({
        url: "/Model/Admin/ChangeHistoryDiamond",
        method: "POST",
        dataType:"JSON",
        data: {
            id: $("#iddiamond").val(),
            status: $("#status").val()
        },
        success: function(response) {
            if (response.status == 'success') {
                Toast(response.status,response.msg);
                setTimeout(function () {
                            window.location = '/Admin/History/Diamond';
                        }, 1000);
            }else {
                Toast(response.status,response.msg)
            }
            $('#change').html(
                    'Lưu ngay')
                .prop('disabled', false);
        }
    });
}
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
    require_once("./Footer.php");
?>