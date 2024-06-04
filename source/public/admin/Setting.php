<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CẤU HÌNH | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
    // active_license();
?>
<?php
if(isset($_POST['btnSaveOption']) && $getUser['level'] == 'admin')
{
    if($SIEUTHICODE->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    foreach ($_POST as $key => $value)
    {
        $SIEUTHICODE->update("options", array(
            'value' => $value
        ), " `key` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
?>



<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cấu hình</h1>
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
                            <h3 class="card-title">CẤU HÌNH THÔNG TIN WEBSITE</h3>
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
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label>Tên website</label>
                                        <input type="text" name="tenweb" value="<?=$SIEUTHICODE->site('tenweb');?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Title website</label>
                                        <input type="text" name="title" value="<?=$SIEUTHICODE->site('title');?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Mô tả website</label>
                                        <input type="text" name="mota" value="<?=$SIEUTHICODE->site('mota');?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Từ khóa tìm kiếm</label>
                                        <input type="text" name="tukhoa" value="<?=$SIEUTHICODE->site('tukhoa');?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Hotline</label>
                                        <input type="text" name="hotline" value="<?=$SIEUTHICODE->site('hotline');?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Facebook</label>
                                        <input type="text" name="facebook" value="<?=$SIEUTHICODE->site('facebook');?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Thời gian hỗ trợ từ</label>
                                        <input type="text" name="from_time"
                                            value="<?=$SIEUTHICODE->site('from_time');?>" class="form-control"
                                            placeholder="Từ">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Đến</label>
                                        <input type="text" name="to_time" value="<?=$SIEUTHICODE->site('to_time');?>"
                                            class="form-control" placeholder="Đến">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Giới hạn số tài khoản đăng ký trên 1 IP</label>
                                        <input type="text" name="max_register_ip"
                                            value="<?=$SIEUTHICODE->site('max_register_ip');?>" class="form-control"
                                            placeholder="">
                                        <i>VD: 5 => mỗi IP chỉ được tạo tối đa 5 tài khoản</i>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Chiết khấu bán acc của CTV</label>
                                        <input type="text" name="chietkhau_banacc"
                                            value="<?=$SIEUTHICODE->site('chietkhau_banacc');?>" class="form-control"
                                            placeholder="">
                                        <i>VD: 10 => là admin ăn 10% của giá trị acc</i>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">ID Chat Telegram</label>
                                        <input type="text" name="chat_id"
                                            value="<?=$SIEUTHICODE->site('chat_id');?>" class="form-control"
                                            placeholder="">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Token Telegram</label>
                                        <input type="text" name="token_tele"
                                            value="<?=$SIEUTHICODE->site('token_tele');?>" class="form-control"
                                            placeholder="">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">ON/OFF Bán Acc</label>
                                        <select class="form-control show-tick select2bs4" name="status_banacc" required>
                                            <option
                                                <?= $SIEUTHICODE->site('status_banacc') == 'ON' ? 'selected' : ''; ?>
                                                value="ON">ON</option>
                                            <option
                                                <?= $SIEUTHICODE->site('status_banacc') == 'OFF' ? 'selected' : ''; ?>
                                                value="OFF">OFF</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">ON/OFF Dịch Vụ</label>
                                        <select class="form-control show-tick select2bs4" name="status_dichvu" required>
                                            <option
                                                <?= $SIEUTHICODE->site('status_dichvu') == 'ON' ? 'selected' : ''; ?>
                                                value="ON">ON</option>
                                            <option
                                                <?= $SIEUTHICODE->site('status_dichvu') == 'OFF' ? 'selected' : ''; ?>
                                                value="OFF">OFF</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">ON/OFF Minigame</label>
                                        <select class="form-control show-tick select2bs4" name="status_minigame"
                                            required>
                                            <option <?= $SIEUTHICODE->site('status_minigame') == 1 ? 'selected' : ''; ?>
                                                value="1">
                                                Bật</option>
                                            <option <?= $SIEUTHICODE->site('status_minigame') == 0 ? 'selected' : ''; ?>
                                                value="0">Tắt
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label for="">ON/OFF Thông Báo Mua Tài Khoản</label>
                                        <select class="form-control show-tick select2bs4" name="status_noti_sell"
                                            required>
                                            <option
                                                <?= $SIEUTHICODE->site('status_noti_sell') == 'ON' ? 'selected' : ''; ?>
                                                value="ON">
                                                Bật</option>
                                            <option
                                                <?= $SIEUTHICODE->site('status_noti_sell') == 'OFF' ? 'selected' : ''; ?>
                                                value="OFF">Tắt
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">ON/OFF Dịch Vụ Nổi Bật</label>
                                        <select class="form-control show-tick select2bs4" name="outstanding" required>
                                            <option value="1"
                                                <?=$SIEUTHICODE->site('outstanding') == '1' ? 'selected':'';?>>ON
                                            </option>
                                            <option value="0"
                                                <?=$SIEUTHICODE->site('outstanding') == '0' ? 'selected':'';?>>OFF
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">Loại giao diện</label>
                                        <select class="form-control show-tick select2bs4" name="style_theme" required>
                                            <option
                                                <?= $SIEUTHICODE->site('style_theme') == 'dark' ? 'selected' : ''; ?>
                                                value="dark">
                                                Dark</option>
                                            <option
                                                <?= $SIEUTHICODE->site('style_theme') == 'light' ? 'selected' : ''; ?>
                                                value="light">Light
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label for="">ON/OFF Auto Update Phiên Bản Mới</label>
                                        <select class="form-control show-tick select2bs4" name="status_update" required>
                                            <option <?= $SIEUTHICODE->site('status_update') == 1 ? 'selected' : ''; ?>
                                                value="1">
                                                Bật</option>
                                            <option <?= $SIEUTHICODE->site('status_update') == 0 ? 'selected' : ''; ?>
                                                value="0">Tắt
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">   
                                            <div class="col-lg-6">
                                                <label>Script Header</label>
                                                <div class="form-group">
                                                    <textarea id="codeMirrorDemo"
                                                        placeholder="Chứa code live chat hoặc jquery trang trí..."
                                                        name="javascript_header"><?=$SIEUTHICODE->site('javascript_header')?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Script Footer</label>
                                                <div class="form-group">
                                                    <textarea id="codeMirrorDemo2"
                                                        placeholder="Chứa code live chat hoặc jquery trang trí..."
                                                        name="javascript_footer"><?=$SIEUTHICODE->site('javascript_footer')?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Footer</label>
                                        <textarea name="custom_footer"
                                            rows="6"><?=$SIEUTHICODE->site('custom_footer');?></textarea>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Thông báo</label>
                                        <textarea name="thongbao"
                                            rows="6"><?=$SIEUTHICODE->site('thongbao');?></textarea>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Hướng dẫn rút vật phẩm</label>
                                        <textarea name="noti_diamond"
                                            rows="6"><?=$SIEUTHICODE->site('noti_diamond');?></textarea>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Thưởng top nạp</label>
                                        <textarea name="thuong_top"
                                            rows="6"><?=$SIEUTHICODE->site('thuong_top');?></textarea>
                                    </div>
                                </div>

                                <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                    <span>LƯU</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
CKEDITOR.replace("noti_diamond");
CKEDITOR.replace("thongbao");
CKEDITOR.replace("custom_footer");
CKEDITOR.replace("thuong_top");
$(function() {
    // Summernote

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
    require_once("../../public/admin/Footer.php");
?>