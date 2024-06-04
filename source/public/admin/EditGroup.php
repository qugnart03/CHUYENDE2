<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'CHỈNH SỬA NHÓM | '.$SIEUTHICODE->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
?>

<?php

if(isset($_GET['id']) && $getUser['level'] == 'admin')
{
    $row = $SIEUTHICODE->get_row(" SELECT * FROM `groups` WHERE `id` = '".Anti_xss($_GET['id'])."'  ");
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


?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh sửa nhóm <?=$detail['name_product'];?></h1>
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
                            <h3 class="card-title">CHỈNH SỬA</h3>
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
                            <form id="form-data" enctype="multipart/form-data">
                                <input hidden name="id" value="<?=$row['id']?>">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Loại tài khoản</label>
                                            <select class="form-control select2bs4" name="type">
                                                <option value="ACCOUNT"
                                                    <?=$row['type'] == 'ACCOUNT' ? 'selected="selected"' : ''?>>Tài
                                                    khoản
                                                </option>
                                                <option value="RANDOM"
                                                    <?=$row['type'] == 'RANDOM' ? 'selected="selected"' : ''?>>Vận may
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tên sản phẩm</label>
                                            <input class="form-control" name="name_product" type="text"
                                                placeholder="Tên sản phẩm" value="<?=$detail['name_product']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Chọn nhãn dán</label>
                                            <select class="form-control select2bs4" name="tag">
                                                <option value="">Không hiển thị</option>
                                                <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `tag` WHERE `id` != '0'", 0) as $info){ ?>
                                                <option value="<?=$info['image']?>"
                                                    <?=$info['image'] == $detail['tag'] ? 'selected="selected"' : ''?>>
                                                    <?=$info['name']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Giao dịch ảo</label>
                                            <input class="form-control" name="fake" type="number"
                                                placeholder="Giao dịch ảo" value="<?=$row['fake']?>">
                                        </div>
                                    </div>
                                    <?php if($row['type'] == 'RANDOM'): ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Giá tiền</label>
                                            <input name="price" class="form-control" value="<?=$detail['cash']?>">
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Ảnh thumb</label>
                                            <img class="w-100 active lazyLoad" id="img_1"
                                                src="<?=BASE_URL($detail['thumb'])?>">
                                            <center>
                                                <span class="btn btn-default btn-file">
                                                    <input name="thumb" type="file" class="form-control"
                                                        onchange="document.getElementById('img_1').src = window.URL.createObjectURL(this.files[0])">
                                                </span>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    for ($i=0; $i < count($detail['data']); $i++) {
                                ?>
                                <div class="removeclass<?=$i+1?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Kiểu dữ liệu:</label>
                                                <select class="form-control select2bs4" name="data_type[]">
                                                    <option value="input"
                                                        <?=$detail['data'][$i]['type'] == 'input' ? 'selected="selected"' : ''?>>
                                                        Nhập dữ liệu số & chữ</option>
                                                    <option value="select"
                                                        <?=$detail['data'][$i]['type'] == 'select' ? 'selected="selected"' : ''?>>
                                                        Chọn dữ liệu</option>
                                                    <option value="number"
                                                        <?=$detail['data'][$i]['type'] == 'number' ? 'selected="selected"' : ''?>>
                                                        Nhập dữ liệu số</option>
                                                    <option value="password"
                                                        <?=$detail['data'][$i]['type'] == 'password' ? 'selected="selected"' : ''?>>
                                                        Nhập mật khẩu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tên hiển thị:</label>
                                                <input class="form-control" name="data_name[]" type="text"
                                                    placeholder="Tên hiển thị"
                                                    value="<?=$detail['data'][$i]['label']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Giá trị</label>
                                                <input class="form-control" type="text" name="data_value[]"
                                                    placeholder="Phân cách dữ liệu bằng ký tự |"
                                                    value="<?=$detail['data'][$i]['value']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Dữ liệu được</label>
                                                <div class="input-group">
                                                    <select class="form-control select2bs4" name="data_show[]">
                                                        <option value="on"
                                                            <?=$detail['data'][$i]['show'] == 'on' ? 'selected="selected"' : ''?>>
                                                            Hiển thị cho người dùng</option>
                                                        <option value="off"
                                                            <?=$detail['data'][$i]['show'] == 'off' ? 'selected="selected"' : ''?>>
                                                            Không hiển thị cho người dùng</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <?php if($i == '0'){ ?>
                                                        <button class="btn btn-success" type="button"
                                                            onclick="add_();"><i class="fa fa-plus"></i></button>
                                                        <?php }else{ ?>
                                                        <button class="btn btn-danger" type="button"
                                                            onclick="remove(<?=$i+1?>);"><i
                                                                class="fa fa-minus"></i></button>
                                                        <?php } ?>
                                                    </div>
                                                </div>
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
                                <div class="row">
                                    <label class="col-sm-12 col-form-label">Hiển thị</label>
                                    <div class="col-sm-12">
                                        <select class="form-control show-tick select2bs4" name="display" required>
                                            <option <?=$row['display'] == 1 ? 'selected' : '';?> value="1">Hiển thị
                                            </option>
                                            <option <?=$row['display'] == 0 ? 'selected' : '';?> value="0">Ẩn</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" id="LuuChuyenMuc" class="btn btn-primary btn-block mt-3"
                                    onclick="Upload()">
                                    <span>LƯU NGAY</span></button>
                                <a type="button" href="<?=BASE_URL('Admin/Groups/'.$row['category']);?>"
                                    class="btn btn-danger btn-block waves-effect">
                                    <span>TRỞ LẠI</span>
                                </a>
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
var room = <?=count($detail['data'])?>;

function add_() {
    room++;
    var objTo = document.getElementById('gift');
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "removeclass" + room);
    var rdiv = 'removeclass' + room;
    divtest.innerHTML = `<div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kiểu dữ liệu:</label>
                                    <select class="form-control" name="data_type[]">
                                        <option value="input">Nhập dữ liệu số & chữ</option>
                                        <option value="select">Chọn dữ liệu</option>
                                        <option value="number">Nhập dữ liệu số</option>
                                        <option value="password">Nhập mật khẩu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tên hiển thị:</label>
                                    <input class="form-control" name="data_name[]" type="text" placeholder="Tên hiển thị">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Giá trị</label>
                                    <input class="form-control" type="text" name="data_value[]" placeholder="Phân cách dữ liệu bằng ký tự |">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dữ liệu được</label>
                                    <div class="input-group">
                                        <select class="form-control" name="data_show[]">
                                            <option value="on">Hiển thị cho người dùng</option>
                                            <option value="off">Không hiển thị cho người dùng</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-danger" type="button" onclick="remove(${room});"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
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
    $('#LuuChuyenMuc').html('<i class="fa fa-spinner"></i> Đang xử lý...').prop('disabled',
        true);
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
    $.ajax({
        url: '/Model/EditGroup',
        type: 'POST',
        dataType: 'JSON',
        data: new FormData($('form#form-data')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            Toast(data.status, data.msg);
            $('#LuuChuyenMuc').html(
                    'THÊM NGAY')
                .prop('disabled', false);
        }
    });
}
</script>





<?php 
    require_once(__DIR__."/Footer.php");
?>