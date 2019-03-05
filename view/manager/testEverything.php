<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">test web</li>
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
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayTo']);?>" name="dayTo" id="" placeholder="Từ ngày" class="datetimepicker form-control">
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayForm']);?>" name="dayForm" id="" placeholder="Đến ngày" class="datetimepicker form-control">
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
										<td rowspan="">
											<button class="add_p1" type="submit" name="submit">Tìm kiếm</button>
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
												<!--  -->
											</select>
										</td>

										<td>

										</td>
									</form>
									<form  method="post">
										<td >
											<input type="" name="inport" value="1" class="hidden">
                      <button class="btn btn-danger" type="submit">Xóa</button>
										</td>
									</form>

										<td >
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
										<th class="text_table">Thời gian</th>
										<th class="text_table">OrderID</th>
										<th class="text_table">Mã sản phẩm</th>
										<th class="text_table">Số lượng</th>
									</tr>
								</thead>

								<tbody>
									<?php

									if(!empty($listData)){
										$i=0;
											foreach ($listData as $key => $value) {
												++$i;
												echo'
											<tr>
											<td >'.$i.'</td>
											<td class="text_table" style="text-align">'.date('d/m/Y H:i:s',$value['Transfer']['timeServer']).'</td>
											<td class="text_table" style="text-align">'.$value['Transfer']['orderId'].'</td>
											<td class="text_table" style="text-align">'.$value['Transfer']['codeProduct'].'</td>
											<td class="text_table" style="text-align">'.$value['Transfer']['quantity'].'</td>
											</tr>
											';
											}

									}else{
										echo '<tr><td align="center" colspan="18">Chưa có dữ liệu</td></tr>';
									}

									?>



								</tbody>
							</table>
						</div>
						<?php
						if(!empty($listData)){
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
		//var allPlace = [];
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
				//console.log(allCity[city]);
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
			var allPlace = [];
			<?php
			if (!empty($listCityKiosk['Option']['value']['allData'])) {
				$modelWards= new Wards;
				$modelPlace= new Place;
				foreach ($listCityKiosk['Option']['value']['allData'] as $key => $value) {
					echo 'allWards["' . $value['id'] . '"]=[];';
					echo 'allPlace["' . $value['id'] . '"]=[];';
					//$dem = 0;
					if (isset($value['district']) && count($value['district']) > 0)
						foreach ($value['district'] as $key2 => $value2) {
							//$dem++;
							echo 'allWards["' . $value['id'] . '"]["' . $value2['id'] . '"]=[];';
							echo 'allPlace["' . $value['id'] . '"]["' . $value2['id'] . '"]=[];';
							$listWards=$modelWards->find('all',array('conditions'=>array('idCity'=> $value['id'], 'idDistrict'=>$value2['id'] )));
							$listPlace=$modelPlace->find('all',array('conditions'=>array('idCity'=>array("1"),'idDistrict'=>array("1")) ));
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
							} //đóng if(!empty($listWard)).

							if(!empty($listPlace)) {
								$count=0;
								foreach ($listPlace as $keyPlace => $valuePlace) {
									$count++;
								echo 'allPlace["'. $value3['Wards']['idCity'] . '"]["' . $value3['Wards']['idDistrict'] . '"]["' . $count . '"]["1"]="' . $valuePlace['Place']['name'] . '";';
								echo 'allPlace["'. $value3['Wards']['idCity'] . '"]["' . $value3['Wards']['idDistrict'] . '"]["' . $count . '"]["2"]="' . $valuePlace['Place']['id'] . '";';
									}
								} //đóng if(!empty($listPlace)).


						}
					}
				}

				?>

				function getWards(city,district, wards)
				{
					var mangWards = allWards[city][district];
					var dem = 1;
					var chuoi = "<option value=''>--- Chọn Xã/Phường ---</option>";
					console.log(allWards[city]);
					console.log(allPlace);
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
						 // $("#listWards").blur(function(){
							//  var idCity= $("#listCity").val(); //tỉnh/thành phố.
							//  var idDistrict = $("#listDistrict").val(); //quận/huyện.
							//  var idWard= $("#listWards").val();//Xã/phường.
							//  var idPlace = $("#idPlace").val();
							//  $.get("kiosk/controller/reportController.php",{idCity:idCity , idDistrict:idDistrict , wards:idWard }, function(data){
							// 	 $("#idPlace").html(idPlace);
							//  });
						 // });
				});
			</script>
<select id="select-meal-type" multiple="multiple" onchange="multi()">
	<option value="1">Breakfast</option>
	<option value="2">Lunch</option>
	<option value="3">Dinner</option>
	<option value="4">Snacks</option>
	<option value="5">Dessert</option>
</select>
<script>
	function multi() {
		var values = $('#select-meal-type').val();
		console.log(values);
	}
</script>
	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
<script>
	$(function(){
		console.log(document.URL);
	});
	
</script>