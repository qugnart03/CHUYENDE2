<style>
[class*=sidebar-dark-] .nav-header {
    background-color: inherit;
    color: #fff !important;
}
</style>

<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?=BASE_URL('');?>" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="https://www.facebook.com/nguyennhatloc" class="nav-link">Liên hệ</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?=BASE_URL('Admin/Home');?>" class="brand-link">
                <img src="<?=BASE_URL($SIEUTHICODE->site('logo_dark'));?>" alt="<?=$SIEUTHICODE->site('tenweb');?>"
                    width="100%">

            </a>
            <!-- Sidebar -->
            <div class="sidebar" style="overflow-y: auto;">
                <!-- Sidebar user panel (optional) -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="<?=BASE_URL('Admin/Home');?>" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>


                        <li class="nav-header">MINIGAME</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-gamepad"></i>
                                <p>
                                    Minigame
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="/Admin/Minigame/Create" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Thêm trò chơi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/Admin/Minigame/List" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh sách trò chơi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/Admin/Minigame/ListAccountMiniGame" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh tài khoản trả thưởng</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Category');?>" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Danh mục game
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Category/Cay-thue');?>" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Danh mục cày thuê
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Tool game dịch vụ
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <!--<ul class="nav nav-treeview" style="display: none;">-->
                            <!--    <li class="nav-item">-->
                            <!--        <a href="#" class="nav-link">-->
                            <!--            <i class="far fa-circle nav-icon"></i>-->
                            <!--            <p>-->
                            <!--                Bán vàng - NRO LẬU-->
                            <!--                <i class="right fas fa-angle-left"></i>-->
                            <!--            </p>-->
                            <!--        </a>-->
                            <!--        <ul class="nav nav-treeview" style="display: none;">-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrocoinlau-info-bot" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Cấu hình danh mục</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrocoinlau-usernap" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Cấu hình mua vàng</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrocoinlau-logtransaction" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Thống kê giao dịch</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <li class="nav-item">-->
                            <!--        <a href="#" class="nav-link">-->
                            <!--            <i class="far fa-circle nav-icon"></i>-->
                            <!--            <p>-->
                            <!--                Bán vàng - NRO-->
                            <!--                <i class="right fas fa-angle-left"></i>-->
                            <!--            </p>-->
                            <!--        </a>-->
                            <!--        <ul class="nav nav-treeview" style="display: none;">-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrocoin-info-bot" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Thông tin bot</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrocoin-usernap" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Cấu hình mua vàng</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrocoin-logtransaction" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Thống kê giao dịch</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <li class="nav-item">-->
                            <!--        <a href="#" class="nav-link">-->
                            <!--            <i class="far fa-circle nav-icon"></i>-->
                            <!--            <p>-->
                            <!--                Bán ngọc - NRO-->
                            <!--                <i class="right fas fa-angle-left"></i>-->
                            <!--            </p>-->
                            <!--        </a>-->
                            <!--        <ul class="nav nav-treeview" style="display: none;">-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrogem-info-bot" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Thông tin bot</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrogem-usernap" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Cấu hình mua ngọc</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrogem-logtransaction" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Thống kê giao dịch</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <li class="nav-item">-->
                            <!--        <a href="#" class="nav-link">-->
                            <!--            <i class="far fa-circle nav-icon"></i>-->
                            <!--            <p>-->
                            <!--                Bán ngọc - NRO - API-->
                            <!--                <i class="right fas fa-angle-left"></i>-->
                            <!--            </p>-->
                            <!--        </a>-->
                            <!--        <ul class="nav nav-treeview" style="display: none;">-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrogem-api-info-bot" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Thông tin bot</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrogem-api-usernap" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Cấu hình mua ngọc</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="/Admin/toolgame/nrogem-api-logtransaction" class="nav-link">-->
                            <!--                    <i class="far fa-dot-circle nav-icon"></i>-->
                            <!--                    <p>Thống kê giao dịch</p>-->
                            <!--                </a>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--    </li>-->

                            <!--</ul>-->
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Event');?>" class="nav-link">
                                <i class="nav-icon fas fa-gift"></i>
                                <p>
                                    Sự kiện
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Blog');?>" class="nav-link">
                                <i class="nav-icon fas fa-blog"></i>
                                <p>
                                    Bài Viết
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Tag');?>" class="nav-link">
                                <i class="nav-icon fas fa-tag"></i>
                                <p>
                                    Nhãn Dán
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">QUẢN LÝ NẠP TIỀN TỰ ĐỘNG</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-credit-card"></i>
                                <p>
                                    Nạp thẻ tự động
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" ">
                                <li class="nav-item">
                                    <a href="/Admin/Telecom" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cài đặt nạp thẻ tự động</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/Admin/Charge-report" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Thống kê nạp thẻ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-university"></i>
                                <p>
                                    Nạp Ví - ATM tự động
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="/Admin/Bank" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cấu hình nạp ATM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/Admin/Bank/Transaction" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Thống kê nạp tiền</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">QUẢN LÝ GIAO DỊCH</li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Orders/Cay-thue');?>" class="nav-link">
                                <i class="nav-icon fas fa-cart-plus"></i>
                                <p>
                                    Đơn hàng cày thuê <span
                                        class="badge badge-info right"><?=$SIEUTHICODE->num_rows("SELECT * FROM `orders_caythue` WHERE `status` = 'xuly' ");?></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Account-Sold');?>" class="nav-link">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Tài khoản đã bán
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Giao dịch
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="/Admin/History/Event" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử nhận Event</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/Admin/History/Diamond" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Rút kim cương/quân huy</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>
                                    Rút tiền CTV 
                                    <i class="fas fa-angle-left right"></i>
                                    <span
                                        class="badge badge-info right"><?=$SIEUTHICODE->num_rows("SELECT * FROM `withdraw_ctv` WHERE `status` = '0' ");?></span>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="/Admin/WithdrawCTV/Orders" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn rút tiền</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/Admin/WithdrawCTV/Config" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cấu hình</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Storage');?>" class="nav-link">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>
                                    Lưu trữ
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">TÀI KHOẢN</li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Users');?>" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Danh sách thành viên
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">HỆ THỐNG</li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Theme');?>" class="nav-link">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Giao diện
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('Admin/Setting');?>" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Cấu hình
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>