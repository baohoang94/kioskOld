<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listCompany"> Danh sách công ty </a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listBranch?idCompany=<?php echo $_GET['idCompany'];?>"> Danh sách chi nhánh</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Xem chi tiết chi nhánh</li>
				</ul>

			</div>

			<!-- <div class="main_list_p "> -->
				<div class="main_add_p">
					<form action="" method="post">
						<?php
							if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
						?>
						<input type="hidden" name="" value="<?php echo @arrayMap($data['Branch']['code']);?>">
						<div class="row">
							<div class="col-sm-12">

								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Tên chi nhánh<span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="" placeholder="Tên chi nhánh" class="form-control" name="name" required="" disabled value="<?php echo @arrayMap($data['Branch']['name']);?>">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Mã chi nhánh<span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="updatecode" placeholder="Mã chi nhánh" class="form-control " pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " name="code" required="" value="<?php echo @arrayMap($data['Branch']['code']);?>" <?php if(!empty($data['Branch']['code']))echo'disabled';?>>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Số điện thoại<span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="" placeholder="Số điện thoại" class="form-control"  name="phone" required=""  disabled value="<?php echo @arrayMap($data['Branch']['phone']);?>">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Email<span class="color_red">*</span>: </label>
											<input type="email" title="" maxlength="50"  disabled id="" placeholder="Email" class="form-control"  name="email" required="" value="<?php echo @arrayMap($data['Branch']['email']);?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-zA-Z]{2,3}$">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Vùng<span class="color_red">*</span>:</label>
											<select name="area" placeholder=""  disabled class="form-control" required="">
												<option value="">Chọn Vùng</option>
												<?php
													global $listArea;
													foreach($listArea as $area){
														if(empty($data['Branch']['area']) || $data['Branch']['area']!=$area['id']){
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
											<select required name="idCity"  disabled class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
												<option value="">Chọn Tỉnh/Thành phố</option>
												<?php
						                        if (!empty($listCityKiosk['Option']['value']['allData'])) {
						                            foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
						                                if (!isset($data['Branch']['idCity']) || $data['Branch']['idCity'] != $city['id']) {
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
											<select  name="idDistrict"  disabled class="form-control" placeholder="Huyện/Quận" id="listDistrict"  required onchange="getWards(idCity.value,this.value, 0)">
															<option value="">Chọn Quận/Huyện</option>
														</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Chọn Xã/Phường<span class="color_red">*</span>:</label>
											<select  name="wards" required  disabled  class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
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
											<input type="text" title="" disabled  maxlength="500" id="" placeholder="Số nhà, số đường" class="form-control"  name="address" required="" value="<?php echo @arrayMap($data['Branch']['address']);?>">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label for="">Người phụ trách<span class="color_red">*</span>:</label>
											<input type="text" title=""  disabled maxlength="50" id="" placeholder="Người phụ trách" value="<?php echo @arrayMap($data['Branch']['nameBoss']);?>" class="form-control" name="nameBoss" required="">
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Ghi chú: </label>
										<textarea class="form-control" disabled  value="Ghi chú" placeholder="Ghi chú" rows="3" name="note" maxlength="3000"><?php echo @arrayMap($data['Branch']['note']);?></textarea>

									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<span class="btn_ad_back"><a href="/listBranch?idCompany=<?php echo $_GET['idCompany'];?>">Quay lại</a></span>
										<!-- <div class="back_page"></div> -->
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
			        var chuoi = "<option value=''> Chọn Quận/Huyện</option>";
			        $('#listDistrict').html(chuoi);

			        chuoi = "<option value=''> Chọn Quận/Huyện</option>";

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
				if (!empty($data['Branch']['idCity'])) {
				    if (!empty($data['Branch']['idDistrict'])) {
				        echo 'getDistrict(' . $data['Branch']['idCity'] . ',' . $data['Branch']['idDistrict'] . ')';
				    } else {
				        echo 'getDistrict(' . $data['Branch']['idCity'] . ',0)';
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
			if (!empty($data['Branch']['idDistrict'])) {
				if (!empty($data['Branch']['wards'])) {
					echo 'getWards('.$data['Branch']['idCity'].',' . $data['Branch']['idDistrict'] . ',"' . $data['Branch']['wards'] . '")';
				} else {
					echo 'getWards('.$data['Branch']['idCity'].',' . $data['Branch']['idDistrict'] . ',0)';
				}
			}
			?>

		</script>
			<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>



