<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

 <div class="col-md-12 content">

   <div class="panel panel-default">
     <div class="panel-heading">
       <ul class="list-inline">
         <!-- <li class="back_page"><a href="/listCoupon"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
         <li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
         <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>

         <li class="page_now">Quản lý chi phí vận chuyển</li>
     </div>

     <!-- <div class="main_list_p "> -->
       <div class="main_add_p">
         <form method="get">
           <?php
           if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
             ?>
             <div class="row">
               <div class="col-sm-12">
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Tỉnh/thành phố<span class="color_red">*</span>:</label>
                       <select name="idCity" class="form-control" required="">
                         <option value="">Lựa chọn tỉnh thành</option>
                         <option value="all">Tất cả tỉnh thành</option>
                         <?php
 												global $modelOption;
 												$listCityKiosk=$modelOption->getOption('cityKiosk');
 												if (!empty($listCityKiosk['Option']['value']['allData'])) {
 													foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
 														if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
 															echo '<option value="' . $city['id'] . '">' . arrayMap($city['name']) . '</option>';
 														} else {
 															echo '<option value="' . arrayMap($city['id']) . '" selected>' . $city['name'] . '</option>';
 														}
 													}
 												}
 												?>
                       </select>
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Đơn giá vận chuyển<span class="color_red">*</span>: </label>
                       <input type="text" name="priceTransport" id="" value="" placeholder=""  title="" class="input_money form-control" required="">
                     </div>
                   </div>
                 </div>

                </form>

                 <div class="col-sm-12">
                   <div class="form-group">
                     <!-- <button class="btn_ad" style="display: inline-block !important;">Lưu</button> -->
                     <input type="submit" name="" value="Lưu" style="display: inline-block !important;" class="btn_ad">
                   </div>
                 </div>

                 <div class="col-sm-12">
       						<div class="table-responsive table1">
                     <table class="table table-bordered">
                       <thead>
                         <tr>
 													<th class="text_table">STT</th>
                           <th class="text_table">Tỉnh thành</th>
                           <th class="text_table">Đơn giá vận chuyển</th>
                           <th class="text_table">Hành động</th>
                         </tr>
                       </thead>
                       <tbody>
 												<?php
 												if(!empty($listData)){
                          $i=0;
                          foreach ($listData as $key => &$value) {
                            $i++;
                              echo'
                              <tr>
                              <td class="text_table">'.$i.'</td>
                              <td class="text_table">'.$value['transport']['nameCity'].'</td>
                              <td class="text_table">'.$value['transport']['priceTransport'].'</td>
                              <td><a class="btn btn-default btn-warning" href="/editTransport?idCity='.$value['transport']['idCity'].'&priceTransport='.$value['transport']['priceTransport'].'">Edit</a> <a class="btn btn-default btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" href="/deleteTransport?id='.$value['transport']['id'].'">Delete</a>
        											</td>
                              </tr>
                              ';
                          }
 												} //đóng if(!empty($listData)).
 												else{
 													echo '<tr><td align="center" colspan="18">Chưa có dữ liệu</td></tr>';
 												}
 												?>
                       </tbody>

                     </table>
                   </div>
                 </div>
               </div>
             </div>

         </div>

       </div>

       <?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
