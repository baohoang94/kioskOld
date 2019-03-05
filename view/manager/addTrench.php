<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<!-- <li class="back_page"><a href="/structureMachine?id=<?php echo $data['Machine']['id'];?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listMachine"> Quản lí máy</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/addMachine?id=<?php echo $data['Machine']['id'];?>"> <?php echo $data['Machine']['code'];?></a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/structureMachine?id=<?php echo $data['Machine']['id'];?>"> Sơ đồ máy</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Hàng <?php echo $_GET['idFloor'];?></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Thêm slot mới</li>
				</ul>

			</div>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<form class="table-responsive table1" action="" method="POST">
							<?php
								if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
							?>
							<div class="col-sm-6">
								<div class="form_add">
									<div class="form-group">
										<label>Số sản phẩm tối đa<span class="color_red">*</span>: </label>
										<input type="text" title=""  placeholder="Số sản phẩm tối đa" maxlength="19" id="" class="input_money form-control" value="" name="numberLoxo" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form_add">
									<div class="form-group">
										<label>Sản phẩm<span class="color_red">*</span>: </label>
										<select name="idProduct" id="idProduct" class="form-control" required onchange="checkPrice(this)">
											<option value="">Chọn sản phẩm</option>
											<?php
												if(!empty($listProduct)){
													foreach($listProduct as $components){
														echo '<option price="'.$components['Product']['priceOutput'].'" value="'.$components['Product']['id'].'">'.$components['Product']['name'].'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form_add">
									<div class="form-group">
										<label>Số sản phẩm còn lại<span class="color_red">*</span>: </label>
										<input type="text" title="" maxlength="19" id="" placeholder="Số sản phẩm còn lại"  class="input_money form-control" value="" name="numberProduct" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form_add">
									<div class="form-group">
										<label>Giá bán sản phẩm<span class="color_red">*</span>: </label>
										<input type="text" maxlength="19" name="priceProduct" placeholder="Giá bán sản phẩm"  id="priceProduct" value="" class="input_money form-control" >
									</div>
								</div>
							</div>


							<div class="col-sm-12">
								<div class="form-group">
									<button class="btn_ad" style="display: inline-block !important;">Lưu</button>
									<span class="btn_ad_back"><a href="/structureMachine?id=<?php echo $data['Machine']['id'];?>">Quay lại</a></span>
								</div>
							</div>

						</form>
					</div>
					
				</div>
			</div>
		</div>

		<script type="text/javascript">
			function checkPrice(product)
			{
				$('#priceProduct').val($('option:selected', product).attr('price'));
			}
		</script>
		
		<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>