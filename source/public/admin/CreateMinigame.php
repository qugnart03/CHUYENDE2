<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
$title = 'THÊM TRÒ CHƠI | ' . $SIEUTHICODE->site('tenweb');
require_once __DIR__ . "/Header.php";
require_once __DIR__ . "/Sidebar.php";
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Trò chơi</h1>
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
                            <h3 class="card-title">THÊM TRÒ CHƠI</h3>
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
                            <form class="form-data" id="form-data" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tên trò chơi</label>
                                            <input class="form-control" name="name_game" type="text"
                                                placeholder="Tên trò chơi">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Thể loại</label>
                                            <select class="form-control select2bs4" name="type_game">
                                                <option value="VONGQUAY">Vòng Quay</option>
                                                <option value="BINGO3">Bingo 3 ô</option>
                                                <option value="LATHINH">Lật Hình</option>
                                                <option value="MOQUA">Mở quà</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Giá tiền</label>
                                            <input class="form-control" type="number" name="cash"
                                                placeholder="Giá tiền">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Giảm giá</label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" name="sale_cash"
                                                    placeholder="Chỉ hiển thị ở trang chủ" value="50">
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
                                                    placeholder="Fake lượt chơi" value="0">
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Chọn nhãn dán</label>
                                            <select class="form-control select2bs4" name="tag">
                                                <option value="">Không hiển thị</option>
                                                <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `tag` WHERE `id` != '0'") as $info) {?>
                                                <option value="<?=$info['image']?>"><?=$info['name']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- chọn hình ảnh -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Ảnh thumb</label>
                                            <img class="w-100 active" id="img_1"
                                                src="https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png">
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
                                            <img class="w-100 active" id="img_2"
                                                src="https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png">
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
                                            <img class="w-100 active" id="img_3"
                                                src="https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png">
                                            <center>
                                                <span class="btn btn-default btn-file">
                                                    <input name="close" type="file" class="form-control"
                                                        onchange="document.getElementById('img_3').src = window.URL.createObjectURL(this.files[0])">
                                                </span>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="close">
                                        <div class="form-group">
                                            <label>Đang mở quà</label>
                                            <img class="w-100 active" id="img_4"
                                                src="https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png">
                                            <center>
                                                <span class="btn btn-default btn-file">
                                                    <input name="open" type="file" class="form-control"
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
                                                placeholder="VD: 1,2,3,4,5,6,7,8,1,1">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>10 Lệnh Người Dùng:</label>
                                        <input type="text" name="lenh_user" class="form-control"
                                            placeholder="VD: 1,2,3,4,5,6,7,8,1,1">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger btn-block btn-lg shadow-lg mt-3"
                                    onclick="add_phanthuong()">Thêm quà</button>
                                <br>
                                <br>
                                <div id="gift"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Thể Lệ</label>
                                            <textarea name="thele" id="thele" cols="50" rows="5"></textarea>
                                            <script>
                                            CKEDITOR.replace('thele'); // tham số là biến name của textarea
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-block btn-lg shadow-lg mt-3"
                                    onclick="Upload()">Thêm ngay nào!</button>
                            </form>
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
var room = 0;

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
                                    <img class="w-100 active" id="item_${room}" src="https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png">
                                    <center>
                                      
                                        <div class="input-group">
                                                            <div class="btn custom-file">
                                                                <input name="item[]" type="file"
                                                                    class="custom-file-input"
                                                                    onchange="document.getElementById('item_${room}').src = window.URL.createObjectURL(this.files[0])">
                                                                <label class="custom-file-label"
                                                                    for="exampleInputFile">Choose
                                                                    file</label>
                                                            </div>

                                                        </div>
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
                                    <input type="text" name="tyle_text[]" class="form-control" placeholder="... Kim Cương" value="... Kim Cương">
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
        url: '/ajaxs/minigame/CreateMinigame.php',
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
require_once __DIR__ . "/Footer.php";
?>