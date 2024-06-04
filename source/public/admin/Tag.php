<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Nhãn dán | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>

<?php
if (isset($_POST['addTag']) && $getUser['level'] == 'admin') {
    if ($SIEUTHICODE->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($SIEUTHICODE->get_row("SELECT * FROM `tag` WHERE `name` = '".check_string($_POST['title'])."' ")) {
        die('<script type="text/javascript">if(!alert("Tên nhãn dán này đã tồn tại trong hệ thống.")){window.history.back().location.reload();}</script>');
    }
    $url_image = '';
    if (check_img('image') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 6);
        $uploads_dir = '../../assets/storage/images/';
        $tmp_name = $_FILES['image']['tmp_name'];
        $url_listimg = "tag_".$rand.".png";
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir.$url_listimg);
        if ($addlogo) {
            $url_image = $uploads_dir.$url_listimg;
        }
    }
    $isInsert = $SIEUTHICODE->insert("tag", [
        'image'     => 'assets/storage/images/'.$url_listimg,
        'name'     => Anti_xss($_POST['name']),
        'create_date' => gettime(),
        'update_date' => gettime()
    ]);
    if ($isInsert) {
        $SIEUTHICODE->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => "Thêm nhãn dán (".Anti_xss($_POST['name']).") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('Admin/Tag').'";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div id="thongbao"></div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nhãn Dán</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h4 class="card-title">Thêm nhãn dán</h4>
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
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form-data" method="post" action="" id="form-data" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tên nhãn dán</label>
                                                <input class="form-control" name="name" type="text"
                                                    placeholder="Tên nhãn dán">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="image"
                                                            required>
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="addTag"
                                        class="btn btn-success btn-block btn-lg shadow-lg mt-3">Xác nhận</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h4 class="card-title">Danh sách</h4>
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
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Hình ảnh</th>
                                            <th>Tên</th>
                                            <th>Thời gian</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($SIEUTHICODE->num_rows("SELECT * FROM `tag` WHERE `id` != '0'") > 0) {
                                            foreach ($SIEUTHICODE->get_list("SELECT * FROM `tag` WHERE `id` != '0'") as $info) {
                                        ?>
                                        <tr>
                                            <td><?= $info['id'] ?></td>
                                            <td><img width="100" height="70" src="<?= BASE_URL($info['image']) ?>"></td>
                                            <td><?= $info['name'] ?></td>
                                            <td><?= $info['create_date'] ?></td>
                                            <td><button type="button" class="btn btn-danger"
                                                    onclick="RemoveRow('<?= $info['id'] ?>')">X</button></td>
                                        </tr>
                                        <?php }
                                        } else { ?>
                                        <tr>
                                            <td colspan="5" class="text-sm text-center">
                                                Không có dữ liệu
                                            </td>
                                        </tr>
                                        <?php } ?>
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



<script type="text/javascript">
function RemoveRow(id) {
    Swal.fire({
        title: 'Xóa nhãn dán',
        text: "Bạn có đồng ý xóa nhãn dán này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa ngay',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Model/Admin/DeleteTag",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Toast(response.status, response.msg);
                        setTimeout(function() {
                            window.location = '/Admin/Tag';
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
    require_once(__DIR__."/Footer.php");
?>