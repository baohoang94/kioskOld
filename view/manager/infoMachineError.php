<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Xem chi tiết máy</li>
				</ul>

			</div>
			
			<!-- <div class="main_list_p "> -->
				<div class="main_add_p">
					<div class="card">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Thông tin</a></li>
						</ul>


						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="home">
								<form action="" method="post">
									<?php
									if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
										?>
										<div class="row">
											<div class="col-sm-12">
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Tên máy <span class="color_red">*</span>: </label>
															<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($data['Machine']['name']);?>" placeholder="Tên máy" class="form-control" name="name" required="" disabled >
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Mã máy <span class="color_red">*</span>: </label>
															<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="" value="<?php echo @arrayMap($data['Machine']['code']);?>" placeholder="Mã máy" class="form-control" name="code" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Mã tài sản <span class="color_red">*</span>: </label>
															<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="" value="<?php echo @arrayMap($data['Machine']['codeasset']);?>" placeholder="Mã tài sản" class="form-control" name="codeasset" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Số imei <span class="color_red">*</span>: </label>
															<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($data['Machine']['imei']);?>" placeholder="Số imei" class="form-control"  name="imei" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Ngày sản xuất máy <span class="color_red">*</span>: </label>
															<input type="text" value="<?php echo @$data['Machine']['dateManufacture'];?>" name="dateManufacture" id="" placeholder="Ngày sản xuất" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Ngày nhập kho <span class="color_red">*</span>: </label>
															<input type="text" value="<?php echo @$data['Machine']['dateStorage'];?>" name="dateStorage" id="" placeholder="Ngày nhập kho"  data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Giá máy (vnđ) <span class="color_red">*</span>: </label>
															<input type="text" title="" maxlength="100" id="" value="<?php echo @arrayMap($data['Machine']['priceMachine']);?>" placeholder="Giá máy" class="input_money form-control"  name="priceMachine" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Trạng thái <span class="color_red">*</span>: </label>
															<input type="text" value="<?php echo @arrayMap($listStatusMachine[$data['Machine']['status']]['name']);?>" id=""   placeholder="Trạng thái" class="input_date form-control" required="" disabled>
															
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Ngày lắp đặt máy tại điểm bán <span class="color_red">*</span>: </label>
															<input type="text" value="<?php echo @arrayMap($data['Machine']['dateInstallation']);?>"  placeholder="Ngày lắp đặt máy tại điểm bán" name="dateInstallation" id=""  data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Kỹ thuật lắp đặt <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['nameInstallation']);?>" placeholder="Kỹ thuật lắp đặt" name="nameInstallation" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Ngày đưa vào sử dụng <span class="color_red">*</span>: </label>
															<input type="text" value="<?php echo @arrayMap($data['Machine']['dateStartRun']);?>" placeholder="Ngày đưa vào sử dụng" name="dateStartRun" id=""  data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Hạn bảo hành định kì <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['warrantyCycle']);?>" placeholder="Hạn bảo hành định kì" name="warrantyCycle" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Hạn bảo hành NSX <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['warrantyManufacturer']);?>" placeholder="Hạn bảo hành NSX" name="warrantyManufacturer" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Loại máy <span class="color_red">*</span>: </label>
															<input type="text" value="<?php echo @arrayMap($data['Machine']['typeMachine']);?>" placeholder="Loại máy" name="typeMachine" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Nhà sản xuất <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['manufacturer']);?>" placeholder="Nhà sản xuất" name="manufacturer" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Chiều cao máy (m) <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['heightMachine']);?>" placeholder="Chiều cao (m)" name="heightMachine" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Chiều rộng máy (m) <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['widthMachine']);?>" placeholder="Chiều rộng (m)" name="widthMachine" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Chiều sâu máy (m) <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['depthMachine']);?>" placeholder="Chiều sâu (m)" name="depthMachine" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Cân nặng máy (kg) <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($data['Machine']['weightMachine']);?>" placeholder="Cân nặng (kg)" name="weightMachine" id=""  class="form-control" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Mã nhân viên phụ trách <span class="color_red">*</span>: </label>
															<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" value="<?php echo @arrayMap($data['Machine']['codeStaff']);?>" placeholder="Mã nhân viên" name="codeStaff" id=""  class="form-control" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Điểm đặt <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" value="<?php echo @arrayMap($place['Place']['name']);?>" placeholder="Điểm đặt" name="codeStaff" id=""  class="form-control" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Tọa độ <span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" name="location" class="form-control" placeholder="Tọa độ vd:20.9789411,105.8481691"  value="<?php echo @arrayMap($data['Machine']['location']);?>" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label>Hình ảnh minh họa : </label>
														<div class="img_machine">
															<img src="<?php echo @arrayMap($data['Machine']['image']);?>" class="img-responsive" alt="">
														</div>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group">
														<span class="btn_ad_back"><a href="/listMachineError">Quay lại</a></span>
													</div>
												</div>
												
											</div>
										</div>

									</form>
									<!--Lấy tọa độ GPS-->
								</div>

							</div>
						</div>
					</div>

				</div>

				<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>