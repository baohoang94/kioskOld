<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default listDevice1">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Danh sách máy</li>
					<li class="text-right list_map">
						<form class="" action="/mapDevice" method="">
							<select class="form-control"  onchange='this.form.submit()'>
								<option class="hidden">Danh sách</option>
								<option>Bản đồ</option>
							</select>
						</form>
					</li>
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
											<a href="/addMachine">Thêm máy mới</a>
										</div>
										<div class="add_p m_top">
											<!--<a href="changeProductInDeviceGroup.php">Phân máy theo nhóm</a>-->
										</div>
									</td>
									<td>
										<form action="" method="GET">
											<table class="table table-bordered">
												<tr>
													<td>
														<input type="text" id="" maxlength="50"  class="form-control" value="<?php echo @arrayMap($_GET['name']);?>" placeholder="Tên máy" name="name">
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" value="<?php echo @arrayMap($_GET['code']);?>" placeholder="Mã máy" name="code">
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" value="<?php echo @arrayMap($_GET['codeasset']);?>" placeholder="Mã tài sản" name="codeasset">
													</td>
													<td>
														<input type="text" maxlength="50" class="input_money form-control" value="<?php echo @arrayMap($_GET['priceMachine']);?>" placeholder="Giá máy (vnđ)" name="priceMachine">
													</td>
													
													<td rowspan="4">
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
												<tr>
													<td>
														<select class="form-control" name="namePlace">
															<option value="">Chọn điểm đặt</option>
															<?php 
															if(!empty($listPlace)){
																foreach ($listPlace as $key => $value) {
																	# code...
																	?>
																	<option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($_GET['namePlace'])&&$_GET['namePlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
																	<?php 
																}
															}
														?>
														</select>
													</td>
													<td>
														<input type="text" value="<?php echo @$_GET['dateStorage'];?>" name="dateStorage" id="" placeholder="Ngày nhập kho" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" maxlength="50" class="input_date form-control">
													</td>
													<td>
														<input type="text"  class="form-control" maxlength="50" placeholder="Nhà sản xuất" name="manufacturer" value="<?php echo @arrayMap($_GET['manufacturer']);?>">
													</td>
													<td>
														<input type="text" maxlength="50" value="<?php echo @$_GET['dateInstallation'];?>" name="dateInstallation" id="" placeholder="Ngày nhập lắp đặt máy tại điểm" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" data-inputmask="'alias': 'date'" class="input_date form-control">
													</td>
													
												</tr>
												<tr>
													<td>
														<select class="form-control" name="status">
															<option value="">Trạng thái</option>
															<?php
															foreach($listStatusMachine as $status){
																if(empty($_GET['status']) || $_GET['status']!=$status['id']){
																	echo '<option value="'.$status['id'].'">'.$status['name'].'</option>';
																}else{
																	echo '<option selected value="'.$status['id'].'">'.$status['name'].'</option>';
																}
															}
															?>
														</select>
													</td>
													<td>
														<input type="text"  placeholder="Kỹ thuật lắp đặt" maxlength="50" name="nameInstallation" id="" value="<?php echo @arrayMap($_GET['nameInstallation']);?>" class="form-control">
													</td>
													<td>
														<input type="text" value="<?php echo @$_GET['dateStartRun'];?>" name="dateStartRun" maxlength="100" id="" placeholder="Ngày đưa vào sử dụng" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" data-inputmask="'alias': 'date'" class="input_date form-control">
													</td>
													<td>
														<input type="text"  class="form-control" maxlength="50" placeholder="Hạn bảo hành định kì" name="warrantyCycle" value="<?php echo @arrayMap($_GET['warrantyCycle']);?>">
													</td>
													
												</tr>
												<tr>
													<td>
														<input type="text"  class="form-control" maxlength="50" placeholder="Hạn bảo hành NSX" name="warrantyManufacturer" value="<?php echo @arrayMap($_GET['warrantyManufacturer']);?>">
													</td>
													<td>
														<input type="text" maxlength="50" value="<?php echo @$_GET['dateManufacture'];?>" name="dateManufacture" id="" placeholder="Ngày sản xuất" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control">
													</td>
													<td>
														<input type="text"  class="form-control" maxlength="50" placeholder="Loại máy" name="typeMachine" value="<?php echo @arrayMap($_GET['typeMachine']);?>">
													</td>

													<td>
														<input type="text" class="form-control" maxlength="50" placeholder="Tọa độ GPS" name="gps" value="<?php echo @arrayMap($_GET['gps'])?>">
													</td>
													
												</tr>
												<tr>
													<td>
														<input type="text" class="form-control" maxlength="50" placeholder="Mã nhân viên phụ trách" name="codeStaff" value="<?php echo @arrayMap($_GET['codeStaff'])?>">
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
						<div class="table-responsive table1" >
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Tên máy</th>
										<th class="text_table">Mã máy</th>
										<th class="text_table">Mã tài sản</th>
										<th class="text_table">Số imei</th>
										<th class="text_table">Điểm đặt</th>
										<th class="text_table">Trạng thái</th>
										<th class="text_table">Thông số</th>
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
										$modelPlace= new Place();
										foreach($listData as $key=> $data){
											$i++;
											$codeasset=isset($data['Machine']['codeasset'])?$data['Machine']['codeasset']:"";
											if(!empty($data['Machine']['idPlace'])){
												$place[$key]=$modelPlace->getPlace($data['Machine']['idPlace'],array('name'));
											}
											if(!empty($data['Machine']['parameter']['door'])){
												$door= 'mở';
											}else{
												$door= 'đóng';
											}

											echo '<tr>
											<td class="text_table">'.$i.'</td>
											<td><a href="structureMachine?id='.$data['Machine']['id'].'">'.$data['Machine']['name'].'</a></td>
											<td><a href="structureMachine?id='.$data['Machine']['id'].'">'.$data['Machine']['code'].'</a></td>
											<td>'.$codeasset.'</td>
											<td>'.$data['Machine']['imei'].'</td>
											<td><a href="/infoPlace?id='.@$place[$key]['Place']['id'].'">'.@$place[$key]['Place']['name'].'</a></td>
											<td>'.$listStatusMachine[$data['Machine']['status']]['name'].'</td>
											<td>
												<p>Cửa: '.$door.'</p>
												<p>Nhiệt độ: '.@$data['Machine']['parameter']['temp'].'</p>
												<p>Độ rung: '.@$data['Machine']['parameter']['vibra'].'</p>
											</td>
											<td>
											<ul class="list-inline list_i" style="">
											<li><a href="/addMachine?id='.$data['Machine']['id'].'" title="Sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
											<li><a href="/infoMachine?id='.$data['Machine']['id'].'" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
											<li><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" href="/deleteMachine?id='.$data['Machine']['id'].'" title="Xóa" class="bg_red"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
											<li><a href="/structureMachine?id='.$data['Machine']['id'].'" title="Sơ đồ cấu trúc máy" class="bg_green"><i class="fa fa-cog" aria-hidden="true"></i></a></li>
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



	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>