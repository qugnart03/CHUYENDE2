<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUẢN LÝ THÀNH VIÊN | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
?>
<?php
if(isset($_POST['SaveSettings']) && $getUser['level'] == 'admin')
{
    if($SIEUTHICODE->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    if (check_img('background') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/background_' . $rand . '.png';
        $tmp_name = $_FILES['background']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/background_' . $rand . '.png'
            ], " `key` = 'background' ");
        }
    }
    if (check_img('logo_dark') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/logo_dark_' . $rand . '.png';
        $tmp_name = $_FILES['logo_dark']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/logo_dark_' . $rand . '.png'
            ], " `key` = 'logo_dark' ");
        }
    }
    if (check_img('favicon') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/favicon_' . $rand . '.png';
        $tmp_name = $_FILES['favicon']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/favicon_' . $rand . '.png'
            ], " `key` = 'favicon' ");
        }
    }
    if (check_img('anhbia') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/anhbia_' . $rand . '.png';
        $tmp_name = $_FILES['anhbia']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/anhbia_' . $rand . '.png'
            ], " `key` = 'anhbia' ");
        }
    }
    if (check_img('nutquay') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/nutquay_' . $rand . '.png';
        $tmp_name = $_FILES['nutquay']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/nutquay_' . $rand . '.png'
            ], " `key` = 'nut_quay' ");
        }
    }
    if (check_img('lathinh') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/lathinh' . $rand . '.png';
        $tmp_name = $_FILES['lathinh']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/lathinh' . $rand . '.png'
            ], " `key` = 'nut_lathinh' ");
        }
    }
    if (check_img('choingay') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/choingay' . $rand . '.png';
        $tmp_name = $_FILES['choingay']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/choingay' . $rand . '.png'
            ], " `key` = 'nut_choingay' ");
        }
    }
    if (check_img('muangay') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/muangay' . $rand . '.png';
        $tmp_name = $_FILES['muangay']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/muangay' . $rand . '.png'
            ], " `key` = 'nut_muangay' ");
        }
    }
    if (check_img('banner') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images/banner' . $rand . '.png';
        $tmp_name = $_FILES['banner']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/banner' . $rand . '.png'
            ], " `key` = 'banner' ");
        }
    }
    admin_msg_success('Lưu thành công', '', 500);
}
?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Theme</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-image mr-1"></i>
                                THAY ĐỔI GIAO DIỆN WEBSITE
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
                                    
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Logo Dark</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="logo_dark">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('logo_dark'))?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Favicon</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="favicon">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="100px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('favicon'))?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Ảnh bìa</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="anhbia">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('anhbia'))?>" />
                                        <hr>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Background</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="background">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('background'))?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Banner</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="banner">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="500px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('banner'))?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nút Quay</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="nutquay">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="100px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('nut_quay'))?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nút Lật Hình</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="lathinh">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="200px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('nut_lathinh'))?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nút chơi ngay</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="choingay">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="200px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('nut_choingay'))?>" />
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nút mua ngay</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="muangay">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img width="200px"
                                            src="<?=BASE_URL($SIEUTHICODE->site('nut_muangay'))?>" />
                                        <hr>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>


<?php 
    require_once("../../public/admin/Footer.php");
?>