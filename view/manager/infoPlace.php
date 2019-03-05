<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listPlace"> Quản lý điểm đặt</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Xem chi tiết điểm đặt</li>
				</ul>

			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#idPatner').on('change', function(){
						var $this = $(this),
						$value = $this.val();
						if($value){ 
							$(".cua").load("/load", {id: $value}); 
						}
					});
				});
			</script>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12 ">
						<form class="table-responsive table1 " action="" method="POST" >
							<?php
							if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
								?>
								<input type="" name="id" class="hidden" value="<?php echo @arrayMap($data['Place']['id']);?>">
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>NCC điểm đặt <span class="color_red">*</span>: </label>
											<?php 
											$modelPatner = new Patner;
											$patner=$modelPatner->getPatner(@$data['Place']['idPatner'],array('name'));
											?>
											<input type="text" title="" maxlength="50" id="" class="form-control" value="<?php echo @$patner['Patner']['name'];?>" name="name" required="" disabled>
										</div>
									</div>
								</div>
								<div class=" cua">

								</div>

								<div class="hy" style="<?php if(empty($data)) echo'display: none;';?>">
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Tên điểm đặt <span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50" id=""  placeholder="Tên điểm đặt" class="form-control" value="<?php echo @arrayMap($data['Place']['name']);?>" name="name" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Mã điểm đặt <span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50" id=""  placeholder="Tên điểm đặt" class="form-control" value="<?php echo @arrayMap($data['Place']['code']);?>" name="name" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Tọa độ GPS: </label>
												<input type="text" title="" maxlength="50" id=""  placeholder="Tọa độ GPS" class="form-control" value="<?php echo @arrayMap($data['Place']['gps']);?>" name="gps" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Ngày triển khai lắp đặt <span class="color_red">*</span>: </label>
												<input type="text" maxlength="50" name="dateStartConfig"  placeholder="Ngày triển khai lắp đặt"  id="dateStartConfig" value="<?php echo @arrayMap($data['Place']['dateStartConfig']);?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" required="" disabled>
											</div>
										</div>
									</div>


									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Ngày hiệu lực hợp đồng <span class="color_red">*</span>: </label>
												<input type="text" name="dateContract"  placeholder="Ngày hiệu lục hợp đồng" id="dateContract" value="<?php echo @arrayMap($data['Place']['dateContract']);?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Thời hạn hợp đồng của điểm đặt <span class="color_red">*</span>: </label>
												<input type="text" maxlength="50" name="timeContract"  placeholder="Thời hạn hợp đồng của điểm đặt" id="timeContract" value="<?php echo @arrayMap($data['Place']['timeContract']);?>" class="form-control" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Ngày thành lập của điểm đặt <span class="color_red">*</span>: </label>
												<input type="text" name="dateStart"  placeholder="Ngày thành lập của điểm đặt" id="dateStart" value="<?php echo @arrayMap($data['Place']['dateStart']);?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Số điện thoại người liên lạc <span class="color_red">*</span>: </label>
												<input type="text" name="phone" maxlength="50"  placeholder="Sô điện thoại người liên lạc" value="<?php echo @arrayMap($data['Place']['phone']);?>" class="form-control" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Email người liên lạc <span class="color_red">*</span>: </label>
												<input type="email" title=""  placeholder="Email người liên lạc"  maxlength="50" id="" value="<?php echo @arrayMap($data['Place']['email']);?>" class="form-control" name="email" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Ngày đưa vào sử dụng máy đầu tiên <span class="color_red">*</span>: </label>
												<input type="text" name="dateStartRun" id="dateStartRun" value="<?php echo @arrayMap($data['Place']['dateStartRun']);?>"  placeholder="Ngày đưa vào sử dụng máy đầu tiên" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" required="" disabled>
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Nhân viên phát triển điểm đặt <span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50"  placeholder="Nhân viên phát triển điểm đặt"  id="" class="form-control" value="<?php echo @arrayMap($data['Place']['developmentStaff']);?>" name="developmentStaff" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Nhân viên kinh doanh <span class="color_red">*</span>: </label>
												<input type="text" title=""  placeholder="Nhân viên kinh doanh" maxlength="50" id="" class="form-control" value="<?php echo @arrayMap($data['Place']['salesStaff']);?>" name="salesStaff" required=" " disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Trực tiếp quản lý điểm đặt <span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50" id=""  placeholder="Trực tiếp quản lý điểm đặt" class="form-control" value="<?php global $listManagementAgency; echo @arrayMap($listManagementAgency[$data['Place']['managementAgency']]['name']);?>" name="salesStaff" required=" " disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Kênh thuê máy <span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50" id=""  placeholder="Kênh thuê máy" class="form-control" value="<?php echo @arrayMap($data['Place']['rentalChannel']);?>" name="rentalChannel" required=" " disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Kênh bán máy <span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50"  placeholder="Kênh bán máy" id="" class="form-control" value="<?php echo @arrayMap($data['Place']['salesChannel']);?>" name="salesChannel" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label for="">Chọn Vùng <span class="color_red">*</span>:</label>
												<input type="text" title="" maxlength="50" id=""  placeholder="Vùng" class="form-control" value="<?php global $listArea; echo @arrayMap($listArea[$data['Place']['area']]['name']);?>" name="salesChannel" required="" disabled>
												
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label for="">Chọn Tỉnh/Thành phố <span class="color_red">*</span>:</label>
												<input type="text" title="" maxlength="50"  placeholder="Chọn Tỉnh/Thành phố"  id="" class="form-control" value="<?php global $listArea; echo @arrayMap($listCityKiosk['Option']['value']['allData'][$data['Place']['idCity']]['name']);?>" name="salesChannel" required="" disabled>
											<!-- <select required name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
												<option value="">Chọn Tỉnh/Thành phố</option>
												<?php
												if (!empty($listCityKiosk['Option']['value']['allData'])) {
													foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
														if (!isset($data['Place']['idCity']) || $data['Place']['idCity'] != $city['id']) {
															echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
														} else {
															echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
														}
													}
												}
												?>
											</select> -->
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Quận/Huyện <span class="color_red">*</span>:</label>
											<input type="text" title="" maxlength="50" id=""  placeholder="Chọn Quận/Huyện"  class="form-control" value="<?php global $listArea; echo @arrayMap($listCityKiosk['Option']['value']['allData'][$data['Place']['idCity']]['district'][$data['Place']['idDistrict']]['name']);?>" name="salesChannel" required="" disabled>
											<!-- <select  name="idDistrict" class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getDistrict(this.value, 0)">
												<option value="">Chọn Quận/Huyện</option>
											</select> -->
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<?php $modelWards =new Wards;
											$wards= $modelWards->find('first', array('conditions'=>array('id'=>$data['Place']['wards']))) ?>
											<label for="">Chọn Xã/Phường <span class="color_red">*</span>:</label>
											<input type="text" title="" maxlength="200" id=""  placeholder="Xã phường" value="<?php echo isset($wards['Wards']['name'])?$wards['Wards']['name']:'';?>" class="form-control" name="wards" required="" disabled>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Số nhà, đường <span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="200" id=""  placeholder="Số nhà, đường" value="<?php echo @arrayMap($data['Place']['numberHouse']);?>" class="form-control" name="numberHouse" required="" disabled>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Kênh bán hàng <span class="color_red">*</span>: </label>
											<?php 
							global $modelOption;
	$modelPatner= new Patner;
	$listChannel=$modelOption->getOption('listChannelProduct');
							foreach ($listChannel['Option']['value']['allData'] as $key => $value) {
								if (isset($data['Place']['idChannel'])&&$data['Place']['idChannel']==$value['id']) {
												$namee=$value['name'];				

							}
						}
							 ?>	
											<input type="text" title="" placeholder="Kênh bán máy" maxlength="50" id="" class="form-control" value="<?php echo isset($namee)?$namee:'';?>" name="salesChannel" required="" disabled>
											
											<!-- <select name="" class="form-control">
												<option value="">Kênh bán hàng</option>
												<option value="2">Đại lý cấp 1</option><option value="3">Trường học</option><option value="4">Bệnh viện</option><option value="5">Khu công nghiệp</option><option value="6">Công cộng</option>														</select> -->
											</div>
										</div>
									</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Mô tả điểm đặt máy : </label>
										<textarea class="form-control"  placeholder="Mô tả điểm đặt máy" maxlength="3000" name="note" rows="3" required="" disabled><?php echo @arrayMap($data['Place']['note']);?></textarea>

									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<span class="btn_ad_back"><a href="/listPlace">Quay lại</a></span>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>

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
					var chuoi = "<option value=''>Chọn Quận/Huyện</option>";
					$('#listDistrict').html(chuoi);

					chuoi = "<option value=''>Chọn Quận/Huyện</option>";

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

			<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>