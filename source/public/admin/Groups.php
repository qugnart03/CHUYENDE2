<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'QUẢN LÝ NHÓM | '.$SIEUTHICODE->site('tenweb');
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


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nhóm chuyên mục <?=$row['title'];?></h1>
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
                            <h3 class="card-title">THÊM NHÓM MỚI</h3>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tên nhóm</label>
                                            <input type="hidden" name="category" value="<?=Anti_xss($_GET['id'])?>" readonly>
                                            <input type="text" name="name_product" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Loại tài khoản</label>
                                            <select class="form-control select2bs4" name="type">
                                                <option value="ACCOUNT">Tài khoản</option>
                                                <option value="RANDOM">Random</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chọn nhãn dán</label>
                                            <select class="form-control select2bs4" name="tag">
                                                <option value="">Không hiển thị</option>
                                                <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `tag` WHERE `id` != '0'") as $info) { ?>
                                                <option value="<?= $info['image'] ?>"><?= $info['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Giá tiền</label>
                                            <input class="form-control" name="cash" type="number"
                                                placeholder="Nếu là vận may thì nhập">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Giao dịch ảo</label>
                                            <input class="form-control" name="fake" type="number"
                                                placeholder="Nhập số lượng giao dịch ảo">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ảnh thumb</label>
                                                <img class="w-100 active" id="img_1"
                                                    src="https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png">
                                                <center>
                                                    <span class="btn btn-default btn-file">
                                                        <input name="thumb" type="file" class="form-control"
                                                            onchange="document.getElementById('img_1').src = window.URL.createObjectURL(this.files[0])">
                                                    </span>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Kiểu dữ liệu:</label>
                                                    <select class="form-control select2bs4" name="data_type[]">
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
                                                    <input class="form-control" name="data_name[]" type="text"
                                                        placeholder="Tên hiển thị">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Giá trị</label>
                                                    <input class="form-control" type="text" name="data_value[]"
                                                        placeholder="Phân cách dữ liệu bằng ký tự |">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Dữ liệu được</label>
                                                    <div class="input-group">
                                                        <select class="form-control select2bs4" name="data_show[]">
                                                            <option value="on">Hiển thị cho người dùng</option>
                                                            <option value="off">Không hiển thị cho người dùng</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success" type="button"
                                                                onclick="add_();"><i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="gift"></div>

                                    <div class="col-md-12">
                                        <label class="col-form-label">Chi tiết nhóm</label>
                                        <div class="form-group">
                                            <textarea name="thele" id="thele"></textarea>
                                            <script>
                                            CKEDITOR.replace('thele'); // tham số là biến name của textarea
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="col-form-label">Hiển thị</label>
                                        <div class="form-group">
                                            <select class="form-control show-tick select2bs4" name="display" required>
                                                <option value="1">SHOW</option>
                                                <option value="0">HIDE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" onclick="Upload()" id="ThemChuyenMuc"
                                        class="btn btn-primary btn-block">
                                        <span>THÊM NGAY</span></button>
                                    <a type="button" href="<?=BASE_URL('Admin/Category');?>"
                                        class="btn btn-danger btn-block waves-effect">
                                        <span>TRỞ LẠI</span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DANH SÁCH NHÓM</h3>
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
                            <div class="table-responsive">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>ẢNH</th>
                                            <th>TÊN NHÓM</th>
                                            <th>GIÁ TRỊ</th>
                                            <th>HIỂN THỊ</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach($SIEUTHICODE->get_list(" SELECT * FROM `groups` WHERE `category` = '".Anti_xss($_GET['id'])."'  ORDER BY id DESC ") as $row){
                                        $detail = json_decode($row['detail'],true);
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td width="10%"><img width="100%" src="<?=BASE_URL($detail['thumb']);?>" /></td>
                                            <td><?=$detail['name_product'];?></td>
                                            <td><?=format_cash($SIEUTHICODE->get_row(" SELECT SUM(`money`) FROM `accounts` WHERE `groups` = '".$row['id']."' ")['SUM(`money`)']);?>
                                            </td>
                                            <td><?=display($row['display']);?></td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="<?=BASE_URL('Admin/Group/Edit/');?><?=$row['id'];?>"><i
                                                        class="fas fa-edit"></i>
                                                    <span>EDIT</span></a>

                                                <a type="button"
                                                    href="<?=BASE_URL('Admin/Accounts/');?><?=$row['id'];?>"
                                                    class="btn btn-info"><i class="fas fa-file-medical"></i>
                                                    <span>DANH SÁCH ACCOUNT</span></a>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
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
var room = 0;

function add_() {
    room++;
    var objTo = document.getElementById('gift');
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "removeclass" + room);
    var rdiv = 'removeclass' + room;
    divtest.innerHTML = `<div class="col-md-12">
                            <div class="row">
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
                            </div>
                        </div>`;
    objTo.appendChild(divtest);
}

function remove(rid) {
    room = rid - 1;
    $('.removeclass' + rid).remove();
}

function Upload() {
    $('#ThemChuyenMuc').html('<i class="fa fa-spinner"></i> Đang xử lý...').prop('disabled',
        true);
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
    $.ajax({
        url: '/Model/CreateGroup',
        type: 'POST',
        dataType: 'JSON',
        data: new FormData($('form#form-data')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            Toast(data.status, data.msg);
            $('#ThemChuyenMuc').html(
                    'THÊM NGAY')
                .prop('disabled', false);
        }
    });
}
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $("#datatable1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $("#datatable2").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>



<?php 
    require_once(__DIR__."/Footer.php");
?>