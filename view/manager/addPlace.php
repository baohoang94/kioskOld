<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<!-- <li class="back_page"><a href="/listPlace"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listPlace"> Quản lý điểm đặt</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now"><?php if(!empty($data)){echo'Chỉnh sửa điểm đặt';}else{echo'Thêm điểm đặt mới';}?></li>
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
						<form class="table-responsive table1 " action="" method="POST"  id="keodeo" style="<?php if(!empty($data)) echo'display: none;';?>">
							<?php
							if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
								?>
								<input type="" name="id" class="hidden" value="<?php echo @arrayMap($data['Place']['id']);?>">
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>NCC điểm đặt <span class="color_red">*</span>: </label>
											<select name="idPatner" class="form-control" required 
											<?php if(empty($data['Place']['idPatner'])) echo'id="idPatner"';?>>
											<option value="">Chọn NCC điểm đặt</option>
											<?php
											if(!empty($listPatner)){
												foreach($listPatner as $components){
													if(empty($data['Place']['idPatner']) || $data['Place']['idPatner']!=$components['Patner']['id']){
														echo '<option value="'.$components['Patner']['id'].'">'.$components['Patner']['name'].'</option>';
													}else{
														echo '<option selected value="'.$components['Patner']['id'].'">'.$components['Patner']['name'].'</option>';
													}
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class=" cua"></div>
							<div class="col-sm-12">
								<div class="form-group">
									<button class="btn_ad" style="display: inline-block !important;" type="submit">Lưu</button>
									<span class="btn_ad_back"><a href="/listPlace">Quay lại</a></span>
								</div>
							</div>

						</form>
						<form class="table-responsive table1 " action="" method="POST"  id="keokeo" style="<?php if(empty($data)) echo'display: none;';?>">
							<?php
							if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
								?>
								<input type="" name="id" class="hidden" value="<?php echo @arrayMap($data['Place']['id']);?>">
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>NCC điểm đặt <span class="color_red">*</span>: </label>
											<select name="idPatner" class="form-control" required 
											<?php if(empty($data['Place']['idPatner'])) echo'id="idPatner"';?>>
											<option value="">Lựa chọn</option>
											<?php
											if(!empty($listPatner)){
												foreach($listPatner as $components){
													if(empty($data['Place']['idPatner']) || $data['Place']['idPatner']!=$components['Patner']['id']){
														echo '<option value="'.$components['Patner']['id'].'">'.$components['Patner']['name'].'</option>';
													}else{
														echo '<option selected value="'.$components['Patner']['id'].'">'.$components['Patner']['name'].'</option>';
													}
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="hy">
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Tên điểm đặt <span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="" placeholder="Tên điểm đặt" class="form-control" value="<?php echo @arrayMap($data['Place']['name']);?>" name="name" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Mã điểm đặt <span class="color_red">*</span>: </label>
											<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="updatecode1" class="form-control" value="<?php echo @arrayMap($data['Place']['code']);?>" name="code" required="" placeholder="Mã điểm đặt" pattern="[a-zA-Z0-9-]+$">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Tọa độ GPS : </label>
											<input type="text" title="" maxlength="50" id="" placeholder="Tọa độ GPS" class="form-control" value="<?php echo @arrayMap($data['Place']['gps']);?>" name="gps" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Ngày triển khai lắp đặt <span class="color_red">*</span>: </label>
											<input type="text" maxlength="50" name="dateStartConfig" placeholder="Ngày triển khai lắp đặt"  id="dateStartConfig" value="<?php echo @$data['Place']['dateStartConfig'];?>" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" data-inputmask="'alias': 'date'" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Ngày hiệu lực hợp đồng <span class="color_red">*</span>: </label>
											<input type="text" maxlength="50" name="dateContract" placeholder="Ngày hiệu lực hợp đồng"  id="dateContract" value="<?php echo @$data['Place']['dateContract'];?>" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" data-inputmask="'alias': 'date'" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Thời hạn hợp đồng của điểm đặt <span class="color_red">*</span>: </label>
											<input type="text" maxlength="50" name="timeContract" placeholder="Thời hạn hợp đồng của điểm đặt" id="timeContract" value="<?php echo @arrayMap($data['Place']['timeContract']);?>" class="form-control" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Ngày thành lập của điểm đặt <span class="color_red">*</span>: </label>
											<input type="text" maxlength="50" name="dateStart" id="dateStart" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" placeholder="Ngày thành lập của điểm đặt" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" value="<?php echo @$data['Place']['dateStart'];?>" data-inputmask="'alias': 'date'" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Số điện thoại người liên lạc <span class="color_red">*</span>: </label>
											<input type="text" name="phone" maxlength="50" placeholder="Số điện thoại của người liên lạc"  value="<?php echo @arrayMap($data['Place']['phone']);?>" class="form-control" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Email người liên lạc <span class="color_red">*</span>: </label>
											<input type="email" title="" maxlength="50" id="" placeholder="Email người liên lạc"  value="<?php echo @arrayMap($data['Place']['email']);?>" class="form-control" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-zA-Z]{2,3}$" name="email" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Ngày đưa vào sử dụng máy đầu tiên <span class="color_red">*</span>: </label>
											<input type="text" maxlength="50" name="dateStartRun" placeholder="Ngày đưa vào sử dụng máy đầu tiên" id="dateStartRun" value="<?php echo @$data['Place']['dateStartRun'];?>" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" data-inputmask="'alias': 'date'" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Nhân viên phát triển điểm đặt <span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="" placeholder="Nhân viên phát triển điểm đặt" class="form-control" value="<?php echo @arrayMap($data['Place']['developmentStaff']);?>" name="developmentStaff" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Nhân viên kinh doanh <span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" placeholder="Nhân viên kinh doanh" id="" class="form-control" value="<?php echo @arrayMap($data['Place']['salesStaff']);?>" name="salesStaff" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Trực tiếp quản lí điểm đặt <span class="color_red">*</span>: </label>
											<select name="managementAgency" class="form-control" required="">

												<option value="">Chọn trực tiếp quản lí điểm đặt</option>
												<?php
												global $listManagementAgency;
												foreach($listManagementAgency as $managementAgency){
													if(empty($data['Place']['managementAgency']) || $data['Place']['managementAgency']!=$managementAgency['id']){
														echo '<option value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
													}else{
														echo '<option selected value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
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
											<label>Kênh thuê máy <span class="color_red">*</span>: </label>
											<input type="text" title="" placeholder="Kênh thuê máy" maxlength="50" id="" class="form-control" value="<?php echo @arrayMap($data['Place']['rentalChannel']);?>" name="rentalChannel" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Kênh bán máy <span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="" placeholder="Kênh bán máy" class="form-control" value="<?php echo @arrayMap($data['Place']['salesChannel']);?>" name="salesChannel" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Vùng <span class="color_red">*</span>:</label>
											<select name="area" placeholder="Chọn Vùng" class="form-control">
												<option value="">Chọn Vùng</option>
												<?php
												global $listArea;
												foreach($listArea as $area){
													if(empty($data['Place']['area']) || $data['Place']['area']!=$area['id']){
														echo '<option value="'.$area['id'].'">'.$area['name'].'</option>';
													}else{
														echo '<option selected value="'.$area['id'].'">'.$area['name'].'</option>';
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
											<label for="">Chọn Tỉnh/Thành phố <span class="color_red">*</span>:</label>
											<select required name="idCity" class="form-control" placeholder="Chọn Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
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
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Quận/Huyện <span class="color_red">*</span>:</label>
											<select  name="idDistrict"  required class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
												<option value="">Chọn Quận/Huyện</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Xã/Phường <span class="color_red">*</span>:</label>
											<select  name="wards"  required class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
												<option value="">Chọn Xã/Phường</option>
												<!--  -->
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Số nhà, đường <span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="500" id="" placeholder="Số nhà, đường" value="<?php echo @arrayMap($data['Place']['numberHouse']);?>" class="form-control" name="numberHouse" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Kênh bán hàng <span class="color_red">*</span>: </label>
											<select name="idChannel" class="form-control">
												<option value="">Chọn kênh bán hàng</option>
												<?php 
												global $modelOption;
												$modelPatner= new Patner;
												$listChannel=$modelOption->getOption('listChannelProduct');
												foreach ($listChannel['Option']['value']['allData'] as $key => $value) {
													if (isset($data['Place']['idChannel'])&&$data['Place']['idChannel']==$value['id']) {
														?>
														<option value="<?php echo $value['id'] ?>" selected><?php echo $value['name'] ?></option>
														<?php
													}else
													{
														echo '<option value="'.$value['id'].'" >'.$value['name'].'</option>';

													}
												}
												?>														
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Mô tả điểm đặt máy : </label>
										<textarea class="form-control" placeholder="Mô tả điểm đặt máy" maxlength="3000" name="note"  rows="3" ><?php echo @arrayMap($data['Place']['note']);?></textarea>

									</div>
								</div>
								<div class="col-sm-12" style="<?php if(empty($data))echo'display: none';?>" >
									<div class="form-group">
										<label>Lý do sửa <span class="color_red">*</span>: </label>
										<textarea class="form-control" maxlength="3000" name="reason" required="" rows="3" <?php if(!empty($data))echo'required=""';?> placeholder="Lý do sửa"></textarea>

									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">

									<button class="btn_ad" type="submit" style="display: inline-block !important;">Lưu</button>
									<span class="btn_ad_back"><a href="/listPlace">Quay lại</a></span>
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

				<!-- <script type="text/javascript">
					$("#updatecode1").keyup(function(){
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
				<script type="text/javascript">
					var allWards = [];
					<?php
					if (!empty($listCityKiosk['Option']['value']['allData'])) {
						foreach ($listCityKiosk['Option']['value']['allData'] as $key => $value) {
							echo 'allWards["' . $value['id'] . '"]=[];';
							$dem = 0;
							if (isset($value['district']) && count($value['district']) > 0)
								foreach ($value['district'] as $key2 => $value2) {
									$dem++;
									echo 'allWards["' . $value['id'] . '"]["' . $value2['id'] . '"]=[];';
									$modelWards= new Wards;
									$listWards=$modelWards->find('all',array('conditions'=>array('idCity'=> $value['id'], 'idDistrict'=>$value2['id'] )));
									if (!empty($listWards)) {
										$num=0;
										foreach ($listWards as $key => $value3) {
				// echo 'allWards["'. $value['Wards']['idCity'] . '"]=[];';
				// echo 'allWards["'. $value['Wards']['idCity'] . '"]["' . $value['Wards']['idDistrict'] . '"]=[];';
											
											$num++;
											echo 'allWards["'. $value3['Wards']['idCity'] . '"]["' . $value3['Wards']['idDistrict'] . '"]["' . $num . '"]=[];';
											echo 'allWards["'. $value3['Wards']['idCity'] . '"]["' . $value3['Wards']['idDistrict'] . '"]["' . $num . '"]["1"]="' . $value3['Wards']['id'] . '";';
											echo 'allWards["'. $value3['Wards']['idCity'] . '"]["' . $value3['Wards']['idDistrict'] . '"]["' . $num . '"]["2"]="' . $value3['Wards']['name'] . '";';
											
										}
									}
								}
							}
						}
						?>
						function getWards(city,district, wards)
						{
							var mangWards = allWards[city][district];
							var dem = 1;
							var chuoi = "<option value=''>Chọn Xã/Phường</option>";
							$('#listWards').html(chuoi);

							chuoi = "<option value=''>Chọn Xã/Phường</option>";

							while (typeof (mangWards[dem]) != 'undefined')
							{
								if (mangWards[dem][1] != wards) {
									chuoi += "<option value='" + mangWards[dem][1] + "'>" + mangWards[dem][2] + "</option>";
								} else {
									chuoi += "<option value='" + mangWards[dem][1] + "' selected>" + mangWards[dem][2] + "</option>";
								}

								dem++;
							}

							$('#listWards').html(chuoi);

						}
						<?php
						if (!empty($data['Place']['idDistrict'])) {
							if (!empty($data['Place']['wards'])) {
								echo 'getWards('.$data['Place']['idCity'].',' . $data['Place']['idDistrict'] . ',"' . $data['Place']['wards'] . '")';
							} else {
								echo 'getWards('.$data['Place']['idCity'].',' . $data['Place']['idDistrict'] . ',0)';
							}
						}
						?>
						

					</script>
					<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>