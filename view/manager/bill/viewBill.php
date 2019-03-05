<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

 <div class="col-md-12 content">

   <div class="panel panel-default">
     <div class="panel-heading">
       <ul class="list-inline">
         <!-- <li class="back_page"><a href="/listCoupon"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
         <li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
         <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
         <li class="page_now">Xem hóa đơn</li>


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
                       <label>Ngày bắt đầu hóa đơn: </label>
                       <input type="text" title="Ngày bắt đầu" placeholder="Nhập kiểu ngày tháng" class="form-control checkcode"  name="dateStart" value="">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Ngày kết thúc hóa đơn: </label>
                       <input type="text" title="Ngày kết thúc" placeholder="Nhập kiểu ngày tháng" class="form-control checkcode"  name="dateEnd" value="">
                     </div>
                   </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Chọn điểm đặt</label>
                       <select name="idPlace" class="form-control" placeholder="Trạng thái thanh toán">
 												<option value="">Chọn điểm đặt</option>
 												<?php
 												if(!empty($listPlace)){
 													foreach ($listPlace as $key => $value) {
 															# code...
 														?>
 														<option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($_GET['idPlace'])&&$_GET['idPlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
 														<?php
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
                       <label>Chọn Tỉnh/Thành phố</label>
                       <select name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
 												<option value="">Chọn Tỉnh/Thành phố</option>
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
                       <label></label>
                       <select  name="idDistrict" class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
 												<option value="">Chọn Quận/Huyện</option>
 											</select>
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <select  name="wards" class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
 												<option value="">Chọn Xã/Phường</option>
 											</select>
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Nhà cung cấp </label>
                       <select name="idSupplier" class="form-control" >
                         <option value="">Lựa chọn nhà cung cấp</option>
                         <?php
                          if(!empty($listSupplier)){
                            foreach ($listSupplier as $key => $value) {
                              ?>
															<option value="<?php echo $value['Supplier']['id'];?>" <?php if(!empty($_GET['idSupplier'])&&$_GET['idSupplier']==$value['Supplier']['id']) echo'selected';?>><?php echo $value['Supplier']['name'];?></option>
															<?php
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
                       <label style="color:red">Giá nhập/thùng có thuế: </label>
                       <input type="text" name="priceInputPackingTax" id="" value="" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>

                  <div class="col-sm-4">
                    <div class="form-add">
                      <input type="submit" name="search" value="Tìm_kiếm" style="display: inline-block !important;" class="btn_ad">
                    </div>
                  </div>
                </form>
                 <div class="col-sm-12">
       						<div class="table-responsive table1">
                     <table class="table table-bordered">
                       <thead>
                         <tr>
 													<th class="text_table" >STT</th>
                           <th class="text_table">Tên hóa đơn</th>
                           <th class="text_table">Ngày tháng</th>
 													 <th class="text_table">Nhà cung cấp</th>
                           <th class="text_table">Điểm đặt</th>
                           <th class="text_table">Hành động</th>
                         </tr>
                       </thead>
                       <tbody>
 												<?php
 												if(!empty($listNewProduct)){
                          if (!isset($_GET['page'])) {
  													$i=0;
  												}
  												elseif (isset($_GET['page'])&&$_GET['page']==1) {
  													$i=0;
  												}elseif (isset($_GET['page'])>=2)
  												{
  													$i=$_GET['page']*15-15;
  												}
                          foreach ($listNewProduct as $key => &$value) {
                            $i++;
                              echo'
                              <tr>
                              <td class="text_table">'.$i.'</td>
                              <td class="text_table">'.@$value['Product']['name'].'</td>
                              <td class="text_table">'.@$value['Product']['code'].'</td>
                              <td class="text_table">'.@$value['Product']['tax'].'</td>
                              <td class="text_table">'.@$value['Product']['otherRevenue'].'</td>
                              <td><a class="btn btn-default btn-primary" href="/viewManage?id='.$value['Product']['id'].'">Xem</a> <a class="btn btn-default btn-warning" href="/editManage?id='.$value['Product']['id'].'">Sửa</a> <a class="btn btn-default btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" href="/deleteNewProduct?id='.$value['Product']['id'].'">Xóa</a>
        											</td>
                              </tr>
                              ';
                          }
 												} //đóng if(!empty($listData)).
 												else{
 													echo '<tr><td align="center" colspan="11">Chưa có dữ liệu</td></tr>';
 												}
 												?>
                       </tbody>

                     </table>
                   </div>
                   <?php
       						if(!empty($listNewProduct)){
       							?>
       							<div class=" text-center p_navigation" style="<?php if(($totalPage==1)||empty($listNewProduct)) echo'display: none;';?>">
       								<nav aria-label="Page navigation">
       									<ul class="pagination">
       										<?php
       										if ($page > 4) {
       											$startPage = $page - 4;
       										} else {
       											$startPage = 1;
       										}

       										if ($totalPage > $page + 4) {
       											$endPage = $page + 4;
       										} else {
       											$endPage = $totalPage;
       										}
       										?>
       										<li class="<?php if($page==1) echo'disabled';?>">
       											<a href="<?php echo $urlPage . $back; ?>" aria-label="Previous">
       												<span aria-hidden="true">«</span>
       											</a>
       										</li>
       										<?php
       										for ($i = $startPage; $i <= $endPage; $i++) {
       											if ($i != $page) {
       												echo '	<li><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
       											} else {
       												echo '<li class="active"><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
       											}
       										}
       										?>
       										<li class="<?php if($page==$endPage) echo'disabled';?>">
       											<a href="<?php echo $urlPage . $next ?>" aria-label="Next">
       												<span aria-hidden="true">»</span>
       											</a>
       										</li>
       									</ul>
       								</nav>
       							</div>
       							<?php
       						}
       						?>
                 </div>

               </div>
             </div>


         </div>

       </div>

       <?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
