<!--
// * Ngay tao:
// * Người tạo : Nguyễn Tiến Hưng.
// * Ghi chú:
// * Lịch sử sửa:
//  + Lần sửa:
//  + Ngay:
//  + Người sửa:
//  + Nội dung sửa:
//
  -->
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php';  ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Đối soát dữ liệu giao dịch(chênh lệch = máy kiosk - server VMS)</li>
				</ul>

			</div>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<tr>
									<td>
										<div class="add_p" >
											<a href="/syncTransferUpload">upload dữ liệu</a>
										</div>
									</td>
									<td>
										<form>
											<table class="table table-bordered">
												<tr>
													<td>
														<input type="text" value="<?php echo @$_GET['dateStart']; ?>" name="dateStart" id="" placeholder="Từ ngày" class="datetimepicker form-control">
													</td>
													<td>
														<input type="text" value="<?php echo @$_GET['dateEnd'];?>" name="dateEnd" id="" placeholder="Đến ngày" class="datetimepicker form-control">
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
															$listCityKiosk=$modelOption->getOption('cityKiosk');
															if (!empty($listCityKiosk['Option']['value']['allData'])) {
																foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
																	if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
																		echo '<option value="' . $city['id'] . '">' . arrayMap($city['name']) . '</option>';
																	} else {
																		echo '<option value="' . arrayMap($city['id']) . '" selected>' . $city['name'] . '</option>';
																	}
																}
															}
															?>

														</select>
													</td>

													<td rowspan="2">
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
												<tr>

													<td>
														<select  name="idDistrict" class="form-control" placeholder="Huyện/Quận" id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
															<option value="">Chọn Quận/Huyện</option>
														</select>
													</td>
													<td>

														<select  name="wards" class="form-control" placeholder="Chọn Xã/Phường" id="listWards" >
															<option value="">Chọn Xã/Phường</option>

														</select>
													</td>
			                    <td>
														<select name="idPlace" class="form-control" placeholder="Chọn điểm đặt" id="idPlace">
															<option value="1">Chọn điểm đặt</option>
															<?php
															if(!empty($listPlace)){
																foreach ($listPlace as $key => $value) {

																	?>
																	<option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($_GET['idPlace'])&&$_GET['idPlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
																	<?php
																}
															}

															?>
														</select>
													</td>
													<td>
														<select class="form-control" name="codeMachine" id="codeMachine">
															<option value="" >Mã máy</option>
															<?php
																if(!empty($listMachine)){
																	foreach ($listMachine as $valueMachine) {
																		?>
																		<option value="<?php echo $valueMachine['Machine']['code'];?>" <?php if(!empty($_GET['codeMachine'])&&$_GET['codeMachine']==$valueMachine['Machine']['code']) echo'selected';?>><?php echo $valueMachine['Machine']['code'];?></option>
																		<?php
																	}
																}
															 ?>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<select class="form-control" name="type">
															<option value="">Chọn kiểu đối soát</option>
															<?php
																$listType=array(
																	'1'=>'Toàn bộ giao dịch',
																	'2'=>'Giao dịch thành công'
																);
																foreach($listType as $keyType => $type){
																	if(empty($_GET['type']) || $_GET['type']!=$keyType){
																		echo '<option value="'.$keyType.'">'.$type.'</option>';
																	}else{
																		echo '<option selected value="'.$keyType.'">'.$type.'</option>';
																	}
																}

															 ?>
														</select>
													</td>
													<td></td>
													<td></td>
													<td></td>
													</form>
														<form action="" method="POST">
																<td>
					  											<input type="" name="inport" value="1" class="hidden">
					  											<button class="add_p1" type="submit">Xuất file excel</button>
															</td>
														</form>

												</tr>

											</table>

									</td>
								</tr>
							</table>
							<table class="table table-bordered">
								<tr>
									<form action="" method="POST">
			              <td rowspan="2">
			                <button class="add_p1" name="sync" >Đồng bộ</button>
			              </td>
			            </form>
								</tr>
							</table>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered table-hover" >
								<thead>
									<tr>
										<th align="top" class="text_table" rowspan="2">Thời gian</th>
										<th align="top" class="text_table" rowspan="2">Mã máy</th>
										<th align="top" class="text_table" rowspan="2">Điểm đặt</th>
										<th align="top" class="text_table" colspan="3">Tổng số giao dịch</th>
										<!-- <th align="top" class="text_table" rowspan="2">Chênh lệch giao dịch</th> -->
										<th align="top" class="text_table" colspan="3">SL hàng bán ra</th>
										<!-- <th align="top" class="text_table" colspan="2">SL hàng giảm giá</th> -->
										<!-- <th align="top" class="text_table" rowspan="2">Chênh lệch SL</th> -->
										<!-- <th align="top" class="text_table" colspan="2">DT bán ra</th> -->
										<!-- <th align="top" class="text_table" colspan="2">DT tiền mặt</th> -->
										<th align="top" class="text_table" colspan="3">Tổng doanh thu</th>
										<!-- <th align="top" class="text_table" rowspan="2">Chênh lệch DT</th> -->
										<!-- <th class="text_table"></th>
										<th class="text_table" ></th> -->
										<th align="top" class="text_table" rowspan="2">Hành động</th>

									</tr>

									<tr>
						        <th>Máy Kiosk</th>
						        <th>Server VMS</th>
										<th>Chênh lệch giao dịch</th>
										<th>Máy Kiosk</th>
						        <th>Server VMS</th>
										<th>Chênh lệch sản lượng</th>
										<!-- <th>Máy Kiosk</th>
						        <th>Server VMS</th> -->
										<!-- <th>Máy Kiosk</th>
						        <th>Server VMS</th> -->
										<!-- <th>Máy Kiosk</th>
						        <th>Server VMS</th> -->
										<th>Máy Kiosk</th>
						        <th>Server VMS</th>
										<th>Chênh lệch SL</th>
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
											$i=$_GET['page']*500-500;
										}
										//$chenhlechSL=0;
										foreach ($listData as $valueData) {
											$chenhlechSL=$valueData['quantitySync']-$valueData['quantityTransfer'];
											$chenhlechDT=$valueData['revenueSync']-$valueData['revenueTransfer'];
											$chenhlechGD=$valueData['countSync']-$valueData['countTransfer'];
											echo '<tr>
											<td class="text_table">'.$_GET['dateStart'].'-'.$_GET['dateEnd'].'</td>
											<td class="text_table"><a href="infoMachine?id='.$valueData['idMachine'].'">'.$valueData['codeMachine'].'</a></td>
											<td class="text_table"><a href="infoPlace?id='.$valueData['idPlace'].'">'.$valueData['namePlace'].'</a></td>
											<td class="text_table">'.$valueData['countSync'].'</a></td>
											<td class="text_table">'.$valueData['countTransfer'].'</a></td>
											<td class="text_table">'.$chenhlechGD.'</a></td>
											<td class="text_table">'.$valueData['quantitySync'].'</a></td>
											<td class="text_table">'.$valueData['quantityTransfer'].'</a></td>
											<td class="text_table">'.$chenhlechSL.'</a></td>
											<td class="text_table">'.$valueData['revenueSync'].'</a></td>
											<td class="text_table">'.$valueData['revenueTransfer'].'</a></td>
											<td class="text_table">'.$chenhlechDT.'</a></td>
											<td>
												<ul class="list-inline list_i" align="center">
													<li><a href="/syncDetails?
													dateStart='.$valueData['dateStart'].'
													&dateEnd='.$valueData['dateEnd'].'
													&idPlace='.$valueData['idPlace'].'
													&namePlace='.$valueData['namePlace'].'
													&codeMachine='.$valueData['codeMachine'].'
													&area='.$valueData['area'].'
													&idDistrict='.$valueData['idDistrict'].'
													&idCity='.$valueData['idCity'].'
													&idChannel='.$valueData['idChannel'].'
													&wards='.$valueData['wards'].'
													&numberHouse='.$valueData['numberHouse'].'
													&idStaff='.$valueData['idStaff'].'
													&idMachine='.$valueData['idMachine'].'
													&idChannel='.$valueData['idChannel'].'
													&status=&typedateEndPay=
													"title="Xem chi tiết"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
												</ul>
											</td>

											</tr>';
										}
									} //đóng if(!empty($listData)).
									else{
										echo '<tr><td align="center" colspan="18">Chưa có dữ liệu</td></tr>';
									}
									?>
								</tbody>
							</table>
						</div>

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

				$(document).ready(function() {
						$("#idSupplier").select2({
										placeholder: "Chọn nhà cung cấp",
										allowClear: true
						 });
						 $("#idPlace").select2({
										placeholder: "Chọn điểm đặt",
										allowClear: true
						 });
						 $("#codeMachine").select2({
							 placeholder: "Mã máy",
							 allowClear: true
						 });
				});


			</script>
	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
