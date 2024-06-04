<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'NẠP THẺ CÀO | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    if(isset($_GET['id']))
    {
        $row = $SIEUTHICODE->get_row(" SELECT * FROM `blogs` WHERE `slug` = '".Anti_xss($_GET['id'])."'  ");
        if(!$row)
        {
            die('<script type="text/javascript">if(!alert("Liên kết không tồn tại !")){location.href = "/";}</script>');
        }
        $SIEUTHICODE->cong("blogs", "view", 1, " `id` = '".$row['id']."' ");
    }
    else
    {
        die('<script type="text/javascript">if(!alert("Liên kết không tồn tại !")){location.href = "/";}</script>');
    }
?>

<div class="w-full max-w-6xl mx-auto mt-5 pt-6 md:pt-8 pb-8 md:p-4 bg-box-dark">
    <div
        class="fade-in mb-2 md:mb-4 block uppercase md:py-4 p-2 text-yellow-400 md:text-3xl text-2xl font-extrabold text-fill ">
        <?=$row['title']?> </div>
    <div class="my-2 flex items-center text-white font-medium p-2">
        <div>
            <a href="/Blog" class="hover:text-red-600"> <i class="relative bx bxs-book-open" style="top: 1px;"></i>
                Blog</a>
        </div>
        <span class="mx-3">-</span>
        <div><i class="relative bx bx-time-five" style="top: 1px;"></i><?=$row['update_date']?></div>
    </div>
    <div class="grid grid-cols-12 gap-4 mb-4 p-2">
        <div class="col-span-12">
            <div class="my-4 text-white">
                <?=base64_decode($row['content'])?>
            </div>
        </div>

    </div>
</div>
</div>

<?php 
    require_once("../../public/client/Footer.php");
?>