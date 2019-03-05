<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Báo cáo phân bổ máy theo điểm đặt(BC05)</li>
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
											<input type="text" name="name" value="<?php echo @arrayMap($_GET['name']);?>" class="form-control" placeholder="Tên điểm đặt">
										</td>
										<td>
											<input type="text" name="code" value="<?php echo @arrayMap($_GET['code']);?>" class="form-control" placeholder="Mã điểm đặt">
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayTo']);?>" name="dayTo" id="" placeholder="Từ ngày" class="datetimepicker form-control">
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayForm']);?>" name="dayForm" id="" placeholder="Đến ngày" class="datetimepicker form-control">
										</td>
										<td>
											<select class="form-control" name="idChannel">
												<option value="">Kênh bán hàng</option>
												<?php
													if(!empty($listChannelProduct)){
														foreach ($listChannelProduct['Option']['value']['allData'] as $key => $value) {
															# code...
															?>
															<option value="<?php echo $value['id'];?>" <?php if(!empty($_GET['idChannel'])&&$_GET['idChannel']==$value['id']) echo'selected';?>><?php echo $value['name'];?></option>
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
										<th class="text_table">Mã điểm đặt</th>
										<th class="text_table">Tên điểm đặt</th>
										<th class="text_table">Kênh bán hàng</th>
										<th class="text_table">Số lượng máy</th>
										<th class="text_table">Tỷ trọng(%)</th>
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
											$somay=0;
											if($listMachine){
												foreach ($listMachine as $key1 => $cua) {
													if($cua['Machine']['idPlace']==$value['Place']['id']){
														$somay=$somay+1;
													}
												}
											}
											if($tongmay==0){
												$titrong=0;
											}else{
												$titrong=($somay/$tongmay)*100;
											}

											?>
											<tr>
												<td class="text_table"><?php echo $i;?></td>
												<td><?php echo $value['Place']['code'];?></td>
												<td><?php echo $value['Place']['name'];?></td>
												<td><?php echo @$listChannelProduct['Option']['value']['allData'][$value['Place']['idChannel']]['name'];?></td>
												<td style="text-align: right;" class="input_money"><?php echo $somay;?></td>
												<td style="text-align: right;"><?php echo round($titrong,2, PHP_ROUND_HALF_UP)?></td>
											</tr>
											<?php
										}
										echo'
										<tr>
										<td colspan="4" style="text-align: right;"><b>Tổng cộng:</b></td>
										<td style="text-align: right;" class="input_money">'.$tongmay.'</td>
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
								# code...
						}
						?>

					</div>
				</div>


			</div>


		</div>
	</div>



	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
