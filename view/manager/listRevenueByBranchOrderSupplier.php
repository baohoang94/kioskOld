<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">

	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now"><a href="/listRevenueByBranch">(BC06 con)Báo cáo bán hàng chi tiết chi nhánh:</a> <?php echo @$branch['Branch']['name'];?> theo nhà cung cấp</li>
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
											<input type="text" name="name" class="form-control" value="<?php echo @arrayMap($_GET['name']);?>" placeholder="Nhà cung cấp">
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayTo']);?>" name="dayTo" id="" placeholder="Từ ngày" class="datetimepicker form-control">
										</td>
										<td>
											<input type="text" maxlength="50" value="<?php echo @arrayMap($_GET['dayForm']);?>" name="dayForm" id="" placeholder="Đến ngày" class="datetimepicker form-control">
										</td>
										<td rowspan="">
											<button class="add_p1" type="submit">Tìm kiếm</button>
										</td>
									</form>
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
										<th class="text_table">Nhà cung cấp</th>
										<th class="text_table">Sản lượng bán(lẻ)</th>
										<th class="text_table">Tỷ trọng SL bán(%)</th>
										<th class="text_table">Doanh thu</th>
										<th class="text_table">Tỷ trọng doanh thu(%)</th>
									</tr>
								</thead>

								<tbody>
									<?php
									if(!empty($listData)){
										$modelProduct= new Product();
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
											$sotien=0;
											$ttsl=0;
											$ttt=0;
												# code...
											if(!empty($allTransfer)){
												foreach ($allTransfer as $key1 => $cua) {
													# code...
													$product=$modelProduct->getProduct($cua['Transfer']['idProduct'],$fields=array('idSupplier') );
													if($product['Product']['idSupplier']==$value['Supplier']['id']){
														$soluong=$soluong+$cua['Transfer']['quantity'];
														$sotien=$sotien+($cua['Transfer']['quantity']*$cua['Transfer']['moneyCalculate']);
													}
												}
											}
											if($tongSL!=0){
												$ttsl=($soluong/$tongSL)*100;
											}
											if($tongTien!=0){
												$ttt=($sotien/$tongTien)*100;
											}
											?>
											<tr>
												<td class="text_table"><?php echo $i;?></td>
												<td ><?php echo $value['Supplier']['name'];?></td>
												<td style="text-align: right;" class="input_money" ><?php echo $soluong;?></td>
												<td style="text-align: right;"><?php echo round($ttsl,2, PHP_ROUND_HALF_UP) ;?></td>
												<td style="text-align: right;" class="input_money"><?php echo $sotien;?></td>
												<td style="text-align: right;"><?php echo round($ttt,2, PHP_ROUND_HALF_UP);?></td>
											</tr >
											<?php
										}
										echo'
										<tr >
										<td colspan="2" style="text-align: right;"><b>Tổng cộng:</b></td>
										<td style="text-align: right;" class="input_money">'.$tongSL.'</td>
										<td></td>
										<td style="text-align: right;" class="input_money">'.$tongTien.'</td>
										<td></td>
										</tr>
										';
									}
									?>
								</tbody>
							</table>
						</div>
						<?php
						if(!empty($listData)){
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



	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
