 <?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
 <div class="container-fluid main-container">

 	<div class="col-md-12 content">

 		<div class="panel panel-default">
 			<div class="panel-heading">
 				<ul class="list-inline">
					<!-- <li class="back_page"><a href="/listCoupon"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
 					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
 					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
 					<li class="page_prev"><a href="/listCoupon"> Danh sách mã coupon</a></li>
 					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
 					<li class="page_now"><?php if(empty($data)){ echo'Thêm mã coupon mới';}else{echo'Chỉnh sửa mã coupon';}?></li>
 				</ul>

 			</div>

 			<!-- <div class="main_list_p "> -->
 				<div class="main_add_p">
 					<form action="" method="post">
 						<?php
 						if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
 							?>
 							<div class="row">
 								<div class="col-sm-12">

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Mã coupon<span class="color_red">*</span>: </label>
 												<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="updatecode" placeholder="Mã coupon" class="form-control checkcode"  name="codeCoupon" required="" value="<?php echo @arrayMap($data['Coupon']['codeCoupon']);?>">
 											</div>
 											<p id="keo">

 											</p>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Tên coupon<span class="color_red">*</span>: </label>
 												<input type="text" title="" maxlength="50" id="" placeholder="Tên coupon" class="form-control"  name="name" required="" value="<?php echo @arrayMap($data['Coupon']['name']);?>">
 											</div>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Ngày phát hành<span class="color_red">*</span>: </label>
 												<input type="text" maxlength="50" value="<?php echo @$data['Coupon']['dateStart']['text'];?>" name="dateStart" id="" placeholder="Từ ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required>
 											</div>
 										</div>
 									</div>

 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Ngày hết hạn<span class="color_red">*</span>: </label>
 												<input type="text" maxlength="50" name="dateEnd" id="" value="<?php echo @$data['Coupon']['dateEnd']['text'];?>" placeholder="Đến ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
 											</div>
 										</div>
 									</div>
 									<!--
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Ngày giao dịch<span class="color_red">*</span>: </label>
 												<input type="text" maxlength="50" name="dateTrading" id="" value="<?php echo @$data['Coupon']['dateTrading'];?>" placeholder="Đến ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
 											</div>
 										</div>
 									</div>
 									-->
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Trạng thái<span class="color_red">*</span>: </label>
 												<select name="status" class="form-control">
 													<option value="active" <?php if(!empty($data['Coupon']['status'])&&$data['Coupon']['status']=='active') echo'selected';?>>Kích hoạt</option>
 													<!--
 													<option value="public" <?php if(!empty($data['Coupon']['status'])&&$data['Coupon']['status']=='public') echo'selected';?>>Đã phát hành</option>
 													<option value="traded" <?php if(!empty($data['Coupon']['status'])&&$data['Coupon']['status']=='traded') echo'selected';?>>Đã giao dịch</option>
 													-->
 													<option value="lock" <?php if(!empty($data['Coupon']['status'])&&$data['Coupon']['status']=='lock') echo'selected';?>>Khóa</option>
 												</select>
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Kênh bán hàng: </label>
 												<select name="idChannel" class="form-control" >
 													<option value="">Lựa chọn kênh bán hàng</option>
 													<?php
 													if(!empty($listChannelProduct)){
 														foreach ($listChannelProduct['Option']['value']['allData'] as $key => $value) {
															# code...
 															?>
 															<option value="<?php echo $value['id'];?>" <?php if(!empty($data['Coupon']['idChannel'])&&$data['Coupon']['idChannel']==$value['id']) echo'selected';?>><?php echo $value['name'];?></option>
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
 												<label>Điểm đặt máy: </label>
 												<select name="idPlace" class="form-control" >
 													<option value=""> Lựa chọn điểm đặt</option>
 													<?php
 													$modelPlace = new Place;
 													$conditionsPlace['lock']=(int)0;
 													$fields=array('name');
 													$listPlace=$modelPlace->find('all', array('conditions'=>$conditionsPlace,'fields'=>$fields));
 													if(!empty($listPlace)){
 														foreach ($listPlace as $key => $value) {
															# code...
 															?>
 															<option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($data['Coupon']['idPlace'])&&$data['Coupon']['idPlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
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
 												<label>Mã sản phẩm: </label>
 												<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="" placeholder="Mã sản phẩm" class="form-control" name="codeProduct"  value="<?php echo @arrayMap($data['Coupon']['codeProduct']);?>">
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Số lượng<span class="color_red">*</span>: </label>
 												<input type="text" title="" maxlength="19" id="" placeholder="Số lượng" class="input_money form-control" name="quantity" required="" value="<?php echo @arrayMap($data['Coupon']['quantity']);?>">
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Mã máy Kiosk: </label>
 												<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="" placeholder="Mã máy" class="form-control" name="codeMachine"  value="<?php echo @arrayMap($data['Coupon']['codeMachine']);?>">
 											</div>
 										</div>
 									</div>
                  <div class="col-sm-4">
 										<div class="form_add">
 											<div class="form-group">
 												<label>Giá trị<span class="color_red">*</span>: </label>
 												<input type="text" title="" maxlength="19" id="" placeholder="Giá trị" class="input_money form-control" name="value" required="" value="<?php echo @arrayMap($data['Coupon']['value']);?>">
 											</div>
 										</div>
 									</div>
 									<div class="col-sm-12">
 										<div class="form-group">
 											<label> Ghi chú: </label>
 											<textarea class="form-control" maxlength="3000" placeholder="Ghi chú" value="" rows="3" name="note"><?php echo @arrayMap($data['Coupon']['note']);?></textarea>

 										</div>
 									</div>
 									<div class="col-sm-12" style="<?php if(empty($data)) echo'display: none;';?>">
 										<div class="form-group">
 											<label> Lý do sửa<span class="color_red">*</span>: </label>
 											<textarea class="form-control" maxlength="3000" value="" rows="3" name="reason" <?php if(!empty($data))echo'required=""';?> placeholder="Lý do sửa"></textarea>

 										</div>
 									</div>
 									<div class="col-sm-12">
 										<div class="form-group">
 											<button class="btn_ad" style="display: inline-block !important;">Lưu</button>
 											<span class="btn_ad_back"><a href="/listCoupon">Quay lại</a></span>
 										</div>
 									</div>
 								</div>
 							</div>

 						</form>
 					</div>

 				</div>

 				<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>

 				<!-- <script type="text/javascript">
 					$("#updatecode").keyup(function(){
 						var value = $( this ).val();
 						regex = /^[a-zA-Z0-9-]+$/
 						if(value){
 							if (regex.test(value)) {
 							} else {
 								alert('Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang');
 								var a;
 								if(value.includes(' ')){
 									a=value.replace(' ','');
 								}
 								if(value.includes('`')){
 									a=value.replace('`','');
 								}
 								if(value.includes('~')){
 									a=value.replace('~','');
 								}
 								if(value.includes('!')){
 									a=value.replace('!','');
 								}
 								if(value.includes('@')){
 									a=value.replace('@','');
 								}
 								if(value.includes('#')){
 									a=value.replace('#','');
 								}
 								if(value.includes('$')){
 									a=value.replace('$','');
 								}
 								if(value.includes('%')){
 									a=value.replace('%','');
 								}
 								if(value.includes('~^')){
 									a=value.replace('~^','');
 								}
 								if(value.includes('&')){
 									a=value.replace('&','');
 								}
 								if(value.includes('*')){
 									a=value.replace('*','');
 								}
 								if(value.includes('(')){
 									a=value.replace('(','');
 								}
 								if(value.includes(')')){
 									a=value.replace(')','');
 								}
 								if(value.includes('=')){
 									a=value.replace('=','');
 								}
 								if(value.includes('_')){
 									a=value.replace('_','');
 								}
 								if(value.includes('+')){
 									a=value.replace('+','');
 								}
 								if(value.includes('/')){
 									a=value.replace('/','');
 								}
 								if(value.includes('>')){
 									a=value.replace('>','');
 								}
 								if(value.includes('<')){
 									a=value.replace('<','');
 								}
 								if(value.includes(']')){
 									a=value.replace(']','');
 								}
 								if(value.includes('[')){
 									a=value.replace('[','');
 								}
 								if(value.includes('|')){
 									a=value.replace('|','');
 								}
						$('#updatecode').val(a);

					}
				}

			});

		</script>
 -->
