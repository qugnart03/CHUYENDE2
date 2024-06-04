<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CHỈNH SỬA MINI GAME | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>

<?php
if(isset($_GET['id']) && $getUser['level'] == 'admin')
{
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `minigame` WHERE `id` = '".Anti_xss($_GET['id'])."'  ");
    if(!$row)
    {
        new Redirect('/');
    }
    $detail = json_decode($row['detail'], true);
}
else
{
    new Redirect('/');
}


if(isset($_POST['LuuChuyenMuc']) && $getUser['level'] == 'admin' )
{
    if($SIEUTHICODE->site('status_demo') == 'ON')
    {
        admin_msg_warning("Chức năng này không khả dụng trên trang web DEMO!", "", 2000);
    }
    if(check_img('img') == true)
    {
        $rand = random("QWERTYUIOPASDFGHJKLZXCVBNM0123456789", 12);
        $uploads_dir = '../../assets/storage/images';
        $tmp_name = $_FILES['img']['tmp_name'];
        $url_img = "/groups_".$rand.".png";
        $create = move_uploaded_file($tmp_name, $uploads_dir.$url_img);
        $SIEUTHICODE->update("groups", array(
            'img'       => BASE_URL('assets/storage/images'.$url_img)
        ), " `id` = '".$row['id']."' ");
    }
    $SIEUTHICODE->update("groups", array(
        'title'     => check_string($_POST['title']),
        'chitiet'   => base64_encode($_POST['chitiet']),
        'display'   => check_string($_POST['display'])
    ), " `id` = '".$row['id']."' ");
    admin_msg_success("Lưu thành công", '', 500);
}

?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa trò chơi</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-primary card-outline">
                            <h4 class="card-title">Chỉnh sửa danh mục [<?=$detail['name_product']?>]</h4>
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
                                <form class="form-data" id="form-data" enctype="multipart/form-data">
                                    <input hidden name="id" value="<?=$row['id']?>" ?>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tên trò chơi</label>
                                                <input class="form-control" name="name_game" type="text"
                                                    placeholder="Tên trò chơi" value="<?=$detail['name_product']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Thể loại</label>
                                                <select class="form-control select2bs4" name="type_game">
                                                    <option value="VONGQUAY"
                                                        <?=$row['type'] == 'VONGQUAY' ? 'selected="selected"' : ''?>>
                                                        Vòng Quay</option>
                                                    <option value="BINGO3"
                                                        <?=$row['type'] == 'BINGO3' ? 'selected="selected"' : ''?>>
                                                        Bingo 3 ô</option>
                                                    <option value="LATHINH"
                                                        <?=$row['type'] == 'LATHINH' ? 'selected="selected"' : ''?>>
                                                        Lật Hình</option>
                                                    <option value="MOQUA"
                                                        <?=$row['type'] == 'MOQUA' ? 'selected="selected"' : ''?>>Mở
                                                        quà</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Giá tiền</label>
                                                <input class="form-control" type="number" name="cash"
                                                    placeholder="Giá tiền" value="<?=$detail['cash']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Giảm giá</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" name="sale_cash"
                                                        placeholder="% giảm giá" value="<?=$detail['sale_cash']?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Fake lượt chơi</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" name="fake_spin"
                                                        placeholder="Fake lượt chơi" value="<?=$detail['fake_spin']?>">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Chọn nhãn dán</label>
                                                <select class="form-control select2bs4" name="tag">
                                                    <option value="">Không hiển thị</option>
                                                    <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `tag` WHERE `id` != '0'") as $info){ ?>
                                                    <option value="<?=$info['image']?>"
                                                        <?=$detail['tag'] == $info['image'] ? 'selected="selected"' : ''?>>
                                                        <?=$info['name']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- chọn hình ảnh -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ảnh thumb</label>
                                                <img class="w-100 active lazyLoad" id="img_1"
                                                    data-src="<?=BASE_URL($detail['thumb'])?>"
                                                    src="<?=BASE_URL($detail['thumb'])?>">
                                                <center>
                                                    <span class="btn btn-default btn-file">
                                                        <input name="thumb" type="file" class="form-control"
                                                            onchange="document.getElementById('img_1').src = window.URL.createObjectURL(this.files[0])">
                                                        Upload file
                                                    </span>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label style="font-size:10px;">Ảnh vòng quay, khung BINGO, mặt trước
                                                    bài:</label>
                                                <img class="w-100 active lazyLoad" id="img_2"
                                                    data-src="<?=BASE_URL($detail['vongquay'])?>"
                                                    src="<?=BASE_URL($detail['vongquay'])?>">
                                                <center>
                                                    <span class="btn btn-default btn-file">
                                                        <input name="vongquay" type="file" class="form-control"
                                                            onchange="document.getElementById('img_2').src = window.URL.createObjectURL(this.files[0])">
                                                        Upload file
                                                    </span>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="open">
                                            <div class="form-group">
                                                <label>Trước khi mở quà</label>
                                                <img class="w-100 active lazyLoad" id="img_3"
                                                    data-src="<?=BASE_URL($detail['open'])?>"
                                                    src="<?=BASE_URL($detail['open'])?>">
                                                <center>
                                                    <span class="btn btn-default btn-file">
                                                        <input name="open" type="file" class="form-control"
                                                            onchange="document.getElementById('img_3').src = window.URL.createObjectURL(this.files[0])">
                                                    </span>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="close">
                                            <div class="form-group">
                                                <label>Đang mở quà</label>
                                                <img class="w-100 active lazyLoad" id="img_4"
                                                    data-src="<?=BASE_URL($detail['close'])?>"
                                                    src="<?=BASE_URL($detail['close'])?>">
                                                <center>
                                                    <span class="btn btn-default btn-file">
                                                        <input name="close" type="file" class="form-control"
                                                            onchange="document.getElementById('img_4').src = window.URL.createObjectURL(this.files[0])">
                                                    </span>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- // -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>10 Lệnh Admin:</label>
                                                <input type="text" name="lenh_admin" class="form-control"
                                                    placeholder="VD: 1,2,3,4,5,6,7,8,1,1"
                                                    value="<?=$detail['lenh_admin']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>10 Lệnh Người Dùng:</label>
                                            <input type="text" name="lenh_user" class="form-control"
                                                placeholder="VD: 1,2,3,4,5,6,7,8,1,1" value="<?=$detail['lenh_user']?>">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-block btn-lg shadow-lg mt-3"
                                        onclick="add_phanthuong()">Thêm quà</button>
                                    <br>
                                    <br>
                                    <?php
                                    for ($i=0; $i < count($detail['data']); $i++) {
                                ?>
                                    <div class="removeclass<?=$i+1?>">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label>Ảnh quà:</label>
                                                    <img class="w-100 active lazyLoad" id="item_1"
                                                        data-src="<?=BASE_URL($detail['data'][$i]['item'])?>"
                                                        src="<?=BASE_URL($detail['data'][$i]['item'])?>">
                                                    <center>
                                                        <span class="btn btn-default btn-file">
                                                            <input name="item[]" type="file" class="form-control"
                                                                onchange="document.getElementById('item_1').src = window.URL.createObjectURL(this.files[0])">
                                                            Upload
                                                        </span>
                                                    </center>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label>Loại quà <?=$i+1?>:</label>
                                                    <select name="tyle_type[]" class="form-control select2bs4">
                                                        <option value="KC"
                                                            <?=$detail['data'][$i]['tyle_type'] == 'KC' ? 'selected="selected"' : ''?>>
                                                            Kim cương</option>
                                                        <option value="KCRD"
                                                            <?=$detail['data'][$i]['tyle_type'] == 'KCRD' ? 'selected="selected"' : ''?>>
                                                            Kim cương Ngẫu Nhiên</option>
                                                        <option value="PRICE"
                                                            <?=$detail['data'][$i]['tyle_type'] == 'PRICE' ? 'selected="selected"' : ''?>>
                                                            Tiền shop</option>
                                                        <option value="ACCOUNT"
                                                            <?=$detail['data'][$i]['tyle_type'] == 'ACCOUNT' ? 'selected="selected"' : ''?>>
                                                            Tài khoản game</option>
                                                        <option value="NO"
                                                            <?=$detail['data'][$i]['tyle_type'] == 'NO' ? 'selected="selected"' : ''?>>
                                                            Không trúng</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Giá trị:</label>
                                                    <input type="text" name="tyle_value[]" class="form-control"
                                                        placeholder="Nếu là random thì 20,25"
                                                        value="<?=$detail['data'][$i]['tyle_value']?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 has-success">
                                                <div class="form-group">
                                                    <label>Thông báo:</label>
                                                    <input type="text" name="tyle_text[]" class="form-control"
                                                        placeholder="Bạn đã trúng ..."
                                                        value="<?=$detail['data'][$i]['tyle_text']?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 mt-4">
                                                <div class="form-group">
                                                    <button class="btn btn-danger" type="button"
                                                        onclick="remove(<?=$i+1?>);"><i
                                                            class="fas fa-times me-25"></i><span> Xóa</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div id="gift"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Thể Lệ</label>
                                                <textarea name="thele" id="thele" cols="50"
                                                    rows="5"><?=$detail['thele']?></textarea>
                                                <script>
                                                CKEDITOR.replace('thele'); // tham số là biến name của textarea
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-block btn-lg shadow-lg mt-3"
                                        onclick="Upload()">Lưu ngay nào!</button>
                                </form>
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
$('#open').hide();
$('#close').hide();
$(document).ready(function() {
    $('select[name="type_game"]').change(function() {
        let type = $('select[name="type_game"] :selected').val();
        if (type == "MOQUA") {
            $('#open').show();
            $('#close').show();
        } else {
            $('#open').hide();
            $('#close').hide();
        }
    });
});
var room = <?=count($detail['data'])?>;

function add_phanthuong() {
    room++;
    var objTo = document.getElementById('gift');
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "removeclass" + room);
    var rdiv = 'removeclass' + room;
    divtest.innerHTML = `<div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Ảnh quà:</label>
                                    <img class="w-100 active lazyLoad" id="item_${room}" data-src="https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png">
                                    <center>
                                        <span class="btn btn-default btn-file">
                                            <input name="item[]" type="file" class="form-control" onchange="document.getElementById('item_${room}').src = window.URL.createObjectURL(this.files[0])">
                                            Upload
                                        </span>
                                    </center>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Loại quà ${room}:</label>
                                    <select name="tyle_type[]" class="form-control">
                                        <option value="KC">Kim cương</option>
                                        <option value="KCRD">Kim cương Ngẫu Nhiên</option>
                                        <option value="PRICE">Tiền shop</option>
                                        <option value="ACCOUNT">Tài khoản game</option>
                                        <option value="NO">Không trúng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Giá trị:</label>
                                    <input type="text" name="tyle_value[]" class="form-control" placeholder="Nếu là random thì 20,25" required="">
                                </div>
                            </div>
                            <div class="col-lg-3 has-success">
                                <div class="form-group">
                                    <label>Thông báo:</label>
                                    <input type="text" name="tyle_text[]" class="form-control" placeholder="Bạn đã trúng ..." value="Bạn đã trúng ...">
                                </div>
                            </div>
                            <div class="col-lg-2 mt-4">
                                <div class="form-group">
                                    <button class="btn btn-danger" type="button" onclick="remove(${room});"><i class="fas fa-times me-25"></i><span> Xóa</span>
                                    </button>
                                </div>
                            </div>
                        </div>`;
    objTo.appendChild(divtest);
}

function remove(rid) {
    room = rid - 1;
    $('.removeclass' + rid).remove();
}

function Upload() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
    $.ajax({
        url: '/ajaxs/minigame/EditMiniGame.php',
        type: 'POST',
        dataType: 'JSON',
        data: new FormData($('form#form-data')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            Toast(data.status, data.msg);
        }
    });
}
</script>




<?php 
    require_once(__DIR__."/Footer.php");
?>