<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Báo cáo phân bổ máy theo tỉnh(BC04)</li>
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
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayTo']);?>" name="dayTo" id="" placeholder="Từ ngày" class="datetimepicker form-control" >
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayForm']);?>" name="dayForm" id="" placeholder="Đến ngày" class="datetimepicker form-control" >
										</td>
										<td>
											<select name="idCity" class="form-control">
												<option value="">Chọn Tỉnh/Thành phố</option>
												<?php
													if(!empty($cityKiosk)){
														foreach ($cityKiosk['Option']['value']['allData']as $key => $value){
															# code...
															?>
															<option value="<?php echo $value['id'];?>" <?php if(!empty($_GET['idCity'])&&$_GET['idCity']==$value['id']) echo'selected';?>><?php echo $value['name'];?></option>
															<?php
														}
													}
												?>
											</select>
										</td>
										<td rowspan="">
											<button class="add_p1" type="submit">Tìm kiếm</button>
										</td>
									</form>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<form action="" method="POST">
										<td colspan="6">
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
										<th class="text_table">Tỉnh/Thành phố</th>
										<th class="text_table">Số lượng máy</th>
										<th class="text_table">Tỷ trọng(%)</th>
									</tr>
								</thead>

								<tbody>
									<?php
									///pr($listMachine);
									if(!empty($listCity)){
										$modelPlace= new Place;
										$i=0;
										foreach ($listCity as $key => $value) {
											$i++;
											$soluong=0;
											$tytrong=0;
												# code...
											if(!empty($listMachine)){
												foreach ($listMachine as $key1 => $cua) {
														# code...
													if(!empty($cua['Machine']['idPlace'])){
														$place=$modelPlace->getPlace($cua['Machine']['idPlace'],$fields=array('idCity') );
														if(!empty($place)&&$place['Place']['idCity']==$value['id']){
															$soluong=$soluong+1;
														}
													}

												}
											}
											if($tongmay!=0){
												$tytrong=($soluong/$tongmay)*100;
											}
											?>
											<tr>
												<td class="text_table"><?php echo $i;?></td>
												<td><?php echo $value['name'];?></td>
												<td style="text-align: right;" class="input_money"><?php echo $soluong;?></td>
												<td style="text-align: right;"><?php echo round($tytrong,2, PHP_ROUND_HALF_UP)?></td>
											</tr >
											<?php
										}
										echo'
										<tr>
										<td style="text-align: right;" colspan="2">Tổng cộng:</td>
										<td style="text-align: right;" class="input_money">'.$tongmay.'</td>
										<td></td>
										</tr>
										';
									}
									?>
								</tbody>
							</table>
						</div>
						<!-- <div class=" text-center p_navigation">
							<nav aria-label="Page navigation">
								<ul class="pagination">
									<li class="disabled">
										<a href="#" aria-label="Previous">
											<span aria-hidden="true">«</span>
										</a>
									</li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#">5</a></li>
									<li>
										<a href="#" aria-label="Next">
											<span aria-hidden="true">»</span>
										</a>
									</li>
								</ul>
							</nav>
						</div> -->
					</div>
				</div>


			</div>


		</div>
	</div>



	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
