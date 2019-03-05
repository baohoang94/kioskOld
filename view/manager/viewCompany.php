<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listCompany"> Danh sách công ty</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Xem chi tiết công ty</li>
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
												<label>Mã công ty<span class="color_red">*</span>: </label>
												<input type="text" title="" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="updatecode" placeholder="" class="form-control checkcode" name="code" required="" value="<?php echo @$data['Company']['code'];?>" <?php if(!empty($data['Company']['code']))echo'disabled';?>>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Tên công ty<span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50" id="" placeholder="" class="form-control"  name="name" required="" value="<?php echo @$data['Company']['name'];?>" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label for="">Người phụ trách<span class="color_red">*</span>:</label>
												<input type="text" title="" maxlength="50" id="" value="<?php echo @$data['Company']['nameBoss'];?>" class="form-control" name="nameBoss" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Mã số thuế<span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50" id="" placeholder="" class="form-control checkcode"  name="taxCode" required="" value="<?php echo @$data['Company']['taxCode'];?>" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Trạng thái<span class="color_red">*</span>: </label>
												<select name="status" class="form-control" required="" disabled="">
												<option value="active" <?php if(isset($data['Company']['status']) && $data['Company']['status']=='active') echo 'selected';?> >Kích hoạt</option>
												<option value="lock" <?php if(isset($data['Company']['status']) && $data['Company']['status']=='lock') echo 'selected';?> >Khóa</option>
											</select>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Số điện thoại<span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="50" id="" placeholder="" class="form-control" name="phone" required="" value="<?php echo @$data['Company']['phone'];?>" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Email<span class="color_red">*</span>: </label>
												<input type="email" title="" maxlength="50" id="" placeholder="" class="form-control"  name="email" required="" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-zA-Z]{2,3}$" value="<?php echo @$data['Company']['email'];?>" disabled>
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label for="">Chọn Vùng<span class="color_red">*</span>:</label>
												<input type="" name="" class="form-control" value="<?php global $listArea; echo @ $listArea[$data['Company']['area']]['name']; ?>" disabled>
											</div>
										</div>
									</div>
									<?php 
									global $modelOption;
									$listCityKiosk = $modelOption->getOption('cityKiosk');
									?>	
									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label for="">Chọn Tỉnh/Thành phố <span class="color_red">*</span>:</label>
												<input type="text" title="" maxlength="50"  placeholder="Chọn Tỉnh/Thành phố"  id="" class="form-control" value="<?php global $listArea; echo @arrayMap($listCityKiosk['Option']['value']['allData'][$data['Company']['idCity']]['name']);?>" name="salesChannel" required="" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Quận/Huyện <span class="color_red">*</span>:</label>
											<input type="text" title="" maxlength="50" id=""  placeholder="Chọn Quận/Huyện"  class="form-control" value="<?php global $listArea; echo @arrayMap($listCityKiosk['Option']['value']['allData'][$data['Company']['idCity']]['district'][$data['Company']['idDistrict']]['name']);?>" name="salesChannel" required="" disabled>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<?php $modelWards =new Wards;
											$wards= $modelWards->find('first', array('conditions'=>array('id'=>$data['Company']['wards']))) ?>
											<label for="">Chọn Xã/Phường <span class="color_red">*</span>:</label>
											<input type="text" title="" maxlength="200" id=""  placeholder="Xã phường" value="<?php echo isset($wards['Wards']['name'])?$wards['Wards']['name']:'';?>" class="form-control" name="wards" required="" disabled>
										</div>
									</div>
								</div>

									<div class="col-sm-4">
										<div class="form_add">
											<div class="form-group">
												<label>Số nhà, đường<span class="color_red">*</span>: </label>
												<input type="text" title="" maxlength="500" id="" placeholder="" class="form-control"  name="address" required="" value="<?php echo @$data['Company']['address'];?>" disabled>
											</div>
										</div>
									</div>
									<div class="col-sm-12" >
										<div class="form-group">
											<label>Ghi chú: </label>
											<textarea class="form-control" maxlength="3000" value="" rows="3" name="note" disabled><?php echo @$data['Company']['note'];?></textarea>

										</div>
									</div>
									<div class="col-sm-12">
													<div class="form-group">
														<span class="btn_ad_back"><a href="/listCompany">Quay lại</a></span>
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
						if (!empty($data['Company']['idCity'])) {
							if (!empty($data['Company']['idDistrict'])) {
								echo 'getDistrict(' . $data['Company']['idCity'] . ',' . $data['Company']['idDistrict'] . ')';
							} else {
								echo 'getDistrict(' . $data['Company']['idCity'] . ',0)';
							}
						}
						?>

					</script>
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
			if (!empty($data['Company']['idDistrict'])) {
				if (!empty($data['Company']['wards'])) {
					echo 'getWards('.$data['Company']['idCity'].',' . $data['Company']['idDistrict'] . ',"' . $data['Company']['wards'] . '")';
				} else {
					echo 'getWards('.$data['Company']['idCity'].',' . $data['Company']['idDistrict'] . ',0)';
				}
			}
			?>

		</script>

					<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>



