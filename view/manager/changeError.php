<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<!-- <li class="back_page"><a href="/listMachine"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listMachine"> Quản lí máy</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now"><?php if(empty($data)){echo'Thêm máy mới';}else{echo'Chỉnh sửa thông tin  máy';}?></li>
				</ul>

			</div>
			
			<!-- <div class="main_list_p "> -->
				<div class="main_add_p">
					<div class="card">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Thông tin</a></li>
							<!-- <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Ảnh</a></li>
								<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Thông tin khác</a></li> -->
							</ul>

							<form action="" method="POST">
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="home">
										<?php
										if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
											?>
											<div class="row">
												<div class="col-sm-12">
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Tên máy<span class="color_red">*</span>: </label>
																<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($data['Machine']['name']);?>" placeholder="Tên máy" class="form-control" name="name" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Mã máy<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" id="updatecode" value="<?php echo @arrayMap($data['Machine']['code']);?>" placeholder="Mã máy" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " class="form-control checkcode" name="code" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Số imei<span class="color_red">*</span>: </label>
																<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($data['Machine']['imei']);?>" placeholder="Số imei" class="form-control"  name="imei" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Ngày sản xuất máy<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @$data['Machine']['dateManufacture'];?>" name="dateManufacture" id="" placeholder="Ngày sản xuất" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Ngày nhập kho<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @$data['Machine']['dateStorage'];?>" name="dateStorage" id="" placeholder="Ngày nhập kho"  data-inputmask="'alias': 'date'" class="input_date form-control" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Giá máy (vnđ)<span class="color_red">*</span>: </label>
																<input type="text" title="" maxlength="100" id="" value="<?php echo @arrayMap($data['Machine']['priceMachine']);?>" placeholder="Giá máy" class="input_money form-control"  name="priceMachine" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Trạng thái<span class="color_red">*</span>: </label>
																<select class="form-control" name="status">
																	<option selected="" value="3">Máy bị lỗi</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Ngày lắp đặt máy tại điểm bán<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50"  placeholder="Ngày lắp đặt máy tại điểm bán" value="<?php echo @$data['Machine']['dateInstallation'];?>" name="dateInstallation" id=""  data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Kỹ thuật lắp đặt<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['nameInstallation']);?>" placeholder="Kỹ thuật lắp đặt" name="nameInstallation" id=""  class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Ngày đưa vào sử dụng<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @$data['Machine']['dateStartRun'];?>" placeholder="Ngày đưa vào sử dụng" name="dateStartRun" id=""  data-inputmask="'alias': 'date'" class="input_date form-control" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Hạn bảo hành định kì<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['warrantyCycle']);?>" placeholder="Hạn bảo hành định kì" name="warrantyCycle" id=""  class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Hạn bảo hành NSX<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['warrantyManufacturer']);?>" placeholder="Hạn bảo hành NSX" name="warrantyManufacturer" id=""  class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Loại máy<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['typeMachine']);?>" placeholder="Loại máy" name="typeMachine" id=""  class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Nhà sản xuất<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['manufacturer']);?>" placeholder="Nhà sản xuất" name="manufacturer" id=""  class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Chiều cao máy (m)<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['heightMachine']);?>" placeholder="Chiều cao (m)" name="heightMachine" id=""  class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Chiều rộng máy (m)<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['widthMachine']);?>" placeholder="Chiều rộng (m)" name="widthMachine" id=""  class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Chiều sâu máy (m)<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['depthMachine']);?>" placeholder="Chiều sâu (m)" name="depthMachine" id=""  class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Cân nặng máy (kg)<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['weightMachine']);?>" placeholder="Cân nặng (kg)" name="weightMachine" id="" class="form-control" required="">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Mã nhân viên phụ trách<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['codeStaff']);?>" placeholder="Mã nhân viên" name="codeStaff" id=""  class="form-control checkcode" >
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label>Điểm đặt<span class="color_red">*</span>: </label>
																<select name="idPlace" class="form-control" required="">
																	<option value="">Lựa chọn điểm đặt</option>
																	<?php 
																	if(!empty($listPlace)){
																		foreach ($listPlace as $key => $value) {
																			# code...
																			?>
																			<option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($data['Machine']['idPlace'])&&$data['Machine']['idPlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
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
																<label>Tọa độ<span class="color_red">*</span>: </label>
																<input type="text" maxlength="50" name="location" class="form-control" placeholder="Tọa độ vd:20.9789411,105.8481691"  value="<?php echo @arrayMap($data['Machine']['location']);?>">
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form_add">
															<div class="form-group">
																<label for="">Hình minh họa</label>
																<div style="clear:both;"></div>
																<div id="keo">
																	<?php 
																	showUploadFile('image','image',@$data['Machine']['image'],0);
																	?>
																	<span class="reset"><i class="fa fa-repeat" aria-hidden="true"></i></span>
																</div>
																<style type="text/css">
																.reset:hover{
																	color: blue;
																}
															</style>
															<script type="text/javascript">
																$('.reset').click(function(){
																	$("#image").val('');

																});
															</script>
														</div>
													</div>
												</div>
												<div class="col-sm-12" style="<?php if(empty($data)){echo'display: none';}?>">
													<div class="form_add">
														<div class="form-group">
															<label>Lý do sửa<span class="color_red">*</span>: </label>
															<textarea maxlength="3000" class="form-control" name="reason" <?php if(!empty($data))echo'required=""';?> placeholder="Lý do sửa"></textarea>
														</div>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group">
														<button class="btn_ad" style="display: inline-block !important;">Lưu</button>
														<span class="btn_ad_back"><a href="/listMachineError">Quay lại</a></span>
													</div>
												</div>

											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label class="col-sm-2 control-label">Bản đồ</label>
													<div class="col-sm-8">
														<a href="javascript:void( 0 );" class="btn btn-primary btn-sm" onclick="getByAdress();">Lấy bản đồ từ địa chỉ</a>
														&nbsp; Tọa độ GPS 
														<input type="text" name="coordinates"  id="coordinates" class="text_area" value="<?php
														if (isset($tmpVariable['data']['Route']['latGPS']) && isset($tmpVariable['data']['Route']['longGPS']))
															echo $tmpVariable['data']['Route']['latGPS'].','.$tmpVariable['data']['Route']['longGPS'];
														?>" />
														<br />
														<input type="text" id="address" class="form-control" value="" style="margin-top: 20px;" />
														<br />
														<a href="javascript:void( 0 );" class="btn btn-primary btn-sm" onclick="searchAdress();">Tìm</a>
														<span> Di chuột và chọn địa điểm trên bản đồ</span>
														<script type="text/javascript">
															function searchAdress()
															{
																addressNote = document.getElementById('address').value;
																getLocationFromAddress(addressNote);
															}
															function getByAdress()
															{
																addressNote = $("#detailAddress").val();
																getLocationFromAddress(addressNote);
																document.getElementById('address').value = addressNote;
															}
														</script>

													</div>
												</div>
												<div id="map-canvas" style="width: 100%; height: 500px"></div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="profile">
										<div class="row">
											
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="messages">
									</div>
								</div>
							</form>

						</div>
					</div>

				</div>
				<script type="text/javascript">
					var map;
					var geocoder;
					var marker;

					function initialize() {
						geocoder = new google.maps.Geocoder();
						var mapDiv = document.getElementById('map-canvas');

						map = new google.maps.Map(mapDiv, {
							<?php
							if (isset($tmpVariable['data']['Route']['latGPS']) && isset($tmpVariable['data']['Route']['longGPS'])) {
								echo 'center: new google.maps.LatLng(' . $tmpVariable['data']['Route']['latGPS'] . ','.$tmpVariable['data']['Route']['longGPS'].'),';
							} else {
								echo '';
							}
							?>
							zoom: 10,
							mapTypeId: google.maps.MapTypeId.ROADMAP,
							streetViewControl: false
						});

						marker = new google.maps.Marker({
							map: map,
							<?php
							if (isset($tmpVariable['data']['Route']['latGPS']) && isset($tmpVariable['data']['Route']['longGPS'])) {
								echo 'position: new google.maps.LatLng(' . $tmpVariable['data']['Route']['latGPS'] . ','.$tmpVariable['data']['Route']['longGPS']. '),';
							} else {
								echo 'position: new google.maps.LatLng(16.496281,107.219443),';
							}
							?>
							draggable: true
						});

						google.maps.event.addListener(marker, 'drag', function () {
							geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									if (results[0]) {
										document.getElementById('address').value = results[0].formatted_address;
										document.getElementById('coordinates').value = marker.getPosition().toUrlValue();
									}
								}
							});
						});
					}
					function getLocationFromAddress(address) {

						geocoder.geocode({'address': address}, function (results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
								map.setCenter(results[0].geometry.location);
								marker.setPosition(results[0].geometry.location);
								document.getElementById('coordinates').value = results[0].geometry.location.lat().toFixed(7) + ',' + results[0].geometry.location.lng().toFixed(7);
							} else {
								alert('Không tìm thấy địa điểm trên bản đồ.');
							}
						});
					}

					google.maps.event.addDomListener(window, 'load', initialize);
				</script>

				<script async defer
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8Lo3pUlPzJUuT58ie2WP0WXq6YNMYHOg&callback=initialize">
			</script>


			<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>

		<!-- 	<script type="text/javascript">
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
				
		</script> -->