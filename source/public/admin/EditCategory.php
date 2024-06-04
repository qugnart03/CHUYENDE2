<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CHỈNH SỬA DANH MỤC | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>

<?php
if(isset($_GET['id']) && $getUser['level'] == 'admin')
{
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `category` WHERE `id` = '".Anti_xss($_GET['id'])."'  ");
    if(!$row)
    {
        new Redirect('/');
    }
}
else
{
    new Redirect('/');
}
?>
<?php
if (isset($_POST['SaveCate']) && $getUser['level'] == 'admin') {
    if ($SIEUTHICODE->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if (check_img('img') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 4);
        $uploads_dir = '../../assets/storage/images/';
        $tmp_name = $_FILES['img']['tmp_name'];
        $url_listimg = "category_".$rand.".png";
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir.$url_listimg);
        if ($addlogo) {
            $SIEUTHICODE->update("category", [
                'img' => 'assets/storage/images/'.$url_listimg
            ], " `id` = '".$row['id']."' ");
        }
    }
    $isInsert = $SIEUTHICODE->update("category", [
        'stt'         => Anti_xss($_POST['stt']),
        'title'         => Anti_xss($_POST['title']),
        'tag'      => Anti_xss($_POST['tag']),
        'display'       => Anti_xss($_POST['display'])
    ], " `id` = '".$row['id']."' ");
    if ($isInsert) {
        $SIEUTHICODE->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => "Chỉnh sửa danh mục (".$row['title']." ID ".$row['id'].")."
        ]);
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){window.history.back().location.reload();}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Lưu thất bại!")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh sửa danh mục</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('Admin/Home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa danh mục</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                    <div class="mb-3">
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('Admin/Category');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-1"></i>
                                CHỈNH SỬA DANH MỤC
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Vị trí hiển thị</label>
                                    <input type="text" class="form-control" value="<?=$row['stt'];?>" name="stt"
                                        placeholder="Nhập vị trí hiển thị" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" class="form-control" value="<?=$row['title'];?>" name="title"
                                        placeholder="Nhập tên tiêu đề bài viết" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="img">
                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <img src="<?=BASE_URL($row['img']);?>" width="200px">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn nhãn dán</label>
                                    <select class="form-control select2bs4" name="tag">
                                        <option value="">Chọn nhãn dán</option>
                                        <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `tag` WHERE `id` != '0'") as $info){ ?>
                                        <option value="<?=$info['image']?>"
                                            <?=$info['image'] == $row['tag'] ? 'selected="selected"' : ''?>>
                                            <?=$info['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Display</label>
                                    <select class="form-control select2bs4" name="display" required>
                                        <option <?=$row['display'] == 1 ? 'selected' : '';?> value="1">Hiển thị</option>
                                        <option <?=$row['display'] == 0 ? 'selected' : '';?> value="0">Ẩn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveCate" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    // Summernote
    $('.textarea').summernote()
})
</script>





<?php 
    require_once(__DIR__."/Footer.php");
?>