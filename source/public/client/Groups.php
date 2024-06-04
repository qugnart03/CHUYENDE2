<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'DANH MỤC | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
?>
<?php

if(isset($_GET['id']))
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

<div class="v-theme">
    <div class="pb-10">
        <div class="v-card w-full max-w-6xl mx-auto">
            <div class="md:mx-0">
                <div class="py-2">
                    <div class="mb-16">
                        <div class="mb-4 py-4 md:p-4 bg-box-dark">
                            <div class="mb-6 block">
                                <div
                                    class="fade-in py-2 block uppercase md:py-4 text-center md:text-3xl text-2xl font-extrabold text-yellow-400 text-fill">
                                    Danh Mục <?=$row['title'];?>
                                </div>
                                <div class="mb-2"><span class="mx-auto block w-40 border-2 border-red-500"></span></div>
                            </div>
                            <div class="fade-in grid grid-cols-8 gap-2 px-2 md:px-0">
                                <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `groups` WHERE `display` = '1' AND `category` = '".Anti_xss($_GET['id'])."'  ") as $group) { 
                                $detail = json_decode($group['detail'],true);
                                $count_account_groups = 0;
                                    $acc = $SIEUTHICODE->get_row("SELECT COUNT(*) AS total FROM `accounts` WHERE `groups` = '".$group['id']."' AND `status`='on'");
                                    if ($acc !== null && isset($acc['total'])) {
                                        $count_account_groups = $acc['total'];
                                    }  
                                ?>
                                <div class="hover:shadow-lg card-stc col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2 xl:col-span-2 relative rounded border border-gray-300">
                                    <!---->
                                    <a href="<?=BASE_URL('Accounts/'.$group['id']);?>">
                                        <?php if($detail['tag'] != ''):?>
                                        <div class="stc-Tag"> <img class="lazyLoad" src="<?=BASE_URL($detail['tag'])?>">
                                        </div>
                                        <?php endif;?>
                                        <img data-src="<?=BASE_URL($detail['thumb']);?>"
                                            src="<?=BASE_URL('');?>/assets/img/index.svg"
                                            class="rounded-t h-28 md:h-48 w-full object-fill object-center lazyLoad" />
                                        <div class="py-1">
                                            <div class="py-1 font-bold text-md px-1 truncate text-center uppercase"
                                                style="color: rgb(247, 176, 60);">
                                                <?=$detail['name_product'];?>
                                            </div>
                                            <ul
                                                class="px-2 flex items-center justify-center font-medium rounded-sm w-full font-medium text-white">
                                                <span>
                                                    Số tài khoản:
                                                    <b>
                                                        <?=$count_account_groups?>
                                                    </b>
                                                </span>
                                                <!---->
                                            </ul>
                                            <div class="flex px-2 mt-2 justify-center">
                                                <!---->
                                                <!---->
                                            </div>
                                            <div class="mt-2 mb-2 px-2 py-1 flex items-center justify-center">
                                                <a class="focus:outline-none acc-lien-minh-tu-chon-bb2716012b"
                                                    href="<?=BASE_URL('Accounts/'.$group['id']);?>">
                                                    <div>
                                                        <style scoped="">
                                                        .acc-lien-minh-tu-chon-bb2716012b:hover {
                                                            filter: brightness(130%);
                                                        }
                                                        </style>
                                                    </div> <img src="/assets/img/btn_mua.png" class="lazyLoad isLoaded">
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php }?>
                                <!--LIÊN QUÂN-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php 
    require_once("../../public/client/Footer.php");
?>