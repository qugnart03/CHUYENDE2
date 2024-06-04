<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'LỊCH SỬ MUA NICK | '.$SIEUTHICODE->site('tenweb');
    require_once("../../public/client/Header.php");
    require_once("../../public/client/Nav.php");
    CheckLogin();
?>

<div class="w-full max-w-6xl mx-auto pt-6 md:pt-8 pb-8">
    <div class="grid grid-cols-8 gap-4 md:p-4 bg-box-dark">
        <?php require_once('Sidebar.php');?>
        <div class="col-span-8 sm:col-span-5 md:col-span-6 lg:col-span-6 xl:col-span-6 px-2 md:px-0">
            <div class="v-bg w-full mb-2 px-2">
                <h2 class="v-title border-l-4 border-red-800 px-3 select-none text-white text-xl md:text-2xl font-bold">
                    LỊCH SỬ MUA NICK
                </h2>
                <div class="v-table-content select-text">
                    <div class="py-2 overflow-x-auto scrolling-touch max-w-400">
                        <table id="datatable" class="table-auto w-full scrolling-touch min-w-850">
                            <thead>
                           
                                <tr
                                    class="text-md font-semibold tracking-wide text-left border border-b-0 text-white">
                                    <th class="px-2 py-2">Thông tin</th>
                                    <th class="px-2 py-2">Tài khoản | Mật khẩu
                                    </th>
                                    <th class="px-2 py-2">
                                        Thanh toán
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-semibold">
                                <?php
                                 
                                      foreach ($SIEUTHICODE->get_list("SELECT * FROM `history_buy` WHERE `username` = '{$getUser['username']}' ORDER BY `id` DESC") as $info) {
                                          $query_product = $SIEUTHICODE->get_row("SELECT * FROM `groups` WHERE `type_category` = '{$info['type_category']}'");
                                          $detail_product = json_decode($query_product['detail'], true);
                                          $detail = json_decode($info['detail'], true);
                                          $arr_detail = $detail['data'];
                                  ?>
                          
                                          <tr class="text-gray-700 border-b">
                                              <td class="px-2 py-1 md:py-2 border-b">
                                                  <div>
                                                      <p class="font-bold text-black"> <?= $detail_product['name_product'] ?> </p>
                                                      <p class="text-dark font-semibold"> <?= date('Y-m-d H:i:s', $info['created_at']) ?> </p>
                                                      <p class="mt-1 text-gray-600 font-semibold"><span class="text-red-600">Mã số: <?= $info['id_acc'] ?></span></p>
                                                  </div>
                                              </td>
                                              <td class="px-2 py-2 border-b">
                                                  <div class="md:text-sm">
                                                     
                                                        <?php foreach ($arr_detail as $item):?>
                                                            <p class="font-bold text-black"><?=$item['label']?> : <?= decodecryptData($item['value']) ?> </p>
                                                        <?php endforeach;?>
                                                  </div>
                                                  
                                              </td>
                                              <td class="px-2 py-1 border-b">
                                                  <div class="mt-2 font-semibold leading-5">
                                                      <p class="text-sm text-red-600">Thanh toán:<b> - <?= number_format($info['cash']) ?>đ</b></p>
                                                      <p class="text-sm text-green-600"><b> Thành công</b></p>
                                                  </div>
                                              </td>
                                          </tr>
                                  <?php }
                                   ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="v-table-note mt-1 py-1 font-semibold text-white text-sm">
                        Dùng điện thoại <i class="bx bxs-mobile"></i>, hãy vuốt bảng từ phải qua trái (<i
                            class="bx bxs-arrow-from-right"></i>) để xem đầy đủ thông tin!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>





<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable();
});
</script>


<?php 
    require_once("../../public/client/Footer.php");
?>