<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Báo cáo bán hàng theo chi nhánh(BC06)</li>
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
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['name']);?>" name="name" id="" placeholder="Chi nhánh" class=" form-control">
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayTo']);?>" name="dayTo" id="" placeholder="Từ ngày" class="datetimepicker form-control">
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayForm']);?>" name="dayForm" id="" placeholder="Đến ngày" class="datetimepicker form-control">
										</td>
										<td>
											<select name="idPlace" class="form-control" placeholder="Trạng thái thanh toán">
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
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Chinh nhánh</th>
										<th class="text_table">Sản lượng bán(lẻ)</th>
										<th class="text_table">Tỷ trọng SL(%)</th>
										<th class="text_table">Doanh thu</th>
										<th class="text_table">Tỷ trọng doanh thu(%)</th>
										<th class="text_table">Hành động</th>
									</tr>
								</thead>

								<tbody>
									<?php
									if(!empty($listData)){
										$modelStaff = new Staff();
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
											$tien=0;
											$sl=0;
											$tytrong=0;
											$tytrongsl=0;
											# code...
											if(!empty($listTransfer)){
												foreach ($listTransfer as $key1 => $cua) {
													# code... trường hợp có idStaff trong bảng
													if(!empty($cua['Transfer']['idStaff'])){
														$staff=$modelStaff->getStaff($cua['Transfer']['idStaff'],$fields=array('idBranch'));
														if((!empty($staff['Staff']['idBranch']))&&$staff['Staff']['idBranch']== $value['Branch']['id']){
															$tien= $tien+$cua['Transfer']['moneyCalculate'];
															$sl= $sl+$cua['Transfer']['quantity'];
														}
													}
												}
											}
											if($tongTien!=0){
												$tytrong=($tien/$tongTien)*100;
											}
											if($tongSL!=0){
												$tytrongsl=($sl/$tongSL)*100;
											}
											?>
											<tr>
												<td class="text_table"><?php echo $i;?></td>
												<td><?php echo $value['Branch']['name'];?></td>
												<td style="text-align: right;" class="input_money"><?php echo $sl;?></td>
												<td style="text-align: right;"><?php echo round($tytrongsl,2, PHP_ROUND_HALF_UP);?></td>
												<td style="text-align: right;" class="input_money"><?php echo $tien;?></td>
												<td style="text-align: right;"><?php echo round($tytrong,2, PHP_ROUND_HALF_UP);?></td>
												<td>
													<ul class="list-inline list_i" style="">
														<li><a href="/listRevenueByBranchOrderSupplier/<?php echo $value['Branch']['id'];?>" title="Xem doanh thu chi tiết theo nhà cung cấp"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
													</ul>
												</td>
											</tr >
											<?php
										}
										echo'
										<tr >
										<td colspan="2" style="text-align: right;">Tổng cộng:</td>
										<td style="text-align: right;" class="input_money">'.$tongSL.'</td>
										<td></td>
										<td style="text-align: right;" class="input_money">'.$tongTien.'</td>
										<td></td>
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
