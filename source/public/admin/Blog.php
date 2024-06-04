<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
$title = 'Bài Viết | ' . $SIEUTHICODE->site('tenweb');
require_once __DIR__ . "/Header.php";
require_once __DIR__ . "/Sidebar.php";
?>
<div class="content-wrapper">
    <div id="thongbao"></div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bài viết</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                </section>
                <section class="col-lg-6 text-right">
                    <div class="mb-3">
                        <a class="btn btn-primary btn-icon-left m-b-10" href="<?=BASE_URL('Admin/Blog-Add');?>"
                            type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm bài viết mới</a>
                    </div>
                </section>


                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa-brands fa-blogger mr-1"></i>
                                DANH SÁCH BÀI VIẾT
                            </h3>
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
                            <table id="datatable1" class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 5px;">#</th>
                                        <th>Vị trí</th>
                                        <th>Tiêu đề</th>
                                        <th>Hình ảnh</th>
                                        <th>Lượt xem</th>
                                        <th>Trạng thái</th>
                                        <th style="width: 20%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;foreach ($SIEUTHICODE->get_list("SELECT * FROM `blogs` ") as $row) {?>
                                    <tr>
                                        <td><?=$row['id'];?></td>
                                        <td><?=$row['stt'];?></td>
                                        <td><?=$row['title'];?></td>
                                        <td><img src="<?=base_url($row['image']);?>" width="100px"></td>
                                        <td><?=$row['view'];?> lượt xem</td>
                                        <td><?=display_status_product($row['display']);?></td>
                                        <td>
                                            <a aria-label="" href="<?=base_url('Admin/Blog/Edit/' . $row['id']);?>"
                                                style="color:white;" class="btn btn-info btn-sm btn-icon-left m-b-10"
                                                type="button">
                                                <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                            </a>
                                            <button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>')"
                                                class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>



<script type="text/javascript">
function RemoveRow(id) {
    Swal.fire({
        title: 'Xóa tệp',
        text: "Bạn có đồng ý xóa bài viết này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa ngay',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Model/Admin/DeleteBlog",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Toast(response.status, response.msg);
                        setTimeout(function() {
                            window.location = '/Admin/Blog';
                        }, 1000);
                    } else {
                        Toast(response.status, response.msg);
                    }
                }
            });
        }
    })
};
</script>

<script>
$(function() {
    $("#datatable1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>



<?php
require_once __DIR__ . "/Footer.php";
?>