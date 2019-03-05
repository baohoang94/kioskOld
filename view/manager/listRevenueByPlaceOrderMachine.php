<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now"><a href="/listReportTotalSalesByPlace">Báo cáo bán hàng chi tiết điểm đặt:</a> <?php echo @$place['Place']['name'];?> theo máy</li>
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
											<input type="text" name="name" placeholder="Tên máy" value="<?php echo @arrayMap($_GET['name']);?>" class=form-control>
										</td>
										<td>
											<input type="text" name="code" placeholder="Mã máy" value="<?php echo @arrayMap($_GET['code']);?>" class="form-control">
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
											<select name="idProduct" class="form-control">
												<option value="">Chọn sản phẩm</option>
												<?php 
												if(!empty($listProduct)){
													foreach ($listProduct as $key => $value) {
												 		# code...
														?>
														<option value="<?php echo $value['Product']['id'];?>" <?php if(!empty($_GET['idProduct'])&&$_GET['idProduct']==$value['Product']['id']) echo'selected';?>><?php echo @$value['Product']['name'];?></option>
														<?php 
													}
												}
												?>
											</select>
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
										<th class="text_table">Sản lượng bán(lẻ)</th>
										<th class="text_table">Tỷ trọng SL bán(%)</th>
										<th class="text_table">Doanh thu</th>
										<th class="text_table">Tỷ trọng doanh thu(%)</th>						
										<th class="text_table">Hành động</th>										
									</tr>
								</thead>
								<?php 
								if(!empty($listData)){
									if (!isset($_GET['page'])) {
										$i=0;
									}
									if(!empty($_GET['page'])) {
										$i=$_GET['page']*15-15;
									}
									// elseif (isset($_GET['page'])>=2)
									// {
									// 	$i=$_GET['page']*15-15;
									// } 
									$totalSales=0;
									$totalMoneyCalculation=0;
									foreach ($listData as $key => $value) {
										$i++;
										$soluong=0;
										$tong=0;
										$titrongsl=0;
										$titrongt=0;
										if($listTransfer){
											foreach ($listTransfer as $key1 => $cua) {
												# code...
												if($cua['Transfer']['idMachine']==$value['Machine']['id']){
													$soluong=$soluong+$cua['Transfer']['quantity'];
													$tong=$tong+$cua['Transfer']['moneyCalculate'];
												}
											}
											if($tongSL==0){
												$titrongsl=0;
											}else{
												$titrongsl=($soluong/$tongSL)*100;
											}
											if($tongTien==0){
												$titrongt=0;
											}else{
												$titrongt=($tong/$tongTien)*100;
											}
											$totalSales=$totalSales+$soluong;
											$totalMoneyCalculation=$totalMoneyCalculation+$tong;
										}

												# code...
										?>
										<tr>
											<td class="text_table"><?php echo $i?></td>
											<td  class=""><?php echo $value['Machine']['code'];?></td>
											<td  class=""><?php echo $value['Machine']['name'];?></td>
											<td style="text-align: right;" class="input_money"><?php echo $soluong;?></td>
											<td style="text-align: right;" ><?php echo round($titrongsl,2, PHP_ROUND_HALF_UP);?></td>
											<td style="text-align: right;" class="input_money" ><?php echo $tong;?></td>
											<td style="text-align: right;"><?php echo round($titrongt,2, PHP_ROUND_HALF_UP);?></td>
											<td>
												<ul class="list-inline list_i" style="">
													<li><a href="/viewDetailHistoryMachineRevenue/<?php echo $value['Machine']['id'];?>?idPlace=<?php echo $id ?>" title="Xem chi tiết lich sử doanh thu máy"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
												</ul>
											</td>
										</tr >
										<?php 
									}
									echo'
									<tr>
									<td colspan="3" style="text-align: right;"><b>Tổng cộng:</b></td>
									<td style="text-align: right;" class="input_money">'.$tongSL.'</td>
									<td></td>
									<td style="text-align: right;" class="input_money">'.$tongTien.'</td>
									<td></td>
									<td></td>
									</tr>
									';
								}
								?>
								<tbody>
									

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