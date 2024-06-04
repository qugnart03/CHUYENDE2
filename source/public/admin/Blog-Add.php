<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
$title = 'LƯU TRỮ | ' . $SIEUTHICODE->site('tenweb');
require_once __DIR__ . "/Header.php";
require_once __DIR__ . "/Sidebar.php";
?>
<?php
if (isset($_POST['AddBlog']) && $getUser['level'] == 'admin') {
    if ($SIEUTHICODE->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($SIEUTHICODE->get_row("SELECT * FROM `blogs` WHERE `title` = '" . check_string($_POST['title']) . "' ")) {
        die('<script type="text/javascript">if(!alert("Tiêu đề bài viết này đã tồn tại trong hệ thống.")){window.history.back().location.reload();}</script>');
    }
    $url_image = '';
    if (check_img('image') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 6);
        $uploads_dir = '../../assets/storage/images/';
        $tmp_name = $_FILES['image']['tmp_name'];
        $url_listimg = "blog_" . $rand . ".png";
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir . $url_listimg);
        if ($addlogo) {
            $url_image = $uploads_dir . $url_listimg;
        }
    }
    $isInsert = $SIEUTHICODE->insert("blogs", [
        'image' => $url_image,
        'stt' => Anti_xss($_POST['stt']),
        'link' => Anti_xss($_POST['link']),
        'title' => check_string($_POST['title']),
        'slug' => create_slug(check_string($_POST['title'])),
        'content' => base64_encode($_POST['content']),
        'display' => check_string($_POST['display']),
        'type'       => Anti_xss($_POST['type']),
        'create_date' => gettime(),
        'update_date' => gettime(),
    ]);
    if ($isInsert) {
        $SIEUTHICODE->insert("logs", [
            'user_id' => $getUser['id'],
            'ip' => myip(),
            'device' => $_SERVER['HTTP_USER_AGENT'],
            'create_date' => gettime(),
            'action' => "Thêm bài viết (" . check_string($_POST['title']) . ") vào hệ thống.",
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "' . BASE_URL('Admin/Blog') . '";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm bài viết mới</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('Admin/Home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Thêm bài viết mới</li>
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
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url('Admin/Blog');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-blog mr-1"></i>
                                THÊM BÀI VIẾT
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
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Vị trí hiển thị</label>
                                            <input type="text" class="form-control" name="stt"
                                                placeholder="Vị trí hiển thị" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Loại bài viết</label>
                                            <select class="form-control select2bs4" name="type" required>
                                                <option value="blog">Blog
                                                </option>
                                                <option value="noibat">Nổi bật
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tiêu đề bài viết</label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Nhập tên tiêu đề bài viết" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Permalink:</label>
                                            <input type="text" class="form-control" name="link"
                                                placeholder="Nhập liên kết" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" required>
                                            <label class="custom-file-label" for="exampleInputFile">Choose
                                                file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung bài viết</label>
                                    <textarea id="content" name="content" class="textarea"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Display</label>
                                    <select class="form-control select2bs4" name="display" required>
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="AddBlog" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-plus mr-1"></i>Thêm Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once __DIR__ . "/Footer.php";
?>