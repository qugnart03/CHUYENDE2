<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/function.php';
$title = 'Cấu hình rút tiền CTV | ' . $SIEUTHICODE->site('tenweb');
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Header.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Sidebar.php';
?>
<?php
if(isset($_POST['SaveSettings']) && $getUser['level'] == 'admin')
{
    if($SIEUTHICODE->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    if (check_img('logo_banvang') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../../../assets/storage/images/logo_' . $rand . '.png';
        $tmp_name = $_FILES['logo_banvang']['tmp_name'];
        $add = move_uploaded_file($tmp_name, $uploads_dir);
        if ($add) {
            $SIEUTHICODE->update('options', [
                'value'  => 'assets/storage/images/logo_' . $rand . '.png'
            ], " `key` = 'logo_banvang' ");
        }
    }
    foreach ($_POST as $key => $value)
    {
        if($key == 'logo_banvang') continue;
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
                    <h1>Cấu hình rút tiền CTV</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
             
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-1"></i>
                                CẤU HÌNH THÔNG TIN
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
                                    <label>Trạng thái</label>
                                    <select class="form-control select2bs4" name="status_withdraw_ctv">
                                        <option <?=$SIEUTHICODE->site('status_withdraw_ctv') == 1 ? 'selected' : '';?>
                                            value="1">ON
                                        </option>
                                        <option <?=$SIEUTHICODE->site('status_withdraw_ctv') == 0 ? 'selected' : '';?>
                                            value="0">
                                            OFF
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ngân hàng được phép rút tiền</label>
                                    <textarea class="form-control" rows="5" placeholder="Nhập tên ngân hàng chi phép rút tiền, mỗi dòng 1 ngân hàng" name="listbank_ctv"><?=$SIEUTHICODE->site('listbank_ctv')?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số tiền rút tối thiểu</label>
                                    <input type="number" class="form-control" name="minrut_ctv" value="<?=$SIEUTHICODE->site('minrut_ctv')?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lưu ý</label>
                                    <textarea id="notice_withdraw_ctv"
                                        name="notice_withdraw_ctv"><?=$SIEUTHICODE->site('notice_withdraw_ctv')?></textarea>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>




<script>
CKEDITOR.replace("notice_withdraw_ctv");
</script>



<?php
require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/public/admin/Footer.php';
?>