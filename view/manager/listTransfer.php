<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default listDevice1">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Lịch sử giao dịch mua hàng</li>

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
											<input type="text" maxlength="50" class="form-control" placeholder="Mã máy" name="codeMachine" value="<?php echo @arrayMap($_GET['codeMachine']);?>">
										</td>
										<td>
											<input type="text" maxlength="50" class="form-control" placeholder="Mã sản phẩm" name="codeProduct" value="<?php echo @arrayMap($_GET['codeProduct']);?>">
										</td>
										<td>
											<input type="text" maxlength="50" class="form-control" placeholder="Mã giao dịch" name="transactionId" value="<?php echo @arrayMap($_GET['transactionId']);?>">
										</td>
										<td>
											<input type="text" value="<?php echo @$_GET['dateStart'];?>" name="dateStart" id="" placeholder="Từ ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control">
										</td>
										<td>
											<input type="text" value="<?php echo @$_GET['dateEnd'];?>" name="dateEnd" id="" placeholder="Đến ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control">
										</td>
										<td rowspan="3">
											<button class="add_p1">Tìm kiếm</button>
										</td>

									</tr>
									<tr>
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
											<input type="text"  maxlength="50"   name="money" id="" placeholder=" Doanh thu bán hàng(vnđ)" class="input_money form-control" value="<?php echo @arrayMap($_GET['money']);?>">
										</td>
										<td>
											<input type="text"  maxlength="50"   name="moneyInput" id="" placeholder="Số tiền khách nạp(vnđ)" class="input_money form-control" value="<?php echo @arrayMap($_GET['moneyInput']);?>">
										</td>
										<td>
											<input type="text"  maxlength="50" name="quantity" id="" placeholder="Số lượng sản phẩm" class="input_money form-control" value="<?php echo @arrayMap($_GET['quantity']);?>">
										</td>
										<td>
											<select name="typedateEndPay" class="form-control" placeholder="Xã">
												<option value="">Hình thức thanh toán</option>
												<?php
												global $listTypePay;
												if(!empty($listTypePay)){
													foreach ($listTypePay as $key => $value) {
															# code...
														?>
														<option value="<?php echo $value['id']?>" <?php if(!empty($_GET['typedateEndPay'])&&$_GET['typedateEndPay']==$value['id']) echo'selected';?>><?php echo $value['name']?></option>
														<?php
													}
												}
												?>
											</select>
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
										<td>
											<input type="text" title="" maxlength="200" id="" placeholder="Số nhà, đường" class="form-control" name="numberHouse" value="<?php echo @arrayMap($_GET['numberHouse']);?>" >
										</td>

									</tr>
									<tr>
										<td>
											<select name="status" class="form-control" placeholder="Trạng thái thanh toán">
												<option value="">Trạng thái thanh toán</option>
												<?php
												global $listStatusPay;
												if(!empty($listStatusPay)){
													foreach ($listStatusPay as $key => $value) {
															# code...
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
										<td>
											<input type="text" name="slotId" placeholder="Slot ID" value="<?php echo @arrayMap($_GET['slotId']);?>" class="form-control">
										</td>
										<td>
											<input type="text"  maxlength="50"   name="moneyAvailable" id="" placeholder="Số dư tài khoản khách" class="input_money form-control" value="<?php echo @arrayMap($_GET['moneyAvailable']);?>">
										</td>
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
						</div>
					</div>


					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Thời gian</th>
										<th class="text_table">Mã máy</th>
										<th class="text_table">Slot ID </th>
										<th class="text_table">Mã sản phẩm</th>
										<th class="text_table">Mã giao dịch</th>
										<th class="text_table">Số lượng</th>
										<th class="text_table">Doanh thu bán hàng(vnđ)</th>
										<th class="text_table">Số tiền khách nạp(vnđ)</th>
										<th class="text_table">Số dư tài khoản khách(vnđ)</th>
										<th class="text_table">Hình thức thanh toán</th>
										<th class="text_table">Trạng thái</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$modelProduct = new Product;
									global $listTypePay;
									global $listStatusPay;

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
										foreach($listData as $data){
											$i++;
											echo '<tr>
											<td class="text_table" title="'.$data['Transfer']['id'].'">'.$i.'</td>
											<td class="text_table" title="Tại máy: '.date('d/m/Y H:i:s',$data['Transfer']['timeClient']).'">'.date('d/m/Y H:i:s',$data['Transfer']['timeServer']).'</td>
											<td class="text_table_right"><a href="infoMachine?id='.$data['Transfer']['idMachine'].'">'.$data['Transfer']['codeMachine'].'</a></td>
											<td style="text-align: right;">'.@$data['Transfer']['slotId'].'</td>
											<td class="text_table_right"><a href="infoProduct?id='.$data['Transfer']['idProduct'].'">'.@$data['Transfer']['codeProduct'].'</a></td>
											<td class="text_table_right" title="Số GD trên máy: '.@$data['Transfer']['transactionId'].'"><a href="/viewTransfer/'.$data['Transfer']['id'].'">'.@$data['Transfer']['orderId'].'</a></td>
											<td class="text_table_right">'. @number_format($data['Transfer']['quantity'], 0, ',', '.').'</td>
											<td class="text_table_right">'. number_format($data['Transfer']['moneyCalculate'], 0, ',', '.').'</td>
											<td class="text_table_right">'. number_format($data['Transfer']['moneyInput'], 0, ',', '.').'</td>
											<td class="text_table_right">'. @number_format($data['Transfer']['moneyAvailable'], 0, ',', '.').'</td>
											<td>'.@$listTypePay[$data['Transfer']['typedateEndPay']]['name'].'</td>
											<td>'.@$listStatusPay[$data['Transfer']['status']]['name'].'</td>
											</tr>';
										}
									}else{
										echo '<tr><td align="center" colspan="12">Chưa có dữ liệu</td></tr>';
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
