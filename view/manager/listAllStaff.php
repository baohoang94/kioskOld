<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
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
									<!-- <td>
										<div class="add_p">
											<a href="addPersonel.php">Thêm nhân viên</a>
										</div>
									</td> -->
									<td>
										<table class="table table-bordered">
											<form action="" method="GET">
												<tr>
													<td>
														<input type="text" class="form-control" placeholder="Họ tên" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
													</td>
													<td>
														<input type="text" class="form-control" placeholder="Mã nhân viên" name="code" value="<?php echo @arrayMap($_GET['code']);?>">
													</td>
													<td>
														<input type="text" value="<?php echo @$_GET['birthday'];?>" name="birthday" id="" placeholder="Ngày sinh" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989"  class="input_date form-control" >
													</td>
													<td>
														<input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo @arrayMap($_GET['email']);?>" maxlength="50">
													</td>

													<td rowspan="4">
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
												<tr>
													<td>
														<input type="text" name="phone" maxlength="50" placeholder="Số điện thoại" class="form-control" value="<?php echo @arrayMap($_GET['phone']);?>">
													</td>
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
														<select name="idCity" class="form-control" placeholder="Tỉnh/Thành phố" onchange="getDistrict(this.value, 0)">
															<option value="">Chọn Tỉnh/Thành phố</option>
															<?php
															global $modelOption;
															$listCityKiosk= $modelOption->getOption('cityKiosk');
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

												</tr>
												<tr>
													<td>
														<select  name="wards" class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
															<option value="">Chọn Xã/Phường</option>
															<!--  -->
														</select>
													</td>
													<td>
														<input type="text" class="form-control" value="<?php echo @arrayMap($_GET['address']);?>" placeholder="Số nhà, Đường" name="address" maxlength="100">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['dateTrial']);?>" name="dateTrial" id="" placeholder="Ngày vào thử việc" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['dateStart']);?>" name="dateStart" id="" placeholder="Ngày làm chính thức" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
													</td>

												</tr>
												<tr>
													<td>
														<input type="text" class="form-control" value="<?php echo @arrayMap($_GET['position']);?>" placeholder="Vị trí chức danh công việc" maxlength="100" name="position">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['directManager']);?>" class="form-control" placeholder="Quản lý trực tiếp" maxlength="100" name="directManager">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['indirectManager']);?>" class="form-control" placeholder="Quản lý gián tiếp" maxlength="100" name="indirectManager">
													</td>
													<td>
														<select name="idCompany" class="form-control">
															<option value="">Chọn công ty</option>
															<?php if (!empty($listCompany)) {
																foreach ($listCompany as $key => $value) {
																	?>
																	<option value="<?php echo $value['Company']['id'] ?>" <?php echo (isset($_GET['idCompany'])&&$value['Company']['id']==$_GET['idCompany'])?'selected':'' ?>><?php echo $value['Company']['name'] ?></option>}
																	option
																	<?php
																}
															} ?>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<select name="idBranch" class="form-control">
															<option value="">Chọn chi nhánh</option>
															<?php if (!empty($listBranch)) {
																foreach ($listBranch as $key => $value) {
																	?>
																	<option value="<?php echo $value['Branch']['id'] ?>" <?php echo (isset($_GET['idBranch'])&&$value['Branch']['id']==$_GET['idBranch'])?'selected':'' ?>><?php echo $value['Branch']['name'] ?></option>}
																	option
																	<?php
																}
															} ?>
														</select>
													</td>
													<td>
														<select name="idPermission" class="form-control">
															<option value="">Chọn nhóm phân quyền</option>
															<?php if (!empty($listPermission)) {
																foreach ($listPermission as $key => $value) {
																	?>
																	<option value="<?php echo $value['Permission']['id'] ?>" <?php echo (isset($_GET['idPermission'])&&$value['Permission']['id']==$_GET['idPermission'])?'selected':'' ?>><?php echo $value['Permission']['name'] ?></option>}
																	option
																	<?php
																}
															} ?>
														</select>
													</td>

													<td></td>
													</form>
													<td>
														<form action="" method="POST">
																<td>
					  											<input type="" name="inport" value="1" class="hidden">
					  											<button class="add_p1" type="submit">Xuất file excel</button>
															</td>
														</form>
													</td>

												</tr>

										</table>
									</td>
								</tr>
							</table>
							<table class="table table-bordered">
								<tr>
			              <div class="add_p">
			              	<a href="/addNewStaff">Thêm nhân viên mới</a>
			              </div>
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
										<th class="text_table">Số điện thoại</th>
										<th class="text_table">Địa chỉ</th>
										<!-- 	<th>Chú thích</th> -->
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
										foreach ($listData as $key => $value) {
												# code...
											$i++;
											?>
											<tr>
												<td class="text_table"><?php echo $i;?></td>
												<td><a href="/viewStaff/<?php echo $value['Staff']['id']?>"><?php echo $value['Staff']['code'];?></a></td>
												<td>
													<?php
													echo'<a href="/viewStaff/'.$value['Staff']['id'].'" title="Xem">'.$value['Staff']['fullName'].'</a>';
													?>
												</td>
												<td class="text_table"><?php echo $value['Staff']['birthday'];?></td>
												<td><?php echo $value['Staff']['email'];?></td>
												<td><?php echo $value['Staff']['phone'];?></td>
												<td><?php echo @$value['Staff']['address'];?></td>
												<!-- <td></td> -->
												<td>
													<ul class="list-inline list_i" style="">
														<li>
															<a href="/informationStaff/<?php echo $value['Staff']['id'];?>" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a>

														</li>
														<?php echo '
														<li><a href="/infoStaffCompany?id='.$value['Staff']['id'].'" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
														<li>';
														?>
														<?php
														if(@in_array('deleteStaffCompany',$_SESSION['infoStaff']['Staff']['permission'])||isset($_SESSION['infoStaff']['Staff']['type'])){
															?>
															<?php 	echo'
															<li>
															<a href="/deleteStaffByGovernance?id='.$value['Staff']['id'].'" title="Khóa" onclick="return confirm("Bạn có chắc chắn muốn khóa tài khoản nhân viên không?")" class="bg_red"><i class="fa fa-key" aria-hidden="true"></i></a>
															</li>'; ?>
														<?php } ?>
														<?php if(isset($_SESSION['infoStaff']['Staff']['type']) && $_SESSION['infoStaff']['Staff']['type']=='admin'){
															echo '<li>
															<a href="/permissionStaff?id='.$value['Staff']['id'].'" title="Phân quyền nhân viên" class="bg_green"><i class="fa fa fa-cog" aria-hidden="true"></i></a>
															</li>';
														}?>
														<!-- <li>
															<a href="/deleteStaffByGovernance?id=<?php echo $value['Staff']['id'];?>" title="Khóa" onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản nhân viên không?')" class="bg_red"><i class="fa fa-key" aria-hidden="true"></i></a>
														</li> -->
														<!-- <?php if(empty($value['Staff']['type']) || $value['Staff']['type']!='admin'){ ?>
														<li>
															<a href="/permissionStaff?id=<?php echo $value['Staff']['id'];?>" title="Phân quyền nhân viên" class="bg_green"><i class="fa fa fa-cog" aria-hidden="true"></i></a>
														</li>
														<?php }?> -->
													</ul>
												</td>
											</tr>
											<?php
										}
									}
									else
									{
										echo '
										<tr>
										<td colspan="8" rowspan="" headers="" align="center">Chưa có dữ liệu</td>
										</tr>';
									}
									?>

								</tbody>
							</table>
						</div>
						<?php
						if(!empty($listData)) { ?>
							<div class=" text-center p_navigation" style="<?php if($totalPage==1) echo'display: none;';?>">
								<nav aria-label="Page navigation">
									<ul class="pagination">
										<?php
										if ($page > 2) {
											$startPage = $page - 2;
										} else {
											$startPage = 1;
										}

										if ($totalPage > $page + 2) {
											$endPage = $page + 2;
										} else {
											$endPage = $totalPage;
										}
										?>
										<li class="<?php if($totalPage==1) echo'disabled';?>">
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
										<li>
											<a href="<?php echo $urlPage . $next ?>" aria-label="Next">
												<span aria-hidden="true">»</span>
											</a>
										</li>
									</ul>
								</nav>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>



		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(function ($) {
		$('.input-mask-date').mask('99/99/9999', {placeholder: "dd/mm/yyyy"});
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
			if (!empty(@arrayMap($_GET['idDistrict']))) {
				if (!empty(@arrayMap($_GET['wards']))) {
					echo 'getWards('.@arrayMap($_GET['idCity']).',' . @arrayMap($_GET['idDistrict']) . ',"' . @arrayMap($_GET['wards']) . '")';
				} else {
					echo 'getWards('.@arrayMap($_GET['idCity']).',' . @arrayMap($_GET['idDistrict']) . ',0)';
				}
			}
			?>

		</script>
		<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
