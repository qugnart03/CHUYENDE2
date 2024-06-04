<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'DASHBROAD | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/ctv/Header.php");
    require_once("../../public/ctv/Sidebar.php");
    $dataSumary = $SIEUTHICODE->get_list("SELECT * FROM `history_buy` WHERE `username_post` = '".$getUser['username']."'");
    $totalTransactions = 0;
    $totalAmount = 0;
    $totalAmountReal = 0;
    foreach ($dataSumary as $transaction) {
        $totalAmount += $transaction['cash'];
        $totalAmountReal += $transaction['cash'] - $transaction['cash'] * $SIEUTHICODE->site('chietkhau_banacc') / 100;
        $totalTransactions++;
    }
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
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4>Doanh thu(đ)</h4>
                    <h1><?=format_cash($totalAmountReal)?></h1>
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
                                    foreach($SIEUTHICODE->get_list(" SELECT * FROM `dongtien` WHERE `username`='".$getUser['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><a
                                                    ><?=$row['username'];?></a>
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