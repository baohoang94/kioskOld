<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

 <div class="col-md-12 content">

   <div class="panel panel-default">
     <div class="panel-heading">
       <ul class="list-inline">
         <!-- <li class="back_page"><a href="/listCoupon"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
         <li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
         <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
         <li class="page_now">Quản lý giá sản phẩm</li>


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
                       <label>Ngày bắt đầu: </label>
                       <input type="text" title="Ngày bắt đầu" placeholder="Nhập kiểu ngày tháng" class="form-control checkcode"  name="dateStart" value="">
                     </div>
                     <p id="keo">

                     </p>
                   </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Ngày kết thúc: </label>
                       <input type="text" title="" placeholder="Nhập kiểu ngày tháng" class="form-control"  name="dateEnd" value="">
                     </div>
                   </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Tên sản phẩm: </label>
                       <input type="text" value="" name="name" id="" placeholder="Nhập hoặc chọn tên SP" title="Nhập đúng tên sp" class="form-control">
                     </div>
                   </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Mã sản phẩm: </label>
                       <input type="text" maxlength="50" name="code" id="" value="" placeholder=""  title="Nhập đúng mã SP" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Bao bì: </label>
                       <input type="text" name="specification" id="" value="" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Dung tích/trọng lượng (ml): </label>
                       <input type="text" name="weight" id="" value="" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Số SP/thùng: </label>
                       <input type="text" name="packing" id="" value="" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Nhà cung cấp </label>
                       <select name="idSupplier" class="form-control" onchange="updateStatus($(this).val())">
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
                   <div class="form_add">
                     <div class="form-group">
                       <label>Giá nhập/SP có thuế: </label>
                       <input type="text" name="priceInputProductTax" id="" value="" placeholder=""  title="" class="form-control" required="">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Thuế suất: </label>
                       <input type="number" name="tax" id="" value="" min="0" max="100" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <!-- <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Giá nhập/SP không thuế: </label>
                       <input type="text" name="priceInputProductNoTax" id="" value="" placeholder="PM tự tính" readonly title="" class="form-control">
                     </div>
                   </div>
                 </div> -->
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Mức CK trực tiếp: </label>
                       <input type="text" name="directDiscount" id="" value="" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <!-- <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Tổng chiết khấu trực tiếp: </label>
                       <input type="text" name="totalDirectDiscount" id="" value="" placeholder="PM tự tính" readonly  title="" class="form-control">
                     </div>
                   </div>
                 </div> -->
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Tổng chiết khấu trả sau: </label>
                       <input type="text" name="totalPostpayDiscount" id="" value="" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Tổng doanh thu CCDV: </label>
                       <input type="text" name="totalRevenue" id="" value="" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Tổng thu nhập khác: </label>
                       <input type="text" name="totalOtherIncome" id="" value="" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <!-- <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>GV mua: </label>
                       <input type="text" name="purchasePrice" id="" value="" placeholder="PM tự tính" readonly  title="" class="form-control">
                     </div>
                   </div>
                 </div> -->
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Phân bổ chi phí: CF-BH </label>
                       <input type="text" name="insuranceCosts" id="" value="" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Phân bổ chi phí: CF-QL </label>
                       <input type="text" name="managementCosts" id="" value="" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Phân bổ chi phí: Lãi vay </label>
                       <input type="text" name="borrow" id="" value="" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Tỉnh/thành phố:</label>
                       <select name="idCity" class="form-control">
                         <option value="">Lựa chọn tỉnh thành</option>
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
                     <input type="submit" name="save" value="Thêm_Mới" style="display: inline-block !important;" class="btn_ad">
                   </div>
                 </div>
                  <div class="col-sm-4">
                    <div class="form-add">
                      <input type="submit" name="search" value="Tìm_kiếm" style="display: inline-block !important;" class="btn_ad">
                    </div>
                  </div>
                </form>

                <div class="col-sm-4">
                  <div class="form-add">
                    <form action="" method="POST">
                    <input type="" name="inport" value="1" class="hidden">
                    <button class="add_p1" type="submit">Xuất file excel</button>
                    </form>
                  </div>
                </div>


                <div class="col-sm-4">
                  <div class="form-add">
                    <form action="" method="POST">
                      <input type="" name="inport2" value="1" class="hidden">
                      <button class="btn btn-danger" type="submit">Xuất báo cáo bảng giá nhập</button>
                    </form>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-add">
                    <form action="" method="POST">
                      <input type="" name="inport3" value="1" class="hidden">
                      <button class="btn btn-warning" type="submit">Xuất báo cáo theo máy</button>
                    </form>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-add">
                    <form action="" method="POST">
                      <input type="" name="inport4" value="1" class="hidden">
                      <button class="btn btn-success" type="submit">Xuất báo cáo theo kênh</button>
                    </form>
                  </div>
                </div>

                 <div class="col-sm-12">
       						<div class="table-responsive table1">
                     <table class="table table-bordered">
                       <thead>
                         <tr>
 													<th class="text_table" rowspan="2">STT</th>
                           <th class="text_table"rowspan="2">Tên SP</th>
                           <th class="text_table"rowspan="2">Mã SP</th>
 													 <th class="text_table"rowspan="2">Thuế suất</th>
                           <th class="text_table"rowspan="2">Giá nhập SP ko thuế</th>
                           <th class="text_table"rowspan="2">Mức CK trực tiếp</th>
                           <th class="text_table" colspan="4">Tổng chiết khấu</th>
                           <th class="text_table" rowspan="2">Hành động</th>
                         </tr>
                         <tr>
                           <th>Tổng CK trực tiếp</th>
                           <th>Tổng CK trả sau</th>
                           <th>Tổng doanh thu CCDV</th>
                           <th>Tổng thu nhập khác</th>
                         </tr>
                       </thead>
                       <tbody id="dataAjax">
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
                              <td class="text_table">'.@$value['Product']['priceProductNoTax'].'</td>
                              <td class="text_table">'.@$value['Product']['Discount'].'</td>
                              <td class="text_table">'.@$value['Product']['totalDiscount'].'</td>
                              <td class="text_table">'.@$value['Product']['lateDiscount'].'</td>
                              <td class="text_table">'.@$value['Product']['totalRevenue'].'</td>
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
<script>
  function updateStatus(id) {
    $.get("ajaxtProduct?idSupplier="+id, function(data){
    $('#dataAjax').html(data);
    });
  }
</script>