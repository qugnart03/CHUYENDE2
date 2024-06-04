<style>
.btn-warning {
    background: -webkit-linear-gradient(bottom, #FFE900 0%, #F2AC00 100%) !important;
}

.h-36 {
    height: 8rem;
}

@media screen and (min-width: 1024px) {
    #dropdown-menu {
        width: 450%;
        max-width: 1200px;
    }
}

@media (max-width: 600px) {
    .hidden-mobile {
        display: none;
    }
}

.open {
    display: block !important;
}

.text-warning {
    color: #FBBF24;
}


body {
    background: url(<?=BASE_URL($SIEUTHICODE->site('background'));
    ?>) 0 / cover fixed;
    background-repeat: no-repeat;
}

.header-sticky {
    background: rgb(26 26 26);
}

.header-style {
    background: rgb(26 26 26);
    color: white;
}

.card-stc {
    padding: 1px;
    padding: 1px;
    border: 3px solid white;
}

.btn-cash {
    color: #2fd6da;
    border-color: #2fd6da;
    color: #2fd6da;
    text-decoration: line-through;
    color: #2fd6da;
    border: 2px solid;
    font-weight: bold;
}

.btn-sale {
    color: #ffd200;
    border-color: #ffd200;
}
</style>

<body>
    <div class="select-none" style="height: auto;min-height: 100vh;">
        <div class="sticky top-0 z-100 header-sticky">
            <div class="shadow">
                <header
                    class="relative header-style mx-auto w-full max-w-6xl px-2 md:px-0 flex flex-wrap items-center md:py-1 py-2">
                    <div class="flex-1 flex justify-between items-center">
                        <a href="<?=BASE_URL('');?>"><img width="231" height="60"
                                src="<?=BASE_URL($SIEUTHICODE->site('logo_dark'));?>" class="v-logo"></a>
                    </div>
                    <?php if(empty($_SESSION['username'])) { ?>
                    <a href="<?=BASE_URL('Auth/Login');?>"
                        class="lg:hidden flex btn-warning text-black mx-2 px-3 h-8 border-gray-400 rounded items-center font-bold justify-center pointer-cursor">
                        Đăng nhập
                    </a>
                    <a href="<?=BASE_URL('Auth/Register');?>"
                        class="lg:hidden flex btn-warning text-black mx-2 px-3 h-8 border-gray-400 rounded items-center font-bold justify-center pointer-cursor">
                        Đăng ký
                    </a>
                    <?php } else { ?>
                    <!-- <a href="<?=BASE_URL('Auth/Profile');?>"
                        class="lg:hidden relative mx-2 flex btn-warning text-black px-3 h-8 border-gray-400 rounded items-center font-bold justify-center pointer-cursor nuxt-link-exact-active nuxt-link-active"><span
                            class="block"><i class="fa fa-user" aria-hidden="true"></i>
                            <?=$_SESSION['username'];?> - <?=format_cash($getUser['money']);?></span></a> -->
                    <div class="relative dropdown-profile">
                        <button
                            class="lg:hidden relative mx-2 flex btn-warning text-black px-3 h-8 border-gray-400 rounded items-center font-bold justify-center pointer-cursor nuxt-link-exact-active nuxt-link-active">
                            <span><i class="fa fa-user" aria-hidden="true"></i>
                                <?=$_SESSION['username'];?> - <?=format_cash($getUser['money']);?>

                        </button>
                        <div class="absolute max-w-md w-64 rounded bg-gray-700 shadow-lg dropdown-content"
                            style="display: none; top: 46px; z-index: 2; right: 0px;">
                            <div class="w-64">
                                <div class="border-b border-gray-100 grid grid-cols-12 gap-2 p-2">
                                    <div
                                        class="col-span-3 sm:col-span-3 md:col-span-3 lg:col-span-3 xl:col-span-3 flex items-center justify-content">
                                        <img class="w-full rounded-full" src="/assets/img/avt.jpg" />
                                    </div>
                                    <div class="col-span-8 sm:col-span-9 md:col-span-9 lg:col-span-9 xl:col-span-9">
                                        <p class="text-gray-200 hover:bg-gray-800 hover:text-white"><b>ID:</b>
                                            <?=$getUser['id']?></p>
                                        <p class="text-gray-200 hover:bg-gray-800 hover:text-white"><b>User:</b>
                                            <?=$getUser['username']?></p>
                                        <p class="text-gray-200 hover:bg-gray-800 hover:text-white"><b>Số dư:</b> <span
                                                class="text-warning font-bold"><?=format_cash($getUser['money'])?>đ</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-sm">

                                    <?php if($getUser['level'] == 'admin'):?>
                                    <span class="mt-2 text-warning font-bold text-sm block px-3">
                                        HỆ THỐNG
                                    </span>

                                    <div class="px-2">
                                        <a href="/Admin"
                                            class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                            Admin Dashboard</a>
                                    </div>

                                    <?php endif;?>
                                    <span class="mt-2 text-warning font-bold text-sm block px-3">
                                        TÀI KHOẢN
                                    </span>
                                    <div class="px-2">
                                        <a href="/Auth/Profile"
                                            class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                            Thông tin chung</a>
                                    </div>
                                    <span class="text-warning font-bold text-sm my-1 block px-3">
                                        <i class="relative bx bxs-dollar-circle" style="top:1px;"></i>
                                        NẠP TIỀN & RÚT VẬT PHẨM
                                    </span>
                                    <div class="px-2">
                                        <a href="/nap-the-cao"
                                            class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3">
                                            <i class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                            Nạp thẻ cào (tự động)
                                        </a>
                                        <!--<a href="/user/diamond"-->
                                        <!--    class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3">-->
                                        <!--    <i class="relative bx bx-chevron-right" style="top: 1px;"></i>-->
                                        <!--    Rút kim cương-->
                                        <!--</a>-->
                                    </div>
                                    <span class="text-warning font-bold text-sm my-1 block px-3">
                                        LỊCH SỬ
                                    </span>
                                    <div class="px-2">
                                        <a href="/History/Minigame"
                                            class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                            Lịch sử chơi game</a>
                                        <a href="/History"
                                            class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                            Lịch sử mua nick</a>
                                        <a href="/History/Cay-thue"
                                            class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                            Lịch sử dịch vụ</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php }?>
                    <label for="menu-toggle" id="toggle" class="pointer-cursor text-white-800 text-2xl lg:hidden block">
                        <span class="h-8 w-8 border border-gray-400 justify-center items-center inline-flex rounded"><i
                                class="bx bx-menu"></i></span>
                    </label>
                    <div  class="hidden mt-2 md:mt-0 lg:flex lg:items-center lg:w-auto w-full" id="menu-toggle">
                        <nav class="font-bold lg:text-lg">
                            <ul class="lg:flex items-center justify-between text-base text-white-800 lg:pt-0">
                                <li><a href="<?=BASE_URL('');?>" class="lg:p-3 py-1 lg:py-2 px-2 lg:px-3 block">TRANG
                                        CHỦ</a></li>
                                <li class="relative" style="display: none">
                                    <a class="cursor-pointer lg:p-3 py-1 lg:py-2 px-2 lg:px-3 block"
                                        id="menu-toggle-dropdown">DANH MỤC GAME <i
                                            class="ml-1 bx bx-chevron-down"></i></a>

                                    <ul id="dropdown-menu"
                                        class="absolute navbar-dropdown top-14 hidden text-gray-700 w-full p-2 grid grid-cols-12 gap-3 bg-gray-800 z-50 overflow-y-auto"
                                        style="height: 24rem;">
                                        <?php foreach ($SIEUTHICODE->get_list("SELECT * FROM `category` WHERE `display` = '1' ") as $category):?>
                                        <li class="col-span-6 sm:col-span-4 md:col-span-3 lg:col-span-3 xl:col-span-4">
                                            <a href="<?=BASE_URL('Groups/' . $category['id']);?>"
                                                class="text-sm bg-white font-semibold text-gray-200 hover:bg-red-600 hover:text-white py-2 px-2 block whitespace-no-wrap"><img
                                                    class="w-full h-36 lazyLoad isLoaded"
                                                    data-src="<?=BASE_URL($category['img']);?>"
                                                    src="<?=BASE_URL('');?>/assets/img/index.svg">
                                                <div class="bg-red-600 mt-1 px-1">
                                                    <p class="truncate py-1 text-white uppercase">
                                                        <?=$category['title'];?>
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </li>
                                <li class="relative inline-block">
                                    <a href="javascript:" class="lg:p-3 py-1 lg:py-2 px-2 lg:px-3 block"
                                        id="menu-toggle1">
                                        NẠP TIỀN <i class="ml-1 bx bx-chevron-down"></i>
                                    </a>

                                    <ul id="dropdown-menu1" class="absolute hidden mt-[-5px] py-1 text-white-700 left-0"
                                        style="width: 250px;">
                                        <li><a class="block px-4 py-2 text-sm bg-gray-700 font-semibold text-gray-200 hover:bg-gray-800 hover:text-white"
                                                href="<?=BASE_URL('nap-the-cao');?>"><i
                                                    class="bx bx-chevron-right"></i>NẠP TIỀN QUA THẺ CÀO</a>
                                        </li>
                                        <li><a class="block px-4 py-2 text-sm bg-gray-700 font-semibold text-gray-200 hover:bg-gray-800 hover:text-white"
                                                href="<?=BASE_URL('nap-bank');?>"><i class="bx bx-chevron-right"></i>NẠP
                                                TIỀN QUA ATM /
                                                MOMO</a></li>
                                    </ul>
                                </li>
                                <li class="relative inline-block">
                                    <a href="javascript:" class="lg:p-3 py-1 lg:py-2 px-2 lg:px-3 block"
                                        id="menu-toggle2">
                                        HƯỚNG DẪN <i class="ml-1 bx bx-chevron-down"></i>
                                    </a>
                                    <ul id="dropdown-menu2" class="absolute hidden mt-[-5px] py-1 text-white-700 left-0"
                                        style="width: 250px;">
                                        <li><a class="block px-4 py-2 text-sm bg-gray-700 font-semibold text-gray-200 hover:bg-gray-800 hover:text-white"
                                                href="<?=BASE_URL('Blogs');?>"><i class="bx bx-chevron-right"></i>Blog
                                                tin tức</a>
                                        </li>
                                        <li><a class="block px-4 py-2 text-sm bg-gray-700 font-semibold text-gray-200 hover:bg-gray-800 hover:text-white"
                                                href="<?=$SIEUTHICODE->site('facebook');?>"><i
                                                    class="bx bx-chevron-right"></i>Liên hệ ADMIN</a></li>
                                    </ul>
                                </li>


                                <?php if(isset($_SESSION['username']) && $getUser['level'] == 'ctv') { ?>
                                <li><a target="_blank" href="<?=BASE_URL('Ctv/Home');?>"
                                        class="lg:p-3 py-1 lg:py-2 px-2 lg:px-3 block">PANEL CTV</a></li>
                                <?php }?>
                                <?php if(isset($_SESSION['username']) && $getUser['level'] == 'admin') { ?>
                                <li><a target="_blank" href="<?=BASE_URL('Admin/Home');?>"
                                        class="lg:p-3 py-1 lg:py-2 px-2 lg:px-3 block">PANEL ADMIN</a></li>
                                <?php }?>
                                <?php if(empty($_SESSION['username'])) { ?>
                                <a href="<?=BASE_URL('Auth/Login');?>"
                                    class="lg:ml-4 btn-warning flex px-3 h-8 border-gray-400 rounded items-center text-black font-bold justify-center lg:mb-0 mb-2 pointer-cursor"><span
                                        class="block"><i class="relative bx bxs-user mr-2"></i>Đăng nhập</span></a>
                                <a href="<?=BASE_URL('Auth/Register');?>"
                                    class="lg:ml-4 flex btn-warning px-3 h-8 border-gray-400 rounded items-center text-black font-bold justify-center lg:mb-0 mb-2 pointer-cursor"><span
                                        class="block"><i class="relative bx bxs-user-plus mr-2"></i> Đăng ký</span></a>
                                <?php } else { ?>
                                <div class="relative dropdown-profile">
                                    <button
                                        class="lg:ml-4 hidden-mobile flex btn-warning px-3 h-8 rounded items-center text-black font-bold justify-center lg:mb-0 mb-2 pointer-cursor">
                                        <span><i class="fa fa-user" aria-hidden="true"></i>
                                            <?=$_SESSION['username'];?> - <?=format_cash($getUser['money']);?>

                                    </button>
                                    <div class="absolute max-w-md w-64 rounded bg-gray-700 shadow-lg dropdown-content"
                                        style="display: none; top: 46px; z-index: 2; right: 0px;">
                                        <div class="w-64">
                                            <div class="border-b border-gray-100 grid grid-cols-12 gap-2 p-2">
                                                <div
                                                    class="col-span-3 sm:col-span-3 md:col-span-3 lg:col-span-3 xl:col-span-3 flex items-center justify-content">
                                                    <img class="w-full rounded-full" src="/assets/img/avt.jpg" />
                                                </div>
                                                <div
                                                    class="col-span-8 sm:col-span-9 md:col-span-9 lg:col-span-9 xl:col-span-9">
                                                    <p class="text-gray-200 hover:bg-gray-800 hover:text-white">
                                                        <b>ID:</b> <?=$getUser['id']?>
                                                    </p>
                                                    <p class="text-gray-200 hover:bg-gray-800 hover:text-white">
                                                        <b>User:</b> <?=$getUser['username']?>
                                                    </p>
                                                    <p class="text-gray-200 hover:bg-gray-800 hover:text-white"><b>Số
                                                            dư:</b> <span
                                                            class="text-warning font-bold"><?=format_cash($getUser['money'])?>đ</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-sm">

                                                <?php if($getUser['level'] == 'admin'):?>
                                                <span class="mt-2 text-warning font-bold text-sm block px-3">
                                                    HỆ THỐNG
                                                </span>

                                                <div class="px-2">
                                                    <a href="/Admin"
                                                        class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                            class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                                        Admin Dashboard</a>
                                                </div>

                                                <?php endif;?>
                                                <span class="mt-2 text-warning font-bold text-sm block px-3">
                                                    TÀI KHOẢN
                                                </span>
                                                <div class="px-2">
                                                    <a href="/Auth/Profile"
                                                        class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                            class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                                        Thông tin chung</a>
                                                </div>
                                                <span class="text-warning font-bold text-sm my-1 block px-3">
                                                    <i class="relative bx bxs-dollar-circle" style="top:1px;"></i>
                                                    NẠP TIỀN & RÚT VẬT PHẨM
                                                </span>
                                                <div class="px-2">
                                                    <a href="/nap-the-cao"
                                                        class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3">
                                                        <i class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                                        Nạp thẻ cào (tự động)
                                                    </a>
                                                    <a style="display: none" href="/user/diamond"
                                                        class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3">
                                                        <i class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                                        Rút kim cương
                                                    </a>
                                                </div>
                                                <span class="text-warning font-bold text-sm my-1 block px-3">
                                                    LỊCH SỬ
                                                </span>
                                                <div class="px-2">
                                                    <a href="/History/Minigame"
                                                        class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                            class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                                        Lịch sử chơi game</a>
                                                    <a href="/History"
                                                        class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                            class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                                        Lịch sử mua nick</a>
                                                    <a href="/History/Cay-thue"
                                                        class="font-semibold text-gray-200 hover:bg-gray-800 hover:text-white block py-1 px-3"><i
                                                            class="relative bx bx-chevron-right" style="top: 1px;"></i>
                                                        Lịch sử dịch vụ</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a onclick="openModal('modalLogout')" href="javascript:"
                                    class="lg:ml-4 flex btn-warning px-3 h-8 border-gray-400 rounded items-center text-black font-bold justify-center lg:mb-0 mb-2 pointer-cursor"><span><i
                                            class="fa fa-sign-out" aria-hidden="true"></i> Đăng
                                        xuất</span></a>
                                <?php }?>
                            </ul>
                        </nav>
                    </div>
                </header>
            </div>
        </div>
        <?php
        if(isset($_SESSION['username']))
        {
            if($getUser['banned'] == 1)
            {
                session_destroy();
                msg_warning("Tài khoản của bạn đã bị khóa.", "", 5000);
            }
            if($getUser['level'] != 'admin')
            {
                if($SIEUTHICODE->site('baotri') == 'OFF')
                {
                    msg_warning("Hệ thống đang bảo trì định kỳ", "", 10000);
                }
            }
        }
        else
        {
            if($SIEUTHICODE->site('baotri') == 'OFF')
            {
                msg_warning("Hệ thống đang bảo trì định kỳ", "", 10000);
            }
        }
        