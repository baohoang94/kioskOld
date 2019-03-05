<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Quản lý sản phẩm</li>
				</ul>

			</div>

			<div class="main_list_p css_img">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<tr>
									<td>
										<div class="add_p">
											<a href="/addProduct">Thêm sản phẩm mới</a>
										</div>
									</td>
									<td>
										<form action="" method="GET">
											<table class="table table-bordered">
												<tr>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['name']);?>" class="form-control" placeholder="Tên sản phẩm" name="name">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['code']);?>" class="form-control " placeholder="Mã sản phẩm" name="code">
													</td>
													<td>
														<input type="text" title="" maxlength="50" id="" placeholder="Giá nhập" class="input_money form-control " name="priceInput" value="<?php echo @arrayMap($_GET['priceInput']);?>">

													</td>
													<td>
														<input type="text" title="" maxlength="50" id="" placeholder="Giá bán" class="input_money form-control " name="priceOutput" value="<?php echo @arrayMap($_GET['priceOutput']);?>">

													</td>
													<td rowspan="3">
														<button class="add_p1" type="submit">Tìm kiếm</button>
													</td>
												</tr>

												<tr>
													<td>
														<select name="idCategory" class="form-control">
															<option value="">Ngành hàng</option>
															<?php
															if(!empty($listCategoryProduct['Option']['value']['allData'])){
																foreach($listCategoryProduct['Option']['value']['allData'] as $components){
																	if(empty($_GET['idCategory']) || $_GET['idCategory']!=$components['id']){
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
														<select name="idSupplier" class="form-control">
															<option value="">Nhà cung cấp</option>
															<?php
															$listSupplierNew= array();
															if(!empty($listSupplier)){
																foreach($listSupplier as $supplier){
																	$listSupplierNew[$supplier['Supplier']['id']]= $supplier['Supplier']['name'];
																	if(empty($_GET['idSupplier']) || $_GET['idSupplier']!=$supplier['Supplier']['id']){
																		echo '<option value="'.$supplier['Supplier']['id'].'">'.$supplier['Supplier']['name'].'</option>';
																	}else{
																		echo '<option selected value="'.$supplier['Supplier']['id'].'">'.$supplier['Supplier']['name'].'</option>';
																	}
																}
															}
															?>
														</select>
													</td>
													<td>
														<input type="text" placeholder="Hạn sử dụng" name="exp" id="" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" value="<?php echo @$_GET['exp'];?>" >
													</td>
													<td>
														<input type="text" placeholder="Quy cách sản phẩm" name="specification" id="" class="form-control"  value="<?php echo @arrayMap($_GET['specification']);?>" >
													</td>
												</tr>
												<tr>
													<td>
														<input type="text" placeholder="Quy cách đóng thùng" name="packing" id="" class="form-control"  value="<?php echo @arrayMap($_GET['packing']);?>">
													</td>
													<td>
														<select name="loso" class="form-control">
															<option value="">Lò xo trưng bày</option>
															<option value="60" <?php if(!empty($_GET['loso'])&&$_GET['loso']==60) echo 'selected';?>>60 cm</option>
															<option value="80" <?php if(!empty($_GET['loso'])&&$_GET['loso']==80) echo 'selected';?>>80 cm</option>
														</select>
													</td>
													<td>
														<select name="idChannel" class="form-control">
															<option value="">Kênh bán hàng</option>
															<?php
															global $modelOption;
															$listChannelProduct= $modelOption->getOption('listChannelProduct');
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
													<td>
														<input type="text" title="" maxlength="50" id="" placeholder="Doanh thu cam kết" class="form-control " name="revenue" value="<?php echo @arrayMap($_GET['revenue']);?>">
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
					</div>
				<form method="post">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text_table">STT</th>
										<th class="text_table">Mã sản phẩm</th>
										<th class="text_table">Ngành hàng</th>
										<th class="text_table">Tên sản phẩm</th>
										<th class="text_table">Hình ảnh</th>
										<th class="text_table">Giá bán (vnđ)</th>
										<!-- <th class="text_table">Số lượng</th> -->
										<th class="text_table">Nhà cung cấp</th>
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
										foreach($listData as $data){
											$i++;
											if(!empty($data['Product']['image'])){
												$image= '<img src="'.$data['Product']['image'].'"  />';
											}else{
												$image= '';
											}

											echo '<tr>
											<td class="text_table" >'.$i.'</td>
											<td><a href="/infoProduct?id='.$data['Product']['id'].'">'.@$data['Product']['code'].'</a></td>
											<td>'.@$listCategoryProduct['Option']['value']['allData'][$data['Product']['idCategory']]['name'].'</td>
											<td><a href="/infoProduct?id='.$data['Product']['id'].'">'.@$data['Product']['name'].'</a></td>
											<td class="img_p">'.$image.'</td>
											<td class="text_table_right">'. number_format($data['Product']['priceOutput'], 0, ',', '.').'</td>
											<td>'.@$listSupplierNew[$data['Product']['idSupplier']].'</td>
											<td>
											<ul class="list-inline list_i" style="">
											<li><a href="/addProduct?id='.$data['Product']['id'].'" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
											<li><a href="infoProduct?id='.$data['Product']['id'].'" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
											<li><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" href="/deleteProduct?id='.$data['Product']['id'].'" title="Xóa" class="bg_red"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
											<li>
											<a href="priceProduct?id='.$data['Product']['id'].'" title="Cài đặt giá"><i class="fa fa-cog" aria-hidden="true"></i></a>
											</li>
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
				</form>
			</div>


			</div>
		</div>
	</div>

		<script type="text/javascript">
			function updateProduct(id,name)
			{
				var number= prompt('Nhập số lượng sản phẩm '+name+' bạn muốn thêm');
				if($.isNumeric(number)){
					$.ajax({
						method: "POST",
						url: "/updateProduct",
						data: { id: id, number: number }
					})
					.done(function( msg ) {
						location.reload();
					});
				}else{
					alert("Định dạng sai");
				}
				return false;
			}
			// send id product
			$(document).ready(function(){
				$(".set-price").click(function(){
					id=$(this).attr('data-product');
					$("#noidung").load("http://web2.com/priceProduct?id="+id);
				});
			});
		</script>
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Cài đặt giá sản phẩm</h4>
					</div>
					<div class="modal-body">
						<div id="noidung"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>
		<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
