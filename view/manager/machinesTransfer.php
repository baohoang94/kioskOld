<!-- machinesTransfer.php
 * Người tạo: Nguyễn Tiến Hưng.
 * Ngày tạo: 26/08/2018.
 * Ghi chú:
 * Mục đích: file html cho chức năng tra cứu máy giao dịch.
 * Lịch sử sửa:

  -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Tra cứu máy không có giao dịch</title>
	</head>
	<body>
		<form action="" method="POST">
		</form>
	</body>
</html>
 <?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default listDevice1">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Tra cứu máy không có giao dịch</li>

				</ul>
			</div>
			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<form action="" method="GET">
									<tr>
										<td>
											<input type="text" value="<?php echo @$_GET['dateStart']; ?>" name="dateStart" id="" placeholder="Từ ngày.VD: <?php echo date('d/m/Y H:i:s',(time()-3600)); ?>" class="datetimepicker form-control" size="29">
										</td>
										<td>
											<input type="text" value="<?php echo @$_GET['dateEnd'];?>" name="dateEnd" id="" placeholder="Đến ngày.VD: <?php echo date('d/m/Y H:i:s',time()); ?>" class="datetimepicker form-control" size="29">
										</td>
                    <td>
											<select name="idChannel" class="form-control">
												<option value="">Kênh bán hàng</option>
												<?php
												global $modelOption;
												$listChannelProduct=$modelOption->getOption('listChannelProduct');
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
                      <select name="MachineTransfer" class="form-control">
                      <option value="notTransfered">Máy không có giao dịch</option>
                    </select>
                    </td>
                    <td rowspan="">
                      <div>
											<button class="add_p1">Tìm kiếm</button>
                      </div>
                    </td>
									</tr>
									<tr>
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
												<option value="">Chọn điểm đặt</option>
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
											<select class="form-control" name="statusMachine">
												<option value="">Trạng thái máy</option>
												<?php
												foreach($listStatusMachine as $status){
													if(empty($_GET['statusMachine']) || $_GET['statusMachine']!=$status['id']){
														echo '<option value="'.$status['id'].'">'.$status['name'].'</option>';
													}else{
														echo '<option selected value="'.$status['id'].'">'.$status['name'].'</option>';
													}
												}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td>
											<input type="text" maxlength="50" class="form-control" placeholder="Mã máy" name="codeMachine" value="<?php echo @arrayMap($_GET['codeMachine']);?>">
										</td>
										<td>
											<select name="typedateEndPay" class="form-control" placeholder="Xã">
												<option value="">Hình thức thanh toán</option>
												<?php
												global $listTypePay;
												if(!empty($listTypePay)){
													foreach ($listTypePay as $key => $value) {

														?>
														<option value="<?php echo $value['id']?>" <?php if(!empty($_GET['typedateEndPay'])&&$_GET['typedateEndPay']==$value['id']) echo'selected';?>><?php echo $value['name']?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
											<select name="status" class="form-control" placeholder="Trạng thái thanh toán">
												<option value="">Trạng thái thanh toán</option>
												<?php
												global $listStatusPay;
												if(!empty($listStatusPay)){
													foreach ($listStatusPay as $key => $value) {

														if($key==0){
															?>
															<option value="00" <?php if(isset($_GET['status'])&&$_GET['status']!=''&&$_GET['status']==$value['id']) echo'selected';?>><?php echo $value['name']?></option>
															<?php
														}else{
															?>
															<option value="<?php echo $value['id']?>" <?php if(isset($_GET['status'])&&$_GET['status']!=''&&$_GET['status']==$value['id']) echo'selected';?>><?php echo $value['name']?></option>
															<?php
														}

													}
												}
												?>
											</select>
										</td>
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
						</div>
					</div>


					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Mã máy</th>
										<th class="text_table">Tên máy</th>
										<th class="text_table">Thời gian giao dịch cuối cùng</th>
										<th class="text_table">Mã nhân viên</th>
										<th class="text_table">Trạng thái máy hiện tại</th>
									</tr>
								</thead>
								<tbody>
									<?php

									global $listTypePay;
									global $listStatusPay;
									if(!empty($data1)){

											if (!isset($_GET['page'])) {
												$i=0;
											}
											elseif (isset($_GET['page'])&&$_GET['page']==1) {
												$i=0;
											}elseif (isset($_GET['page'])>=2)
											{
												$i=$_GET['page']*500-500;
											}

											foreach($data1 as  $data){
												$i++;
												echo '<tr>
												<td class="text_table">'.$i.'</td>
												<td class="text_table"><a href="infoMachine?id='.$data['Machine']['id'].'">'.$data['Machine']['code'].'</a></td>
												<td class="text_table">'.$data['Machine']['name'].'</td>
												<td class="text_table">'.@date('d/m/Y H:i:s',$data['Machine']['timeServer']).'</td>
												<td class="text_table">';
												if (!empty($data['Machine']['idStaff'])) {

												echo '<a href="'.$urlHomes.'viewStaff/'.@$data['Machine']['idStaff'].'">'.@$data['Machine']['codeStaff'].'</a>';
											}
												else
													{echo 'Admin';}
												echo '</td>
												<td class="text_table">'.$listStatusMachine[$data['Machine']['status']]['name'].'</td>
												</tr>';
											}

										}
										else{
												echo '<tr><td align="center" colspan="12">Không có dữ liệu</td></tr>';
											}
											echo '<tr><td align="center" colspan="12"> Các máy không có giao dịch</td></tr>';

									?>

								</tbody>
							</table>
						</div>
						<?php
						if (!empty($data1)) {
								# code...
							?>
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
							<?php
						}
						?>

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
				});
			</script>
			<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
