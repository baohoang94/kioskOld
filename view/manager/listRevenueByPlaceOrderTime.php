<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					
					<li class="page_now"><a href="/listReportTotalSalesByPlace">Báo cáo bán hàng chi tiết điểm đặt:</a> <?php echo @$place['Place']['name']?>   theo thời gian</li>
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
											<input type="text" name="codeMachine" class="form-control" value="<?php echo @arrayMap($_GET['codeMachine']);?>" placeholder="Mã máy">
										</td>
										<td>
											<input type="text" name="codeProduct" class="form-control" value="<?php echo @arrayMap($_GET['codeProduct']);?>" placeholder="Mã sản phẩm">
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
									</form>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
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
										<th class="text_table">Mã sản phẩm</th>
										<th class="text_table">Sản lượng bán(lẻ)</th>
										<th class="text_table">Tỷ trọng SL bán(%)</th>
										<th class="text_table">Doanh thu</th>
										<th class="text_table">Tỷ trọng doanh thu(%)</th>
									</tr>
								</thead>
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
											# code...
										$i++;
										$titrongsl=0;
										$titrongt=0;
										$tong=$value['Transfer']['moneyCalculate'];
										if($tongSL==0){
											$titrongsl=0;
										}else{
											$titrongsl=($value['Transfer']['quantity']/$tongSL)*100;
										}
										if($tongTien==0){
											$titrongt=0;
										}else{
											$titrongt=($tong/$tongTien)*100;
										}
										?>
										<tr>
											<td class="text_table"><?php echo $i;?></td>
											<td class="text_table"><?php echo date('d/m/Y H:i:s',$value['Transfer']['timeServer']);?></td>
											<td><?php echo $value['Transfer']['codeMachine'];?></td>
											<td><?php echo $value['Transfer']['codeProduct'];?></td>
											<td style="text-align: right;" class="input_money"><?php echo $value['Transfer']['quantity'];?></td>
											<td style="text-align: right;"><?php echo round($titrongsl,2, PHP_ROUND_HALF_UP);?></td>
											<td style="text-align: right;" class="input_money"><?php echo $tong;?></td>
											<td style="text-align: right;"><?php echo round($titrongt,2, PHP_ROUND_HALF_UP);?></td>

										</tr>
										<?php 

									}
									echo'
									<tr>
									<td colspan="4" style="text-align: right;"><b>Tổng cộng:</b></td>
									<td style="text-align: right;" class="input_money">'.$tongSL.'</td>
									<td></td>
									<td style="text-align: right;" class="input_money">'.$tongTien.'</td>
									<td></td>
									</tr>
									';
								}
								?>
								
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
										if ($page > 5) {
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



	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>