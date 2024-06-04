<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
$title = 'Cài đặt nạp thẻ tự động | ' . $SIEUTHICODE->site('tenweb');
require_once "../../public/admin/Header.php";
require_once "../../public/admin/Sidebar.php";
?>

<?php
if (isset($_POST['SaveSettings']) && $getUser['level'] == 'admin') {
    if ($SIEUTHICODE->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    foreach ($_POST as $key => $value) {
        $SIEUTHICODE->update("options", array(
            'value' => $value,
        ), " `key` = '$key' ");
    }
    die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
}?>



<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cài đặt nạp thẻ tự động</h1>
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
                                CẤU HÌNH API
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
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control select2bs4" name="status_card">
                                        <option <?=$SIEUTHICODE->site('status_card') == 1 ? 'selected' : '';?>
                                            value="1">ON
                                        </option>
                                        <option <?=$SIEUTHICODE->site('status_card') == 0 ? 'selected' : '';?>
                                            value="0">
                                            OFF
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>URL API CARD (VD: https://ten_mien/chargingws/v2)</label>
                                    <div class="row">
                                        <div class="col-lg-12 mr-1 mb-3">
                                            <input class="form-control" type="text" name="url_card"
                                                value="<?=$SIEUTHICODE->site('url_card')?>"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Partner ID (<a type="button" data-toggle="modal"
                                            data-target="#modal-hd-nap-the" href="#">Xem hướng dẫn</a>)</label>
                                    <div class="row">
                                        <div class="col-lg-12 mr-1 mb-3">
                                            <input class="form-control" type="text" name="partner_id_card"
                                                value="<?=$SIEUTHICODE->site('partner_id_card')?>"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Partner Key (<a type="button" data-toggle="modal"
                                            data-target="#modal-hd-nap-the" href="#">Xem hướng dẫn</a>)</label>
                                    <div class="row">
                                        <div class="col-lg-12 mr-1 mb-3">
                                            <input class="form-control" type="text" name="partner_key_card"
                                                value="<?=$SIEUTHICODE->site('partner_key_card')?>"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Lưu ý</label>
                                    <textarea id="luuy_naptien"
                                        name="luuy_naptien"><?=$SIEUTHICODE->site('luuy_naptien')?></textarea>
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
    </section>
</div>
<div class="modal fade" id="modal-hd-nap-the">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HƯỚNG DẪN TÍCH HỢP NẠP THẺ CÀO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Bước 1: Truy cập vào <a target="_blank"
                            href="https://trumthere.vn/customer/login">https://trumthere.vn/customer/login</a> <b>đăng
                            ký</b> tài khoản và <b>đăng nhập</b>.</li>
                    <li>Bước 2: Truy cập vào <a target="_blank" href="https://trumthere.vn/merchant/list">đây</a> để
                        tiến
                        hành tạo API mới.</li>
                    <li>Bước 3: Nhập lần lượt như sau:</li>
                    <b>Tên mô tả:</b> => <i>shopacc.sieuthicode.net - SHOPACCV5</i><br>
                    <b>Chọn ví giao dịch:</b> => <i>VND</i><br>
                    <b>Kiểu:</b> => <i>GET</i><br>
                    <b>Đường dẫn nhận dữ liệu (Callback Url):</b> =>
                    <i><?=BASE_URL('')?>api/card.php</i><br>
                    <b>Địa chỉ IP (không bắt buộc):</b> => <i></i><br>
                    <li>Bước 4: Thêm thông tin kết nối và <a target="_blank" href="https://zalo.me/0978364572">inbox</a>
                        ngay cho Admin để duyệt API.</li>
                    <li>Bước 5: Copy Partner ID dán vào ô Partner ID trên hệ thống.</li>
                    <li>Bước 6: Copy Partner Key dán vào ô Partner Key trên hệ thống.</li>
                </ul>
                <h4 class="text-center">Chúc quý khách thành công <img
                        src="https://i.pinimg.com/736x/c4/2c/98/c42c983e8908fdbd6574c2135212f7e4.jpg" width="45px;">
                </h4>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
CKEDITOR.replace("luuy_naptien");
</script>
<?php
require_once "../../public/admin/Footer.php";
?>