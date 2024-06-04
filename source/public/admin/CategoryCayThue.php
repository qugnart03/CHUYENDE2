<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUẢN LÝ CHUYÊN MỤC CÀY THUÊ | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>

<?php
if(isset($_POST['ThemChuyenMuc']) && $getUser['level'] == 'admin' )
{
    if($SIEUTHICODE->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    $rand = random("QWERTYUIOPASDFGHJKLZXCVBNM0123456789", 12);
    if(check_img('img') == true)
    {
        $uploads_dir = '../../assets/storage/images';
        $tmp_name = $_FILES['img']['tmp_name'];
        $url_img = "/category_".$rand.".png";
        $create = move_uploaded_file($tmp_name, $uploads_dir.$url_img);
    }
    $SIEUTHICODE->insert("category_caythue", array(
        'img'       => 'assets/storage/images'.$url_img,
        'title' => Anti_xss($_POST['title']),
        'fake' => Anti_xss($_POST['fake']),
        'content' => base64_encode($_POST['content']),
        'display' => Anti_xss($_POST['display'])
    ));
    admin_msg_success("Thêm thành công", '', 500);
}
?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chuyên mục cày thuê</h1>
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
                            <h3 class="card-title">THÊM CHUYÊN MỤC CÀY THUÊ</h3>
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
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Tên chuyên mục</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" name="title" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Giao dịch ảo</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="number" name="fake" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Ảnh mô tả</label>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="img" required>
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
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nội dung</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <textarea name="content" class="textarea"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Hiển thị</label>
                                    <div class="col-sm-9">
                                        <select class="form-control show-tick select2bs4" name="display" required>
                                            <option value="1">SHOW</option>
                                            <option value="0">HIDE</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="ThemChuyenMuc" class="btn btn-primary btn-block">
                                    <span>THÊM NGAY</span></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DANH SÁCH CHUYÊN MỤC CẦY THUÊ</h3>
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
                                            <th>TÊN CHUYÊN MỤC</th>
                                            <th>HIỂN THỊ</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach($SIEUTHICODE->get_list(" SELECT * FROM `category_caythue` ORDER BY id DESC ") as $row){
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td width="10%"><img width="100%" src="<?=BASE_URL($row['img']);?>" /></td>
                                            <td><?=$row['title'];?></td>
                                            <td><?=display($row['display']);?></td>
                                            <td>
                                                <a href="/Admin/Category/Cay-thue/Edit/<?=$row['id'];?>" class="btn btn-primary"><i
                                                        class="fas fa-edit"></i>
                                                    <span>EDIT</span></a>

                                                <a type="button"
                                                    href="/Admin/Category/NhomCayThue/<?=$row['id'];?>"
                                                    class="btn btn-dark"><i class="fas fa-file-medical"></i>
                                                    <span>XEM NHÓM</span></a>
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