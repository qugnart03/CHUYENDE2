<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'NẠP THẺ CÀO | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");

?>
<style type="text/css">

.dBVMxc {
    color: #929292;
    border-color: #929292;
    font-size: 0.7rem !important;
    cursor: default;
    font-weight: 600;
    display: inline-block;
    text-align: center;
    background-size: 105% 80% !important;
    background-position: center !important;
    background-repeat: repeat;
}

@media (min-width: 768px) {
    .md\:h-32 {
        height: 8rem;
    }

    .md\:col-span-3 {
        grid-column: span 3 / span 3;
    }

    .md\:col-span-9 {
        grid-column: span 9 / span 9;
    }
}
</style>
<div class="w-full max-w-6xl mx-auto mt-5 pt-6 md:pt-8 pb-8 md:p-4 bg-box-dark">
    <div
        class="fade-in mb-2 md:mb-4 block uppercase md:py-4 text-center text-yellow-400 md:text-3xl text-2xl font-extrabold text-fill ">
        Hướng Dẫn </div>
    <div class="grid grid-cols-12 gap-4 mb-4">
        <div class="col-span-12 md:col-span-9">
            <div class="my-4">
                <!---->
                <div class="w-full flex flex-col">
                    <?php foreach($SIEUTHICODE->get_list("SELECT * FROM `blogs` WHERE `display` = '1' AND `type`='blog'") as $row):?>
                    <div class="grid grid-cols-12 gap-4 py-2 p-2 md:pr-8 mb-3">
                        <a href="/blog/<?=$row['slug']?>" class="col-span-12 grid grid-cols-12 gap-2">
                            <div class="col-span-12 md:col-span-3">
                                <img alt="<?=$row['title']?>"
                                    src="<?=BASE_URL($row['image']);?>"
                                    class="inset-0 h-56 md:h-32 border p-1 w-full lazyLoad isLoaded ls-is-cached lazyloaded ">
                            </div>
                            <div class="col-span-12 md:col-span-9">
                                <h3
                                    class="hover:text-red-600 text-white transition duration-200 font-semibold text-xl leading-tight">
                                    <?=$row['title']?>
                                </h3>
                                <p class="text-sm text-white uppercase tracking-wide font-semibold mt-2">
                                <?=$row['update_date']?></p>
                            </div>
                        </a>
                    </div>
                   <?php endforeach;?>
                    <!---->
                </div>

            </div>
        </div>
        <div class="col-span-12 md:col-span-3 p-2">
            <h3 class="font-bold text-xl mb-2 text-white">DANH MỤC</h3>
            <div>
                <a href="/Blog" class="hover:text-red-600 text-white transition duration-200">
                    <i class="relative bx bxs-chevrons-right" style="top: 1px"></i> Hướng dẫn </a>
            </div>
        </div>
    </div>
</div>
</div>

<?php 
    require_once("../../public/client/Footer.php");
?>