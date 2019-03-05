<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<!-- <div class="col-md-2 sidebar">
		<div class="row">
			<div class="absolute-wrapper"> </div>
			<?php include "sidebar.php";?>
		</div>  		
	</div> -->
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<!-- <li class="back_page"><a href="/listErrorMachine"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li><a href="/listErrorMachine">Danh sách lỗi</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Xem chi tiết lỗi</li>
				</ul>
			</div>
			<div id="">
				
			</div>
			<div class="main_list_p ">
				<?php
				if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
					?>
					<div class="row">
						<div class="col-sm-12">
							<form class="table-responsive table1" action="" method="POST">
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Mã máy<span class="color_red">*</span>: </label>
											<input type="text"  disabled="" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="updatecode" class="form-control checkcode" placeholder="Mã máy" name="codeMachine" required="" value="<?php echo @arrayMap($data['Error']['codeMachine']);?>">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Tỉnh/Thành phố<span class="color_red">*</span>:</label>
											<select required  disabled="" name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
												<option value="">Chọn Tỉnh/Thành phố</option>
												<?php
												if (!empty($listCityKiosk['Option']['value']['allData'])) {
													foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
														if (!isset($data['Error']['idCity']) || $data['Error']['idCity'] != $city['id']) {
															echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
														} else {
															echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
														}
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>

							<!-- <div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Tên lỗi*: </label>
										<input type="text" title="" maxlength="50" id="" class="form-control" placeholder="Tên lỗi" name="name" required="" value="<?php echo @$data['Error']['name'];?>">
									</div>
								</div>
							</div> -->
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>KTV sửa chữa<span class="color_red">*</span>: </label>
										<input type="text"  disabled="" title="" maxlength="50" id="" class="form-control" placeholder="KTV sửa chữa" name="nameTechnicians" required="" value="<?php echo @arrayMap($data['Error']['nameTechnicians']);?>">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Ngày bắt đầu hỏng<span class="color_red">*</span>: </label>
										<input type="text"  disabled="" maxlength="50" value="<?php echo @$data['Error']['dayError'];?>" name="dayError" id="" placeholder="Ngày bắt đầu hỏng" data-inputmask="'alias': 'date'" class="input_date form-control" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Ngày báo hỏng<span class="color_red">*</span>: </label>
										<input type="text"  disabled="" maxlength="50" value="<?php echo @$data['Error']['dayReportError'];?>" name="dayReportError" id="" placeholder="Ngày báo hỏng" data-inputmask="'alias': 'date'" class="input_date form-control" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Ngày bắt đầu khắc phục<span class="color_red">*</span>: </label>
										<input type="text" maxlength="50"  disabled="" value="<?php echo @$data['Error']['dayStart'];?>" name="dayStart" id="" placeholder="Ngày bắt đầu khắc phục" data-inputmask="'alias': 'date'" class="input_date form-control" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Ngày hoàn thành khắc phục<span class="color_red">*</span>: </label>
										<input type="text" maxlength="50"  disabled="" value="<?php echo @$data['Error']['dayEnd'];?>" name="dayEnd" id="" placeholder="Ngày hoàn thành khắc phục" data-inputmask="'alias': 'date'" class="input_date form-control" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Trạng thái<span class="color_red">*</span>: </label>
										<select name="status"  disabled="" class="form-control" placeholder="Tỉnh/Thành phố" required="">
											<option value="1" <?php if(!empty($data['Error']['status'])&&$data['Error']['status']==1) echo'selected';?>>Mới tạo</option>
											<option value="2" <?php if(!empty($data['Error']['status'])&&$data['Error']['status']==2) echo'selected';?>>Đang chờ xử lý</option>
											<option value="3" <?php if(!empty($data['Error']['status'])&&$data['Error']['status']==3) echo'selected';?>>Đang xử lý</option>
											<option value="4" <?php if(!empty($data['Error']['status'])&&$data['Error']['status']==4) echo'selected';?>>Hoàn thành</option>
											<option value="5" <?php if(!empty($data['Error']['status'])&&$data['Error']['status']==5) echo'selected';?>>Đóng</option>
										</select>
									</div>
								</div>
							</div>
							<div id="codeError">
								<div class="col-sm-4">
									<div class="form_add" id="">
										<div class="form-group ">
											<label>Mã lỗi<span class="color_red">*</span>: </label>
											<input type="text" disabled=""  pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="errorCode" class="form-control code <?php //if(empty($data['Error']['codeError'])) echo'code';?> " placeholder="Mã lỗi" name="codeError" required="" value="<?php echo @arrayMap($data['Error']['codeError']);?>">
										</div>
										<p class="concua" style="position: absolute;z-index: 2; top: 61px;"></p>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add" id="">
										<div class="form-group ">
											<label>Tên lỗi<span class="color_red">*</span>: </label>
											<input type="text" title="" disabled=""  maxlength="50" id="errorName" class="form-control tenLoi"  name="name" required="" placeholder="Tên lỗi" value="<?php echo @arrayMap($data['Error']['name']);?>">
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Mô tả lỗi<span class="color_red">*</span>: </label>
										<textarea class="form-control" disabled="" maxlength="3000" name="note" placeholder="Mô tả lỗi" required="" id="noteError" rows="3" required=""><?php echo @arrayMap($data['Error']['note']);?></textarea>

									</div>
								</div>
								<div class="col-sm-12">
													<div class="form-group">
														<span class="btn_ad_back"><a href="/listErrorMachine">Quay lại</a></span>
													</div>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		<script>
			$( ".code" )
			.keyup(function() {
				var value = $( this ).val();
				if(value){
					$(".concua").load("/loadError", {key: value});
				}
			})
			.keyup();
			// $('.code').keypress(function(){
			// 	var value = $( this ).val();
			// 	alert(value);
			// });
		</script>
		<script type="text/javascript">
			
			jQuery(function ($) {
				$('.input-mask-date').mask('99/99/9999', {value: "dd/mm/yyyy"});
			});
		</script>
		<script type="text/javascript">
			var allCity = [];
			<?php
			if (!empty($listCityKiosk['Option']['value']['allData'])) {
				foreach ($listCityKiosk['Option']['value']['allData'] as $key => $value) {
					echo 'allCity["' . $value['id'] . '"]=[];';
					$dem = 0;
					if (isset($value['district']) && count($value['district']) > 0)
						foreach ($value['district'] as $key2 => $value2) {
							$dem++;
							echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]=[];';
							echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]["1"]=' . $value2['id'] . ';';
							echo 'allCity["' . $value['id'] . '"]["' . $dem . '"]["2"]="' . $value2['name'] . '";';
						}
					}
				}
				?>
				function getDistrict(city, district)
				{
					var mangDistrict = allCity[city];
					var dem = 1;
					var chuoi = "<option value=''>--- Đang tìm quận/huyện ---</option>";
					$('#listDistrict').html(chuoi);

					chuoi = "<option value=''>--- Tất cả quận/huyện ---</option>";

					while (typeof (mangDistrict[dem]) != 'undefined')
					{
						if (mangDistrict[dem][1] != district) {
							chuoi += "<option value='" + mangDistrict[dem][1] + "'>" + mangDistrict[dem][2] + "</option>";
						} else {
							chuoi += "<option value='" + mangDistrict[dem][1] + "' selected>" + mangDistrict[dem][2] + "</option>";
						}

						dem++;
					}

					$('#listDistrict').html(chuoi);

				}

				<?php
				if (!empty($data['Place']['idCity'])) {
					if (!empty($data['Place']['idDistrict'])) {
						echo 'getDistrict(' . $data['Place']['idCity'] . ',' . $data['Place']['idDistrict'] . ')';
					} else {
						echo 'getDistrict(' . $data['Place']['idCity'] . ',0)';
					}
				}
				?>

			</script>
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
				
		</script> -->
		<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>