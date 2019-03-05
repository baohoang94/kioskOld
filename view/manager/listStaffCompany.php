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
					<li class="page_prev"><a href="/listBranch?idCompany=<?php echo $_GET['idCompany'];?>"> Danh sách chi nhánh</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/groupPermission?idCompany=<?php echo $_GET['idCompany'];?>&idBranch=<?php echo $_GET['idBranch'];?>"> Danh sách khối phòng ban</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Danh sách nhân viên</li>
				</ul>

			</div>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<tr>
									<td>
										<div class="add_p">
											<a href="/addStaffCompany?idCompany=<?php echo $_GET['idCompany'];?>&idBranch=<?php echo $_GET['idBranch'];?>&idPermission=<?php echo $_GET['idPermission'];?>">Thêm nhân viên mới</a>
										</div>
									</td>
									<td>
										<form action="" method="GET">
											<input type="" name="idCompany" value="<?php echo @arrayMap($_GET['idCompany']);?>" class="hidden">
											<input type="" name="idBranch" value="<?php echo @arrayMap($_GET['idBranch']);?>" class="hidden">
											<input type="" name="idPermission" value="<?php echo @arrayMap($_GET['idPermission']);?>" class="hidden">
											
											<table class="table table-bordered">
												<tr>
													<td>
														<input type="text" class="form-control" placeholder="Họ tên" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
													</td>
													<td>
														<input type="text" name="birthday" id="" placeholder="Ngày sinh" class="input_date form-control"  data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" value="<?php echo @$_GET['birthday'];?>">
													</td>
													<td>
														<input type="" class="form-control" placeholder="Email" name="email" value="<?php echo @arrayMap($_GET['email']);?>">
													</td>
													<td>
														<input type="text" name="phone" maxlength="50"  placeholder="Số điện thoại" class="form-control"   value="<?php echo @arrayMap($_GET['phone']);?>">
													</td>
													<td rowspan="4">
														<button class="add_p1" type="submit">Tìm kiếm</button>
													</td>
												</tr>
												<tr>
													<td>
														<select name="area" placeholder="Vùng" class="form-control">
															<option value="">Chọn Vùng</option>
															<?php
															global $listArea;
															foreach($listArea as $area){
																if(empty($_GET['area']) || $_GET['area']!=$area['id']){
																	echo '<option value="'.$area['id'].'">'.$area['name'].'</option>';
																}else{
																	echo '<option selected value="'.$area['id'].'">'.$area['name'].'</option>';
																}
															}
															?>

														</select>
													</td>
													<td>
														<select  name="idCity" id="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
															<option value="">Chọn Tỉnh/Thành phố </option>
															<?php
															global $modelOption;
															$listCityKiosk = $modelOption->getOption('cityKiosk');
															if (!empty($listCityKiosk['Option']['value']['allData'])) {
																foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
																	if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
																		echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
																	} else {
																		echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
																	}
																}
															}
															?>
														</select>
													</td>
													<td>
														<select  name="idDistrict" class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
															<option value="">Chọn Quận/Huyện</option>
														</select>
													</td>
													<td>
														
														<select  name="wards" class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
															<option value="">Chọn Xã/Phường</option>
															<!--  -->
														</select>
													</td>
												</tr>
												<tr>

													<td>
														<input type="text" class="form-control" placeholder="Số nhà, đường" name="address" maxlength="100" value="<?php echo @arrayMap($_GET['address']);?>">
													</td>
													<td>
														<input type="text" name="dateTrial" id="" placeholder="Ngày vào thử việc" class="input_date form-control"  data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" value="<?php echo @$_GET['dateTrial'];?>">
													</td>
													<td>
														<input type="text" name="dateStart" id="" placeholder="Ngày làm chính thức" class="input_date form-control"  data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" value="<?php echo @$_GET['dateStart'];?>">
													</td>
													<td>
														<input type="text" class="form-control" placeholder="Vị trí chức danh công việc" maxlength="100" name="position" value="<?php echo @arrayMap($_GET['position']);?>">
													</td>
												</tr>
												<tr>
													<td>
														<input type="text" class="form-control" placeholder="Quản lý trực tiếp" maxlength="100" name="directManager" value="<?php echo @arrayMap($_GET['directManager']);?>">
													</td>
													<td>
														<input type="text" class="form-control" placeholder="Quản lý gián tiếp" maxlength="100" name="indirectManager" value="<?php echo @arrayMap($_GET['indirectManager']);?>">
													</td>
													<td></td>
													<td></td>
												</tr>

											</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Mã NV</th>
										<th class="text_table">Họ tên</th>
										<th class="text_table">Ngày sinh</th>
										<th class="text_table">Email</th>
										<th class="text_table">Điện thoại</th>
										<th class="text_table">Địa chỉ</th>
										<th class="text_table">Hành động</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(!empty($listData)){
										if (!isset($_GET['page'])) {
											$i=0;
										}
										elseif (isset($_GET['page'])&&$_GET['page']==1) {
											$i=0;
										}elseif (isset($_GET['page'])>=2)
										{
											$i=$_GET['page']*15-15;
										} 
										foreach($listData as $data){
											$i++;
											echo '<tr>
											<td class="text_table">'.$i.'</td>
											<td>'.$data['Staff']['code'].'</td>
											<td><a href="viewStaff/'.$data['Staff']['id'].'">'.$data['Staff']['fullName'].'</a></td>
											<td>'.$data['Staff']['birthday'].'</td>
											<td>'.$data['Staff']['email'].'</td>
											<td>'.$data['Staff']['phone'].'</td>
											<td>'.$data['Staff']['address'].'</td>
											<td>
											<ul class="list-inline list_i" style="">
											<li><a href="/addStaffCompany?id='.$data['Staff']['id'].'&idCompany='.$data['Staff']['idCompany'].'&idBranch='.$data['Staff']['idBranch'].'&idPermission='.$data['Staff']['idPermission'].'" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li> 
											<li><a href="/infoStaffCom?id='.$data['Staff']['id'].'&idCompany='.$data['Staff']['idCompany'].'&idBranch='.$data['Staff']['idBranch'].'&idPermission='.$data['Staff']['idPermission'].'" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a></li> 

											<li><a onclick="return confirm(\'Bạn có chắc chắn muốn khóa nhân viên không ?\')" href="/deleteStaffCompany?id='.$data['Staff']['id'].'&idCompany='.$data['Staff']['idCompany'].'&idBranch='.$data['Staff']['idBranch'].'&idPermission='.$data['Staff']['idPermission'].'" title="Khóa" class="bg_red"><i class="fa fa-key" aria-hidden="true"></i></a></li>
											</ul>
											</td>
											</tr>';
										}
									}else{
										echo '<tr><td align="center" colspan="9">Chưa có dữ liệu</td></tr>';
									}
									?>
								</tbody>
							</table>
						</div>
						<div class=" text-center p_navigation" style="<?php if(($totalPage==1)||empty($listData)) echo'display: none;';?>">
							<nav aria-label="Page navigation">
								<ul class="pagination">
									<?php
									if ($page > 4) {
										$startPage = $page - 4;
									} else {
										$startPage = 1;
									}

									if ($totalPage > $page + 4) {
										$endPage = $page + 4;
									} else {
										$endPage = $totalPage;
									}
									?>
									<li class="<?php if($page==1) echo'disabled';?>">
										<a href="<?php echo $urlPage . $back; ?>" aria-label="Previous">
											<span aria-hidden="true">«</span>
										</a>
									</li>
									<?php 
									for ($i = $startPage; $i <= $endPage; $i++) {
										if ($i != $page) {
											echo '	<li><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
										} else {
											echo '<li class="active"><a href="' . $urlPage . $i . '">' . $i . '</a></li>';
										}
									}
									?>
									<li class="<?php if($page==$endPage) echo'disabled';?>">
										<a href="<?php echo $urlPage . $next ?>" aria-label="Next">
											<span aria-hidden="true">»</span>
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
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
				chuoi = "<option value=''>Chọn Xã/Phường</option>";
				$('#listWards').html(chuoi);
			}

			<?php
			if (!empty($_GET['idCity'])) {
				if (!empty($_GET['idDistrict'])) {
					echo 'getDistrict(' . $_GET['idCity'] . ',' . $_GET['idDistrict'] . ')';
				} else {
					echo 'getDistrict(' . $_GET['idCity'] . ',0)';
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
					var chuoi = "<option value=''>--- Chọn Xã/Phường ---</option>";
					$('#listWards').html(chuoi);

					chuoi = "<option value=''>--- Chọn Xã/Phường ---</option>";

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
				if (!empty($_GET['idDistrict'])) {
					if (!empty($_GET['wards'])) {
						echo 'getWards('.$_GET['idCity'].',' . $_GET['idDistrict'] . ',"' . $_GET['wards'] . '")';
					} else {
						echo 'getWards('.$_GET['idCity'].',' . $_GET['idDistrict'] . ',0)';
					}
				}
				?>

			</script>
			<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>