<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">

					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
				</ul>

			</div>

			<!-- <div class="main_list_p "> -->
				<div class="main_add_p">

					<form action="" method="GET">
						<?php
						if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
							?>
							<div class="row">
								<div class="col-sm-12">

									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Họ tên<span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50" id="" placeholder="Họ tên" value="<?php echo @arrayMap($data['Staff']['fullName']);?>" class="form-control" name="fullName" required="">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Mã nhân viên<span class="color_red">*</span>: </label>
												<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="updatecode"  placeholder="Mã nhân viên" value="<?php echo @arrayMap($data['Staff']['code']);?>" class="form-control checkcode" name="code" required="" <?php if(!empty($data['Staff']['code']))echo'disabled';?>>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Giới tính<span class="color_red">*</span>: </label>
												<select class="form-control" required="" name="sex">
													<option value="">Chọn giới tính</option>
													<option value="nam" <?php if(isset($data['Staff']['sex']) && $data['Staff']['sex']=='nam') echo 'selected';?> >Nam</option>
													<option value="nu" <?php if(isset($data['Staff']['sex']) && $data['Staff']['sex']=='nu') echo 'selected';?> >Nữ</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Ngày sinh<span class="color_red">*</span>: </label>
												<input type="text" required=""  placeholder="Ngày sinh"  value="<?php echo @arrayMap($data['Staff']['birthday']);?>" name="birthday" id="birthday" placeholder="Ngày sinh" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Email<span class="color_red">*</span>: </label>
												<input type="email" title="" placeholder="Email"  maxlength="50" id="" value="<?php echo @arrayMap($data['Staff']['email']);?>" class="form-control" name="email" required="" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-zA-Z]{2,3}$">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
                                        <div class="form_add">
                                            <div class="form-group">
                                                <label for="">Mật khẩu<span class="color_red">*</span>: </label>
                                                <input type="password" name="password" placeholder="Nhập mật khẩu" class="form-control" id="" <?php if(empty($data['Staff']['pass'])){echo "required ";}else{ echo "disabled value='********'";}?>  >
                                            </div>
                                        </div>
                                    </div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Số điện thoại<span class="color_red">*</span>: </label>
												<input type="text" name="phone"  placeholder="Số điện thoại" maxlength="50" value="<?php echo @arrayMap($data['Staff']['phone']);?>" class="form-control" required="" >
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label for="">Chọn Vùng<span class="color_red">*</span>:</label>
												<select name="area" placeholder="" class="form-control"  required >
													<option value="">Chọn Vùng</option>
													<?php
													global $listArea;
													foreach($listArea as $area){
														if(empty($data['Staff']['area']) || $data['Staff']['area']!=$area['id']){
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
												<label for="">Chọn Tỉnh/Thành phố<span class="color_red">*</span>:</label>
												<select required name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
													<option value="">Chọn Tỉnh/Thành phố</option>
													<?php
													if (!empty($listCityKiosk['Option']['value']['allData'])) {
														foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
															if (!isset($data['Staff']['idCity']) || $data['Staff']['idCity'] != $city['id']) {
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
											<label for="">Chọn Quận/Huyện<span class="color_red">*</span>:</label>
											<select  name="idDistrict"  required class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
															<option value="">Chọn Quận/Huyện</option>
														</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Xã/Phường<span class="color_red">*</span>:</label>
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
												<label>Số nhà, đường<span class="color_red">*</span>: </label>
												<input type="text" name="address" maxlength="500" placeholder="Số nhà, đường"  class="form-control" value="<?php echo @arrayMap($data['Staff']['address']);?>" required="">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Ngày vào thử việc<span class="color_red">*</span>: </label>
												<input type="text" name="dateTrial" id="" placeholder="Ngày vào thử việc" class="input_date form-control" required="" data-inputmask="'alias': 'date'"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" value="<?php echo @$data['Staff']['dateTrial'];?>">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Ngày làm chính thức<span class="color_red">*</span>: </label>
												<input type="text" name="dateStart" id="" placeholder="Ngày làm chính thức" class="input_date form-control" required="" data-inputmask="'alias': 'date'"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" value="<?php echo @$data['Staff']['dateStart'];?>">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Vị trí, chức danh công việc<span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="500" id="" placeholder="Vị trí, chức danh công việc" class="form-control" name="position" required="" value="<?php echo @arrayMap($data['Staff']['position']);?>">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
                        <label for="">Công ty<span class="color_red">*</span>:</label>
												<select name="idCompany" placeholder="Công ty" class="form-control"  required >
													<option value="">Công ty</option>
													<?php
                            if(!empty($listCompany)){
                              foreach ($listCompany as $key => $value) {
                                ?>
                                <option value="<?php echo $value['Company']['id'] ?>" <?php echo (isset($_GET['idCompany'])&&$value['Company']['id']==$_GET['idCompany'])?'selected':'' ?>><?php echo $value['Company']['name'] ?></option>}
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
                        <label for="">Chi nhánh<span class="color_red">*</span>:</label>
												<select name="idBranch" placeholder="Chi nhánh" class="form-control"  required >
													<option value="">Chi nhánh</option>
													<?php
                            if(!empty($listBranch)){
                              foreach ($listBranch as $key => $value) {
                                ?>
                                <option value="<?php echo $value['Branch']['id'] ?>" <?php echo (isset($_GET['idBranch'])&&$value['Branch']['id']==$_GET['idBranch'])?'selected':'' ?>><?php echo $value['Branch']['name'] ?></option>}
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
                        <label for="">Khối phòng ban<span class="color_red">*</span>:</label>
												<select name="idPermission" placeholder="Khối phòng ban" class="form-control"  required >
													<option value="">Khối phòng ban</option>
													<?php
													   if(!empty($listPermission)){
                               foreach ($listPermission as $key => $value) {
                                 ?>
                                 <option value="<?php echo $value['Permission']['id'] ?>" <?php echo (isset($_GET['idPermission'])&&$value['Permission']['id']==$_GET['idPermission'])?'selected':'' ?>><?php echo $value['Permission']['name'] ?></option>}

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
												<label>Quản lý trực tiếp<span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="200" id="" placeholder="Quản lý trực tiếp" class="form-control" name="directManager" required="" value="<?php echo @arrayMap($data['Staff']['directManager']);?>">
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Quản lý gián tiếp: </label>
												<input type="text" title="" maxlength="200" id="" placeholder="Quản lý gián tiếp" class="form-control" name="indirectManager" value="<?php echo @arrayMap($data['Staff']['indirectManager']);?>">
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Mô tả:</label>
											<textarea class="form-control" maxlength="3000" placeholder="Mô tả"  rows="3" name="desc"><?php echo @$data['Staff']['desc'];?></textarea>

										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<button class="btn_ad" style="display: inline-block !important;" type="submmit">Lưu</button>

										</div>
									</div>
								</div>
							</div>

						</form>
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
						if (!empty($data['Staff']['idCity'])) {
							if (!empty($data['Staff']['idDistrict'])) {
								echo 'getDistrict(' . $data['Staff']['idCity'] . ',' . $data['Staff']['idDistrict'] . ')';
							} else {
								echo 'getDistrict(' . $data['Staff']['idCity'] . ',0)';
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
			if (!empty($data['Staff']['idDistrict'])) {
				if (!empty($data['Staff']['wards'])) {
					echo 'getWards('.$data['Staff']['idCity'].',' . $data['Staff']['idDistrict'] . ',"' . $data['Staff']['wards'] . '")';
				} else {
					echo 'getWards('.$data['Staff']['idCity'].',' . $data['Staff']['idDistrict'] . ',0)';
				}
			}
			?>


		</script>
		<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
