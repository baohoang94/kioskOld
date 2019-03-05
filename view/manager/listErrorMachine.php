<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<!-- <div class="col-md-2 sidebar">
		<div class="row">
			<div class="absolute-wrapper"> </div>
			<?php include "sidebar.php";?>
		</div>  		
	</div> -->
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Danh sách lỗi</li>
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
											<a href="/addErrorMachine">Thêm lỗi mới</a>
										</div>
									</td>
									<td>
										<table class="table table-bordered">
											<form method="GET" action="">
												<tr>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Mã máy" name="code" value="<?php echo @arrayMap($_GET['code']);?>">
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Mã lỗi" name="codeError" value="<?php echo @arrayMap($_GET['codeError']);?>">
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="Tên lỗi" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
													</td>
													<td>
														<input type="text" name="dayTo" id="dateStartConfig" value="<?php echo @$_GET['dayTo'];?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" placeholder="Từ ngày" >
													</td>
													<td rowspan="2">
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
												<tr>
													<td>
														<input type="text" name="dayForm" id="dateStartConfig" value="<?php echo @$_GET['dayForm'];?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" placeholder="Đến ngày" >
													</td>
													<td>
														<input type="text" maxlength="50" class="form-control" placeholder="KTV sửa chữa" name="nameTechnicians" value="<?php echo @arrayMap($_GET['nameTechnicians']);?>">
													</td>
													<td>
														<select name="status" class="form-control" placeholder="Chọn Tỉnh/Thành phố">
															<option value="">Trạng thái</option>
															<?php 
															if(!empty($listStatusErrorMachine)){
																foreach ($listStatusErrorMachine as $key => $value) {
																	# code...
																	?>
																	<option value="<?php echo $value['id'];?>" <?php if(!empty($_GET['status'])&&$_GET['status']==$value['id']) echo'selected';?>><?php echo $value['name'];?></option>
																	<?php
																}
															}
															?>
														</select>
													</td>
													<td>
														<input type="text" name="dayReportError" id="dateStartConfig" value="<?php echo @$_GET['dayReportError'];?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" placeholder="Ngày báo hỏng" >
													</td>
												</tr>
												<tr>
													<td>
														<select name="idCity" class="form-control" placeholder="Chọn Tỉnh/Thành phố">
															<option value="">Chọn Tỉnh/Thành phố</option>
															<?php 
															if(!empty($listCityKiosk)){
																foreach ($listCityKiosk['Option']['value']['allData'] as $key => $value) {
																	# code...
																	?>
																	<option value="<?php echo $value['id'];?>" <?php if(!empty($_GET['idCity'])&&$_GET['idCity']==$value['id']) echo'selected';?>><?php echo $value['name'];?></option>
																	<?php 
																}
															}
															?>

														</select>
													</td>
													<td>
														
														<input type="text" name="dayStart" id="dateStartConfig" value="<?php echo @$_GET['dayStart'];?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" placeholder="Ngày bắt đầu khắc phục" >
													</td>
													<td>
														<input type="text" name="dayEnd" id="dateStartConfig" value="<?php echo @$_GET['dayEnd'];?>" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" placeholder="Ngày hoàn thành khắc phục" >
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
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="col-sm-12" >
						<div class="table-responsive table1">

							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Mã máy</th>
										<th class="text_table">Tên lỗi</th>
										<th class="text_table">Tỉnh/Thành phố</th>
										<th class="text_table">Ngày bắt đầu hỏng</th>
										<th class="text_table">Ngày báo hỏng</th>
										<th class="text_table">Ngày bắt đầu khắc phục</th>
										<th class="text_table">Thời gian hoàn thành khắc phục</th>
										<th class="text_table">KTV sửa chữa</th>
										<th class="text_table">Trạng thái</th>
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
										foreach ($listData as $key => $value) {
											$i++;
												# code...
											?>
											<tr>
												<td class="text_table"><?php echo $i;?></td>
												<td><a href="/infoMachine?id=<?php echo $value['Error']['idMachine'];?>" title="Xem"><?php echo  $value['Error']['codeMachine'];?></a></td>
												<td><?php echo  $value['Error']['name'];?></td>
												<td><?php echo  @$listCityKiosk['Option']['value']['allData'][$value['Error']['idCity']]['name'];?></td>
												<td style="text-align: center;"><?php echo  $value['Error']['dayError'];?></td>
												<td style="text-align: center;"><?php echo  $value['Error']['dayReportError'];?></td>
												<td style="text-align: center;"><?php echo  $value['Error']['dayStart'];?></td>
												<td style="text-align: center;"><?php echo  $value['Error']['dayEnd'];?></td>
												<td><?php echo  $value['Error']['nameTechnicians'];?></td>
												<td><?php echo  @$listStatusErrorMachine[$value['Error']['status']]['name'];?></td>
												
												<td>
													<ul class="list-inline list_i" style="">
														<li><a href="/addErrorMachine?id=<?php echo $value['Error']['id'];?>" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
														<li><a href="/infoErrorMachine?id=<?php echo $value['Error']['id'];?>" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
														<li><a onclick="return confirm('Bạn có chắc chắn muốn xóa không ?')" href="/deleteErrorMachine?idDelete=<?php echo $value['Error']['id'];?>" title="Xóa" class="bg_red"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
													</ul>
												</td>
											</tr>
											<?php 
										}
									}
									else
									{
										echo '<tr>
										<td colspan="11" rowspan="" headers="" align="center">Chưa có dữ liệu</td>
										</tr>';

									}
									?>
									
									

								</tbody>
							</table>
						</div>
						<div class=" text-center p_navigation" style="<?php if(($totalPage==1)||empty($listData)) echo'display: none;';?>">
							<nav aria-label="Page navigation">
								<ul class="pagination">
									<?php
									if ($page > 2) {
										$startPage = $page - 2;
									} else {
										$startPage = 1;
									}

									if ($totalPage > $page + 2) {
										$endPage = $page + 2;
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
						
					</div>
				</div>


			</div>


		</div>
	</div>



	<script type="text/javascript">
		jQuery(function ($) {
			$('.input-mask-date').mask('99/99/9999', {placeholder: "dd/mm/yyyy"});
		});
	</script>
	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>