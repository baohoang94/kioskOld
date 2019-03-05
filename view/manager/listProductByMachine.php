<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<?php
	$countpage = ceil(count($listResult)/10);
?>

<style type="text/css">
	.het-hang{
		background: #e74c3c;
	}
	.het-mot-nua{
		background: orange;
	}
</style>

<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default listDevice1">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Tra cứu sản phẩm</li>
				</ul>
			</div>
			<div class="col-sm-12">
						<div class="table-responsive table1">
							<form>
								<table class="table table-bordered">
									<tr>						
										<td>
											<table class="table table-bordered">
												<tr>
													<td>
														<select class="form-control" name="idCity" onchange="getDistrict(this.value, 0)"> 
															<option value="">Chọn tỉnh</option>
															<?php
																foreach ($listCity as $city) {
																	# code...
																	echo "<option value='".@$city['id']."'";
																	if(!empty($_GET['idCity']) && $_GET['idCity']==@$city['id'])
																		echo " selected";
																	echo ">".@$city['name']."</option>";
																}
															?>
														</select>
													</td>
													<td>
														<select class="form-control" name="idDistrict"  id="listDistrict" onchange="getWards(idCity.value,this.value, 0)">
															<option value="">Chọn Quận/Huyện</option>
														</select>
													</td>
													<td>		
														<input type="text" value="<?php echo @arrayMap($_GET['ncc_name']);?>" class="form-control" name="ncc_name" placeholder="NCC điểm dặt">		
													</td>
													<td>		
														<input type="text" value="<?php echo @arrayMap($_GET['ncc_code']);?>" class="form-control" name="ncc_code" placeholder="Mã NCC">		
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['place_name']);?>"  class="form-control" name="place_name" placeholder="Điểm đặt">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['place_code']);?>"  class="form-control" name="place_code" placeholder="Mã điểm đặt">
													</td>
												</tr>
												<tr>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['machine_name']);?>"  class="form-control" name="machine_name" placeholder="Tên máy">
													</td>
													<td> 
														<input type="text" value="<?php echo @arrayMap($_GET['machine_code']);?>"  class="form-control" name="machine_code" placeholder="Mã máy">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['cung']);?>"  class="form-control" name="cung" placeholder="Cung">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['code_staff']);?>"  class="form-control" name="staff" placeholder="Mã nhân viên kinh doanh">
													</td>
												</tr>
											</table>
										</td>
										<td>
											<button class="add_p1">Tra cứu</button>
											<br>
											<input name="page" value="1" hidden>
											</form>
											<br/><br>
											<form method="post">
												<input type="submit" name="export" class="add_p1" value="Export Excel"/>
											</form>
										</td>
									</tr>
								</table>					
						</div>
					</div>
			<div class="main_list_p ">
				<?php
					if(isset($_GET['machine_name'])){
						date_default_timezone_set("Asia/Ho_Chi_Minh");
						echo "Thời điểm tra cứu: ".date("Y/m/d")." - " . date("h:i:sa");
					}
				?>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1" >
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Tên máy</th>
										<th class="text_table">Mã máy</th>
										<th class="text_table">Tên điểm</th>
										<th class="text_table">Mã điểm</th>
										<th class="text_table">Tên Sản phẩm</th>
										<th class="text_table">Mã Sản phẩm</th>
										<th class="text_table">Tên NCC</th>
										<th class="text_table">Ma NCC</th>
										<th class="text_table">Số hàng tối đa</th>
										<th class="text_table">Số hàng còn</th>
										<th class="text_table">Số hàng cần load</th>								
										
									</tr>
								</thead>
								<tbody id="listData">
									<?php
										$i=0;
										foreach ($listResult as $list) {
											# code...
											$i++;
											echo "
												<tr";
												if($list['product_number'] < 1)
													echo " class='het-hang'"; 
												else
													if($list['product_number'] < $list['max_product_number']/2)
														echo " class='het-mot-nua'";
												
												echo ">
													<td>".$i."</td>
													<td><a href='".$urlHomes."structureMachine?id=".$list['machine_id']."'>".$list['machine_name']."</a></td>
													<td><a href='".$urlHomes."structureMachine?id=".$list['machine_id']."'>".$list['machine_code']."</a></td>
													<td>".$list['place_name']."</td>
													<td>".$list['place_code']."</td>
													<td>".$list['product_name']."</td>
													<td>".$list['product_code']."</td>
													<td>".$list['supplier_name']."</td>
													<td>".$list['supplier_code']."</td>
													<td>".$list['max_product_number']."</td>
													<td>".$list['product_number']."</td>
													<td>".$list['load_product_number']."</td>														
												</tr>
											";
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<?php
						if($countpage > 1){
							for($i=$countpage; $i>=1; $i--){
								echo "<button class='btn btl-default' onclick='display(".$i.")' style='float:right;margin-right: 10px'>".$i."</button>";
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function display(){
		var listDataDISPLAY = document.getElementById("listData");
	}	
	display();
</script>

<script type="text/javascript">
		var allCity = [];
		<?php
		if (!empty($listCity)) {
			foreach ($listCity as $key => $value) {
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
			if (!empty($listCity)) {
				foreach ($listCity as $key => $value) {
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