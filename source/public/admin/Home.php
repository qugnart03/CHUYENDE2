<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'DASHBROAD | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/admin/Header.php");
    require_once("../../public/admin/Sidebar.php");
    //active_license();
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="alert alert-dark">
                <button type="button" class="close" data-dismiss="alert">×</button>
               
                <ul>
                    <li>09/06/2023 - Cập nhật game Bingo 3</li>
                    <li>09/06/2023 - Cập nhật game Mở quà</li>
                    <li>11/06/2023 - Cập nhật chức năng rút kim cương</li>
                    <li>14/06/2023 - Cập nhật chức năng tìm kiếm tài khoản đa danh mục, làm mới nhóm account game</li>
                    <li>19/06/2023 - Cập nhật chức năng tài khoản trả thưởng cho minigame</li>
                </ul>
                <i>Hệ thống tự động cập nhật phiên bản mới nhất khi vào trang Quản Trị.</i>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Thành viên</span>
                            <span class="info-box-number"><?=$SIEUTHICODE->num_rows("SELECT * FROM `users` ");?></span>
                        </div>

                    </div>

                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Số dư thành viên</span>
                            <span
                                class="info-box-number"><?=format_cash($SIEUTHICODE->get_row("SELECT SUM(`money`) FROM `users` ")['SUM(`money`)']);?>đ</span>
                        </div>

                    </div>

                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-store"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tài khoản đang bán</span>
                            <span
                                class="info-box-number"><?=format_cash($SIEUTHICODE->num_rows("SELECT * FROM `accounts` WHERE `status` = 'on' "));?></span>
                        </div>

                    </div>

                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-store"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tài khoản đã bán</span>
                            <span
                                class="info-box-number"><?=format_cash($SIEUTHICODE->num_rows("SELECT * FROM `history_buy`"));?></span>
                        </div>

                    </div>

                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-money-bill-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tiền đã bán</span>
                            <span
                                class="info-box-number"><?=format_cash($SIEUTHICODE->get_row("SELECT SUM(`cash`) FROM `history_buy`")['SUM(`cash`)']);?>đ</span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Sơ đồ doanh thu trong tháng <?= date('m', time()); ?></h3>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>

                        </div>

                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê thể loại nạp</h3>

                        </div>
                        <div class="card-body">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="pieChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DÒNG TIỀN</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>USERNAME</th>
                                            <th>SỐ TIỀN TRƯỚC</th>
                                            <th>SỐ TIỀN THAY ĐỔI</th>
                                            <th>SỐ TIỀN HIỆN TẠI</th>
                                            <th>THỜI GIAN</th>
                                            <th>NỘI DUNG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach($SIEUTHICODE->get_list(" SELECT * FROM `dongtien` ORDER BY id DESC ") as $row){
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><a
                                                    href="<?=BASE_URL('Admin/User/Edit/'.$SIEUTHICODE->getUser($row['username'])['id']);?>"><?=$row['username'];?></a>
                                            </td>
                                            <td><?=format_cash($row['sotientruoc']);?></td>
                                            <td><?=format_cash($row['sotienthaydoi']);?></td>
                                            <td><?=format_cash($row['sotiensau']);?></td>
                                            <td><span class="badge badge-dark"><?=$row['thoigian'];?></span></td>
                                            <td><?=$row['noidung'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>USERNAME</th>
                                            <th>SỐ TIỀN TRƯỚC</th>
                                            <th>SỐ TIỀN THAY ĐỔI</th>
                                            <th>SỐ TIỀN HIỆN TẠI</th>
                                            <th>THỜI GIAN</th>
                                            <th>NỘI DUNG</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>





<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>


<?php 
   require_once(__DIR__ . '/Footer.php');
?>
<script>
function formatCurrency(value) {
    return value.toLocaleString('vi-VN', {
        style: 'currency',
        currency: 'VND'
    });
}
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            <?php
                $month = date('m');
                $year = date('Y');
                $numOfDays = custom_cal_days_in_month($month, $year);

                for ($day = 1; $day <= $numOfDays; $day++) {
                    echo "\"$day/$month/$year\",";
                }
                ?>
        ],
        datasets: [{
            label: 'NẠP TIỀN',
            data: [
                <?php
                    $data = [];
                    for ($day = 1; $day <= $numOfDays; $day++) {
                        $date = "$year-$month-$day";
                        $row = $SIEUTHICODE->get_row("SELECT SUM(`amount`) FROM `bank_auto` WHERE DATE(time) = '$date'");
                        $data[$day - 1] = $row['SUM(`amount`)'];
                    }
                    for ($i = 0; $i < $numOfDays; $i++) {
                        echo "$data[$i],";
                    }
                    ?>
            ],
            backgroundColor: [
                'rgb(255 239 201)'
            ],
            borderColor: [
                'rgb(255 193 5)'
            ],
            borderWidth: 1
        }, ]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    return formatCurrency(tooltipItem.yLabel);
                }
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function(value, index, values) {
                        return formatCurrency(value);
                    }
                }
            }]
        }
    }
});
</script>
<script>
var donutData = {
    labels: [
        'Nạp Thẻ',
        'Nạp Bank',
        'Nạp Momo'
    ],
    datasets: [{
        data: [<?= $SIEUTHICODE->num_rows("SELECT * FROM `cards` WHERE `status` = 'hoantat'"); ?>,
            <?= $SIEUTHICODE->num_rows("SELECT * FROM `bank_auto`"); ?>,
            <?= $SIEUTHICODE->num_rows("SELECT * FROM `momo`");?>
        ],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12'],
    }]
}
var donutOptions = {
    maintainAspectRatio: false,
    responsive: true,
}
var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
var pieData = donutData;
var pieOptions = {
    maintainAspectRatio: false,
    responsive: true,
}
//Create pie or douhnut chart
// You can switch between pie and douhnut using the method below.
new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
})
</script>