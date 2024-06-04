<?php
require_once "../../config/config.php";
require_once "../../config/function.php";
$title = 'Danh sách trò chơi | ' . $SIEUTHICODE->site('tenweb');
require_once "../../public/admin/Header.php";
require_once "../../public/admin/Sidebar.php";
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh sách trò chơi</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="/Admin/Minigame/Create" class="btn btn-primary">Thêm trò chơi</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `minigame`") as $game):
                $detail = json_decode($game['detail'], true);
                ?>
                <div class="col-md-12">
                    <div class="card card-body">
                        <div class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row"
                            style="display: flex;justify-content: center;align-items: center;">
                            <div class="mr-2 mb-2 mb-lg-0"> <img class="lazyLoad"
                                    data-src="<?=BASE_URL($detail['thumb'])?>" src="<?=BASE_URL($detail['thumb'])?>"
                                    width="250" height="150" alt=""> </div>
                            <div class="media-body">
                                <h6 class="media-title font-weight-semibold"> <a href="#"><?=$detail['name_product']?></a> </h6>
                                <p class="mb-3">
                                    <?php
                                        for ($i = 0; $i < count($detail['data']); $i++) {
                                            if ($game['type'] == 'ACCOUNT' || $game['type'] == 'RANDOM') {
                                                echo $detail['data'][$i]['label'];
                                                echo ', ';
                                            } else {
                                                $kc = $detail['data'][$i]['tyle_value'];
                                                echo str_replace('...', $kc, $detail['data'][$i]['tyle_text']);
                                                echo ', ';
                                            }
                                        }
                                    ?>
                                </p>
                            </div>
                            <div class="mt-3 mt-lg-0 ml-lg-3 text-center">
                                <h3 class="mb-0 font-weight-semibold"><?=number_format($detail['cash'])?><sup>đ</sup>
                                </h3>
                                <a href="/Admin/Minigame/Edit/<?=$game['id']?>"
                                    class="btn btn-warning mt-2 text-white"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-danger mt-2 text-white"
                                    onclick="delete_id(<?=$game['id']?>)"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script>
function delete_id(id) {
    let text = "Bạn có chắc muốn thực hiện thao tác này không?";
    if (confirm(text) == true) {
        $.ajax({
            url: '/ajaxs/minigame/Delete.php',
            type: 'POST',
            dataType: 'json',
            data: {
                id
            },
            success: function(data) {
                Toast(data.status, data.msg);
            }
        });
    }
}
</script>



<?php
require_once "./Footer.php";
?>