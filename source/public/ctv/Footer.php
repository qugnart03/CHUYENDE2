<div id="thongbao"></div>
<style>
    .back-to-top {
    bottom: 4rem;
    position: fixed;
    right: 1.25rem;
    z-index: 1032;
}
</style>
<a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
</a>
<script>
$(function() {
    var url = window.location.pathname,
        urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
    $('ul li a').each(function() {
        if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
            var href = $(this).parents().eq(0).attr('id');
            $(this).addClass('nav-link active');
            $('#' + href).addClass('nav-link active');
            Checkhref(href);
        }
    });

    function Checkhref(href) {
        $('ul li a').each(function() {
            if ($(this).attr('href') == "#" + href) {
                $(this).addClass('nav-link active');
            }
        });
    }
});
$(function() {
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo2"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
});
</script>
<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">

        <div id="google_translate_element"></div>
        <script type="text/javascript">
        // <![CDATA[
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'vi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
        // ]]>
        </script>
        <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"
            type="text/javascript"></script>

    </div>
    <b><strong>Powered By <a href="" target="_blank">SIEUTHICODE.NET</a></strong>
</footer>
<!-- jQuery -->

<!-- jQuery UI 1.11.4 -->
<script src="<?=BASE_URL('template/');?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=BASE_URL('template/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?=BASE_URL('template/');?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=BASE_URL('template/');?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?=BASE_URL('template/');?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=BASE_URL('template/');?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=BASE_URL('template/');?>plugins/moment/moment.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=BASE_URL('template/');?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
</script>
<!-- Summernote -->
<script src="<?=BASE_URL('template/');?>plugins/summernote/summernote-bs4.min.js"></script>

<!-- AdminLTE App -->
<script src="<?=BASE_URL('template/');?>dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=BASE_URL('template/');?>dist/js/pages/dashboard.js"></script>
<!-- bootstrap color picker -->
<script src="<?=BASE_URL('template/');?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Ekko Lightbox -->
<script src="<?=BASE_URL('template/');?>plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- DataTables -->
<script src="<?=BASE_URL('template/');?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/moment/moment.min.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/codemirror/codemirror.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/codemirror/mode/css/css.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/codemirror/mode/xml/xml.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?=BASE_URL('template/');?>plugins/select2/js/select2.full.min.js"></script>
<script src="<?=BASE_URL('template/');?>toastify/toastify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<script>
function Toast(status, msg) {
    if (status == 'error') {
        var color = "linear-gradient(to right, #ff5f6d, #ffc371)";
    } else {
        var color = "linear-gradient(to right, #00b09b, #96c93d)";
    }
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: color,
    }).showToast();
}
new ClipboardJS('.copy');
$(function() {
    $(".select2").select2()
    $(".select2bs4").select2({
        theme: "bootstrap4"
    });
});
</script>
</body>

</html>