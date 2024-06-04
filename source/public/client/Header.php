<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/config.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/function.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/config.php');
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title><?=$title;?></title>
    <link rel="icon" type="image/png" href="<?=BASE_URL($SIEUTHICODE->site('favicon'));?>">
    <meta name="description" content="<?=$SIEUTHICODE->site('mota');?>">
    <meta name="keywords" content="<?=$SIEUTHICODE->site('tukhoa');?>">
    <!-- Open Graph data -->
    <meta property="og:title" content="<?=$SIEUTHICODE->site('tenweb');?>">
    <meta property="og:type" content="Website">
    <meta property="og:url" content="<?=BASE_URL('');?>">
    <meta property="og:image" content="<?=$SIEUTHICODE->site('anhbia');?>">
    <meta property="og:description" content="<?=$SIEUTHICODE->site('mota');?>">
    <meta property="og:site_name" content="<?=$SIEUTHICODE->site('tenweb');?>">
    <meta property="article:section" content="<?=$SIEUTHICODE->site('mota');?>">
    <meta property="article:tag" content="<?=$SIEUTHICODE->site('tukhoa');?>">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="<?=$SIEUTHICODE->site('anhbia');?>">
    <meta name="twitter:site" content="@wmt24h">
    <meta name="twitter:title" content="<?=$SIEUTHICODE->site('tenweb');?>">
    <meta name="twitter:description" content="<?=$SIEUTHICODE->site('mota');?>">
    <meta name="twitter:creator" content="@wmt24h">
    <meta name="twitter:image:src" content="<?=$SIEUTHICODE->site('anhbia');?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <link data-n-head="ssr" rel="preconnect" href="https://fonts.gstatic.com">
    <link data-n-head="ssr" rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Goldman&amp;display=swap">
    <link data-n-head="ssr" rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&amp;family=Roboto:wght@900&amp;display=swap">
    <link href="<?=BASE_URL('template/theme/');?>assets/frontend/css/style.css?v=<?=time()?>" rel="stylesheet"
        type="text/css" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="<?=BASE_URL('template/theme/');?>assets/frontend/plugins/jquery/jquery-2.1.0.min.js"></script>
    <script src="<?=BASE_URL('template/theme/');?>assets/frontend/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
    <script src="<?=BASE_URL('template/theme/');?>assets/frontend/plugins/jquery-cookie/jquery.cookie.js"></script>
    <script src="<?=BASE_URL('template/theme/');?>assets/frontend/theme/assets/plugins/js-cookie/js.cookie.js"
        type="text/javascript"></script>
    <script
        src="<?=BASE_URL('template/theme/');?>assets/frontend/theme/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
        type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?=BASE_URL('template/');?>toastify/toastify.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>
    <link rel="stylesheet" href="<?=BASE_URL('template/theme/');?>assets/frontend/css/custom.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=BASE_URL('template/theme/');?>assets/frontend/css/select2.css?v=<?=time()?>">
    <script src="<?=BASE_URL('template/theme/');?>assets/frontend/js/select2.js"></script>
    <?=$SIEUTHICODE->site('javascript_header');?>
</head>
<style>
.new {
    color: #fff !important;
    border-color: hsla(0, 0%, 57.3%, 0) !important;
    background: url(/assets/img/voucher.png);
    padding-left: 0.375rem;
    padding-right: 0.375rem;
}

.eKJDZl {
    color: #929292;
    border-color: #929292;
    font-size: 0.7rem !important;
    padding-left: 0.175rem;
    padding-right: 0.175rem;
    cursor: default;
    font-weight: 600;
    display: inline-block;
    text-align: center;
    background-size: 105% 80% !important;
    background-position: center !important;
    background-repeat: repeat;
}

.stc-Tag {
    padding-left: 0.575rem;
    padding-right: 0.3rem;
    position: absolute;
    right: -1.5rem;
}
</style>