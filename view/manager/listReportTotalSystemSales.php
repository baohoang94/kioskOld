<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Báo cáo doanh thu toàn hệ thống </li>
				</ul>

			</div>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<tr>
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
										<th class="text_table">Loại sản phẩm</th>
										<th class="text_table">Nhà cung cấp</th>
										<th class="text_table">Tổng số lượng bán</th>
										<th class="text_table">Tổng tiền tính toán</th>
										<th class="text_table" >Tổng tiền thực tế</th>
									</tr>
								</thead>
								
								<tbody>
									<?php
									if(!empty($listCategoryProduct)){
										$modelProduct= new Product();
										$modelSupplier= new Supplier;
										$i=0;
										$totalSales=0;// tổng số lượng bán
										$totalMoneyCalculation=0;// tổng tiền tính toán
										$totalMoneyCollected=0;// tổng tiền thực thu
										foreach ($listCategoryProduct['Option']['value']['allData'] as $key => $value) {
											$soluong=0;
											$tong=0;
											$tong1=0;
											$i++;
												//pr($value);
											?>
											<tr>
												<td class="text_table"><?php echo $i;?></td>
												<td><?php echo $value['name'];?></td>
												<?php 
												if(!empty($listTransfer)){
													foreach ($listTransfer as $key => $cua) {
														$product=$modelProduct->getProduct($cua['Transfer']['idProduct'],array('idCategory','idSupplier'));
														if(!empty($product)&&$product['Product']['idCategory']==$value['id']){
															$supplier=$modelSupplier->getSupplier($product['Product']['idSupplier'],array('name'));
															$soluong=$soluong+$cua['Transfer']['quantity'];
															$tong=$tong+$cua['Transfer']['moneyCalculate'];
															$tong1=$tong1+$cua['Transfer']['moneyInput'];
															
														}	# code...
													}
													echo'
													<td >'.$supplier['Supplier']['name'].'</td>
													<td style="text-align: right;">'.number_format($soluong, 0, ',', '.').'</td>
													<td style="text-align: right;">'.number_format($tong, 0, ',', '.').'</td>
													<td style="text-align: right;">'.number_format($tong1, 0, ',', '.').'</td>
													';
													$totalSales=$totalSales+$soluong;
													$totalMoneyCalculation=$totalMoneyCalculation+$tong;
													$totalMoneyCollected=$totalMoneyCollected+$tong1;
												}
												?>
											</tr>
											<?php 
										}
										echo'
											<tr>
												<td colspan="3" style="text-align: right;">Tổng cộng:</td>
												<td style="text-align: right;">'.number_format($totalSales, 0, ',', '.').'</td>
												<td style="text-align: right;">'.number_format($totalMoneyCalculation, 0, ',', '.').'</td>
												<td style="text-align: right;">'.number_format($totalMoneyCollected, 0, ',', '.').'</td>
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