<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

 <div class="col-md-12 content">

   <div class="panel panel-default">
     <div class="panel-heading">
       <ul class="list-inline">
         <!-- <li class="back_page"><a href="/listCoupon"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
         <li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
         <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
         <li class="page_now">Quản lý sửa giá sản phẩm</li>


     </div>

     <!-- <div class="main_list_p "> -->
       <div class="main_add_p">
         <form method="post">
           <?php
           if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
             ?>
             <div class="row">
               <div class="col-sm-12">

                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Ngày bắt đầu: </label>
                       <input type="text" title="Ngày bắt đầu" placeholder="Nhập kiểu ngày tháng" class="form-control checkcode"  name="dateStart" value="<?php echo @$listData['Product']['dateStart']; ?>">
                     </div>
                     <p id="keo">

                     </p>
                   </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Ngày kết thúc: </label>
                       <input type="text" title="" placeholder="Nhập kiểu ngày tháng" class="form-control"  name="dateEnd" value="<?php echo @$listData['Product']['dateEnd']; ?>">
                     </div>
                   </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Tên sản phẩm: </label>
                       <input type="text" value="<?php echo @$listData['Product']['name']; ?>" name="name" id="" placeholder="Nhập hoặc chọn tên SP" title="Nhập đúng tên sp" class="form-control" disabled>
                     </div>
                   </div>
                 </div>

                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Mã sản phẩm: </label>
                       <input type="text" maxlength="50" name="code" id="" value="<?php echo @$listData['Product']['code']; ?>" placeholder=""  title="Nhập đúng mã SP" class="form-control" disabled>
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Bao bì: </label>
                       <input type="text" name="specification" id="" value="<?php echo @$listData['Product']['packageProduct']; ?>" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Dung tích/trọng lượng: </label>
                       <input type="text" name="weight" id="" value="<?php echo @$listData['Product']['weightProduct']; ?>" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Số SP/thùng: </label>
                       <input type="text" name="packing" id="" value="<?php echo @$listData['Product']['quantity']; ?>" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label style="color:red">Nhà cung cấp </label>
                       <select name="idSupplier" class="form-control" disabled>
                         <option value="">Lựa chọn nhà cung cấp</option>
                         <?php
                          if(!empty($listSupplier)){
                            foreach ($listSupplier as $key => $value) {
                              ?>
															<option value="<?php echo $value['Supplier']['id'];?>" <?php if(!empty($listData['Product']['idSupplier'])&&$listData['Product']['idSupplier']==$value['Supplier']['id']) echo'selected';?>><?php echo $value['Supplier']['name'];?></option>
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
                       <input type="text" name="priceInputPackingTax" id="" value="<?php echo @$listData['Product']['pricePackingTax']; ?>" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <!-- <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Giá nhập/SP có thuế: </label>
                       <input type="text" name="priceInputProductTax" id="" value="" placeholder=""  title="" class="form-control" required="">
                     </div>
                   </div>
                 </div> -->
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Thuế suất: </label>
                       <input type="number" name="tax" id="" value="<?php echo @$listData['Product']['tax']; ?>" min="0" max="100" placeholder=""  title="" class="form-control">
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
                       <input type="text" name="directDiscount" id="" value="<?php echo @$listData['Product']['Discount']; ?>" placeholder=""  title="" class="form-control">
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
                       <input type="text" name="totalPostpayDiscount" id="" value="<?php echo @$listData['Product']['lateDiscount']; ?>" placeholder=""  title="" class="form-control">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Tổng doanh thu CCDV: </label>
                       <input type="text" name="totalRevenue" id="" value="<?php echo @$listData['Product']['totalRevenue']; ?>" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Tổng thu nhập khác: </label>
                       <input type="text" name="totalOtherIncome" id="" value="<?php echo @$listData['Product']['otherRevenue']; ?>" placeholder=""  title="" class="form-control input_money">
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
                       <input type="text" name="insuranceCosts" id="" value="<?php echo @$listData['Product']['sales']; ?>" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Phân bổ chi phí: CF-QL </label>
                       <input type="text" name="managementCosts" id="" value="<?php echo @$listData['Product']['costManagement']; ?>" placeholder=""  title="" class="form-control input_money">
                     </div>
                   </div>
                 </div>
                 <div class="col-sm-4">
                   <div class="form_add">
                     <div class="form-group">
                       <label>Phân bổ chi phí: Lãi vay </label>
                       <input type="text" name="borrow" id="" value="<?php echo @$listData['Product']['laivay']; ?>" placeholder=""  title="" class="form-control input_money">
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
																if (!isset($listData['Product']['idCity']) || $listData['Product']['idCity'] != $city['id']) {
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
                     <input type="submit" name="save" value="Lưu" style="display: inline-block !important;" class="btn_ad">
                   </div>
                 </div>
                </form>


               </div>
             </div>


         </div>

       </div>

       <?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
