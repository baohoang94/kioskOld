<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">
						Tổng hợp doanh thu theo điểm bán(BC07)
					</li>
				</ul>
			</div>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<tr>
									<form action="" method="GET">
										<td>
											<input type="" name="codeMachine" placeholder="Mã máy" class="form-control" value="<?php echo @arrayMap($_GET['codeMachine']);?>">
										</td>
										<td>
											<select name="idPlace" class="form-control">
												<option value="">Chọn điểm đặt</option>
												<?php
												if(!empty($listPlace)){
													foreach ($listPlace as $key => $value) {
															# code...
														?>
														<option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($_GET['idPlace'])&&$_GET['idPlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
														<?php
													}
												}
												?>
											</select>
											<!-- <input type="text" maxlength="50" class="form-control" placeholder="Mã địa điểm" name="codePlace" value="<?php echo @arrayMap($_GET['codePlace']);?>"> -->
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @$_GET['dayTo'];?>" name="dayTo" id="" placeholder="Từ ngày" class="datetimepicker form-control">
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @$_GET['dayForm'];?>" name="dayForm" id="" placeholder="Đến ngày" class="datetimepicker form-control">
										</td>
										<td rowspan="">
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
											<!--  -->
										</select>
									</td>
									</form>
									<form action="" method="POST">
										<td colspan="">
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
							<table class="table table-bordered table-hover" id="tableID">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Mã máy</th>
										<th class="text_table">Mã điểm đặt</th>
										<th class="text_table">Tên điểm đặt</th>
										<th class="text_table">Kênh bán hàng</th>
										<th class="text_table">Số lượng</th>
										<th class="text_table">Doanh thu tiền mặt</th>
										<th class="text_table">Doanh thu thẻ</th>
										<th class="text_table">Tổng</th>
										<th class="text_table">Mã nhân viên</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(!empty($listData)){
										$modelPlace= new Place;
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
											$i++;
											$soluong=0;
											$tongtien=0;
											$the=0;
											$tien=0;
											if(!empty( $value['Machine']['idPlace'])){
												$place[$key]=$modelPlace->getPlace( $value['Machine']['idPlace'],$fields=array('code','name','idChannel') );
												# code...
												if(!empty($place[$key])){
													@$channel=$listChannel[$place[$key]['Place']['idChannel']]['name'];
													@$name=$place[$key]['Place']['name'];
													@$code=$place[$key]['Place']['code'];
												}else{
													$channel='';
													$name='';
													$code='';
												}
											}
											if(!empty($listTransfer)){

												foreach ($listTransfer as $key1 => $cua) {
													# code...
													if($cua['Transfer']['idMachine']==$value['Machine']['id']){
														$soluong=$soluong+$cua['Transfer']['quantity'];
														$tongtien=$tongtien+$cua['Transfer']['moneyCalculate'];
														if(($cua['Transfer']['typedateEndPay']==1)||($cua['Transfer']['typedateEndPay']==3)){
															$tien=$tien+$cua['Transfer']['moneyCalculate'];
														}
														if(($cua['Transfer']['typedateEndPay']==2)||($cua['Transfer']['typedateEndPay']==4)){
															$the=$the+$cua['Transfer']['moneyCalculate'];
														}
													}
												}
											}

											?>
											<tr>
												<td class="text_table"><?php echo $i;?></td>
												<td><?php echo $value['Machine']['code'];?></td>
												<td><?php echo @$code;?></td>
												<td><?php echo @$name;?></td>
												<td><?php echo @$channel;?></td>
												<td style="text-align: right;" class="input_money"><?php echo $soluong;?></td>
												<td style="text-align: right;" class="input_money"><?php echo $tien;?></td>
												<td style="text-align: right;" class="input_money"><?php echo $the;?></td>
												<td style="text-align: right;" class="input_money"><?php echo $tongtien;?></td>
												<td><?php echo $value['Machine']['codeStaff'];?></td>
											</tr >
											<?php
										}
										echo'
										<tr>
										<td colspan="5" style="text-align: right;">Tổng cộng:</td>
										<td style="text-align: right;" class="input_money">'.$tongSL.'</td>
										<td style="text-align: right;" class="input_money">'.$tongTien.'</td>
										<td style="text-align: right;" class="input_money">'.$tongThe.'</td>
										<td style="text-align: right;" class="input_money">'.$All.'</td>
										<td></td>
										</tr>
										';
									}
									?>
								</tbody>

							</table>
						</div>
						<?php
						if (!empty($listData)) {
							?>
							<div class=" text-center p_navigation" style="<?php if(($totalPage==1)||empty($listData)) echo'display: none;';?>">
								<nav aria-label="Page navigation">
									<ul class="pagination">
										<?php
										if ($page > 5) {
											$startPage = $page - 5;
										} else {
											$startPage = 1;
										}

										if ($totalPage > $page + 5) {
											$endPage = $page + 5;
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
							<?php
								# code...
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
