<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Quản lý điểm đặt</li>
				</ul>

			</div>
<?php
if (!empty($_GET['mess'])&&$_GET['mess']==-2) {
?>
<script type="text/javascript">
	alert("Xóa không thành công. Điểm đặt có tồn tại máy")
</script>
<?php
}
?>
			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<form action="" method="GET">
								<table class="table table-bordered">
									<tr>
										<td>
											<div class="add_p">
												<a href="/addPlace">Thêm điểm đặt mới</a>
											</div>
										</td>
										<td>
											<table class="table table-bordered">
												<tr>
													<td>
														<input type="text" class="form-control" placeholder="Tên điểm đặt" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
													</td>
													<td>
														<!-- chú ý value có arrayMap() -->
														<input type="text" name="code" maxlength="50"  placeholder="Mã điểm đặt" class="form-control" value="<?php echo @arrayMap($_GET['code']);?>">
													</td>
													
													<td>
														<input type="text" value="<?php echo @$_GET['dateContract'];?>" name="dateContract" id="" placeholder="Ngày hiệu lực hợp đồng" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
													</td>
													<td>
														<input type="text" value="<?php echo @$_GET['dateStart'];?>" name="dateStart" id="" placeholder="Ngày thành lập của điểm đặt" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
													</td>
													<td rowspan="5" align="center" valign="center">
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
												<tr>
													
													<td>
														<input type="text" name="phone" maxlength="50"  placeholder="Số điện thoại người liên lạc" value="<?php echo @arrayMap($_GET['phone']);?>" class="form-control" >
													</td>
													<td>
														<input type="text" title="" maxlength="50" id="" placeholder="Email người liên lạc" class="form-control" name="email" value="<?php echo @arrayMap($_GET['email']);?>" >
													</td>
													<td>
														<input type="text" value="<?php echo @$_GET['dateStartRun'];?>" name="dateStartRun" id="" placeholder="Ngày đưa vào sử dụng máy đầu tiên" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
													</td>
													<td>
														<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($_GET['developmentStaff']);?>" class="form-control" placeholder="Nhân viên phát triển điểm đặt" name="developmentStaff" >
													</td>
												</tr>
												<tr>
													<td>
														<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($_GET['salesStaff']);?>" class="form-control" placeholder="Nhân viên kinh doanh" name="salesStaff" >
													</td>
													<td>
														<select name="idChannel" class="form-control">
															<option value="">Kênh bán hàng</option>
															<?php
															if(!empty($listChannelProduct['Option']['value']['allData'])){
																foreach($listChannelProduct['Option']['value']['allData'] as $components){
																	if(empty($_GET['idChannel']) || $_GET['idChannel']!=$components['id']){
																		echo '<option value="'.$components['id'].'">'.$components['name'].'</option>';
																	}else{
																		echo '<option selected value="'.$components['id'].'">'.$components['name'].'</option>';
																	}
																}
															}
															?>
														</select>
													</td>
													<td>
														<select name="managementAgency" class="form-control">
															<option value="">Trực tiếp quản lý điểm đặt</option>
															<?php
															foreach($listManagementAgency as $managementAgency){
																if(empty($_GET['managementAgency']) || $_GET['managementAgency']!=$managementAgency['id']){
																	echo '<option value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
																}else{
																	echo '<option selected value="'.$managementAgency['id'].'">'.$managementAgency['name'].'</option>';
																}
															}
															?>
														</select>
													</td>
													<td>
														<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($_GET['rentalChannel']);?>" class="form-control" placeholder="Kênh thuê máy" name="rentalChannel" >
													</td>
												</tr>
												<tr>
													<td>
														<select name="area" placeholder="Vùng" class="form-control">
															<option value="">Chọn Vùng</option>
															<?php
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
															if (!empty($listCityKiosk['Option']['value']['allData'])) {
																foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
																	if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
																		echo '<option value="' . $city['id'] . '">' . arrayMap($city['name']) . '</option>';
																	} else {
																		echo '<option value="' . $city['id'] . '" selected>' . arrayMap($city['name']) . '</option>';
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
														<input type="text" value="<?php echo @$_GET['dateStartConfig'];?>" name="dateStartConfig" id="" placeholder="Ngày triển khai lắp đặt" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
													</td>
													<td>
														<input type="text" name="gps" maxlength="50"  placeholder="Tọa độ GPS" class="form-control" value="<?php echo @arrayMap($_GET['gps']);?>">
													</td>
													<td>
														<input type="text" name="timeContract" maxlength="50"  placeholder="Thời hạn hợp đồng của điểm đặt" class="form-control" value="<?php echo @arrayMap($_GET['timeContract']);?>">
													</td>
													<td>
														<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($_GET['salesChannel']);?>" class="form-control" placeholder="Kênh bán máy" name="salesChannel" >
													</td>
												</tr>
												<tr>
													<td>
														<input type="text" title="" maxlength="200" id="" placeholder="Số nhà, đường" class="form-control" name="numberHouse" value="<?php echo @arrayMap($_GET['numberHouse']);?>" >
													</td>
													<td></td>
													<td></td>
													<td></td>
												</form>
													<form action="" method="POST">
														<td colspan="">
															<input type="" name="inport" value="1" class="hidden">
															<button class="add_p1" type="submit">Xuất file excel</button>
														</td>
														</form>
												</tr>
											</table>
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
										<th class="text_table">Mã điểm đặt</th>
										<th class="text_table">Tên điểm đặt</th>
										<th class="text_table">Địa điểm</th>
										<th class="text_table">Kênh bán hàng</th>
										<th class="text_table">Tọa độ GPS</th>
										<th class="text_table">Ngày triển khai lắp đặt</th>
										<th class="text_table">NCC điểm đặt</th>
										<th class="text_table">Nhân viên phụ trách</th>
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
										$modelPatner= new Patner();
										foreach($listData as $key=> $data){
											$i++;
											if(!empty($data['Place']['idPatner'])){
												$patner[$key]=$modelPatner->getPatner($data['Place']['idPatner'],array('name'));
											}
											echo '<tr>
											<td class="text_table">'.$i.'</td>
											<td> <a href="/infoPlace?id='.$data['Place']['id'].'">'.$data['Place']['code'].'</a></td>
											<td> <a href="/infoPlace?id='.$data['Place']['id'].'">'.$data['Place']['name'].'</a></td>
											<td>'.@$data['Place']['numberHouse'].'</td>
											<td>'.@$listChannelProduct['Option']['value']['allData'][$data['Place']['idChannel']]['name'].'</td>
											<td>'.@$data['Place']['gps'].'</td>
											<td class="text_table">'.@$data['Place']['dateStartConfig'].'</td>
											<td>'.@$patner[$key]['Patner']['name'].'</td>
											<td>'.@$data['Place']['developmentStaff'].'</td>
											<td>
											<ul class="list-inline list_i" style="">
											<li><a href="/addPlace?id='.$data['Place']['id'].'" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li> 
											<li><a href="/infoPlace?id='.$data['Place']['id'].'" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
											<li><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" href="/deletePlace?id='.$data['Place']['id'].'" title="Xóa" class="bg_red"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
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
									$urlPage = ltrim($urlPage,"?mess=-2");
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
	<!-- <td>'.$listChannelProduct['Option']['value']['allData'][$data['Place']['idChannel']]['name'].'</td> -->
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