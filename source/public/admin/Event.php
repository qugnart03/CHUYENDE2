<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    
    $title = 'LƯU TRỮ | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>
<?php
if (isset($_POST['AddEvent']) && $getUser['level'] == 'admin') {
    if ($SIEUTHICODE->site('status_demo') == 1) {
        die('<script type="text/javascript">if(!alert("Đây là trang web demo bạn không thể thực hiện chức năng này !")){window.history.back().location.reload();}</script>');
    }
    if (check_img('img_event') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 4);
        $uploads_dir_image = 'assets/storage/images/event_' . $rand . '.png';
        $uploads_dir_image2 = '../../assets/storage/images/event_' . $rand . '.png';
        $tmp_name = $_FILES['img_event']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir_image2);
        if ($addlogo) {
            $SIEUTHICODE->update('options', [
                'value' => $uploads_dir_image,
            ], " `key` = 'img_event' ");
        }

    }
    foreach ($_POST as $key => $value) {
        $SIEUTHICODE->update("options", array(
            'value' => $value,
        ), " `key` = '$key' ");
    }
    die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
}?>
<div class="content-wrapper">
    <div id="thongbao"></div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sự kiện</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- .card -->
                    <div class="card card-fluid">
                        <!-- .card-header -->
                        <div class="card-header card-outline card-primary">
                            <h4 class="card-title">
                                CÀI ĐẶT SỰ KIỆN
                            </h4>
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
                        </div><!-- /.card-header -->
                        <!-- .card-body -->
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <label for="taikhoan">Chế độ hoạt động</label>
                                                <select name="status_event" class="form-control select2bs4"
                                                    data-toggle="select2" required>
                                                    <option
                                                        <?=$SIEUTHICODE->site('status_event') == 1 ? 'selected' : '';?>
                                                        value="1">
                                                        Bật</option>
                                                    <option
                                                        <?=$SIEUTHICODE->site('status_event') == 0 ? 'selected' : '';?>
                                                        value="0">Tắt
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="taikhoan">Loại tiền</label>
                                                <select name="type_lixi" class="form-control select2bs4"
                                                    data-toggle="select2" required>
                                                    <option
                                                        <?=$SIEUTHICODE->site('type_lixi') == 'money' ? 'selected' : '';?>
                                                        value="money">
                                                        Tiền website</option>
                                                    <option
                                                        <?=$SIEUTHICODE->site('type_lixi') == 'diamond' ? 'selected' : '';?>
                                                        value="diamond">Kim cương
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="taikhoan">Item ngẫu nhiên (5,10)</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input name="diamond" type="text" class="form-control"
                                                            value="<?=$SIEUTHICODE->site('diamond')?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">

                                            <div class="col-sm-6">
                                                <label for="matkhau">Hình ảnh:</label>

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                name="img_event">
                                                            <label class="custom-file-label"
                                                                for="exampleInputFile">Choose
                                                                file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="username"></label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <img width="100px"
                                                            src="<?=BASE_URL($SIEUTHICODE->site('img_event'))?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="username">Thông Báo Nhận Quà:</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea id="note_event" rows="20" name="note_event"
                                                            class="form-control textarea"><?=$SIEUTHICODE->site('note_event')?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="AddEvent" class="btn btn-primary">LƯU NGAY</button>
                                    </form>
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
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
})
</script>
<?php 
    require_once(__DIR__."/Footer.php");
?>