<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li><a href="/listTransfer">Lịch sử giao dịch mua hàng</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Chi tiết lịch sử giao dịch mua hàng</li>
				</ul>
			</div>
			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<form class="table-responsive table1" action="" method="POST">
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Thời gian bán hàng: </label>
										<input type="text" disabled="disabled" pattern="([a-zA-Z0-9-]+)"  maxlength="50" id="" class="form-control" value="<?php echo date('d/m/Y H:i:s',$data['Transfer']['timeServer']);?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Thời gian hạch toán: </label>
										<input type="text" disabled="disabled" pattern="([a-zA-Z0-9-]+)"  maxlength="50" id="" class="form-control" value="<?php echo date('d/m/Y H:i:s',$data['Transfer']['timeClient']);?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Slot ID: </label>
										<input type="text" disabled="disabled" pattern="([a-zA-Z0-9-]+)"  maxlength="50" id="" class="form-control" value="<?php echo @$data['Transfer']['slotId'];?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Mã máy: </label>
										<input type="text" disabled="disabled" pattern="([a-zA-Z0-9-]+)"  maxlength="50" id="" class="form-control" value="<?php echo @$data['Transfer']['codeMachine'];?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Mã sản phẩm: </label>
										<input type="text" disabled="disabled" pattern="([a-zA-Z0-9-]+)"  maxlength="50" id="" class="form-control" value="<?php echo @$product['Product']['code'];?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Tên sản phẩm: </label>
										<input type="text" disabled="disabled" pattern="([a-zA-Z0-9-]+)" maxlength="50" id="" class="form-control" value="<?php echo @$product['Product']['name'];?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Mã giao dịch tại máy: </label>
										<input type="text" disabled="disabled" pattern="([a-zA-Z0-9-]+)"  maxlength="50" id="" class="form-control" value="<?php echo @$data['Transfer']['transactionId'];?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Mã giao dịch trên sever: </label>
										<input type="text" disabled="disabled" pattern="([a-zA-Z0-9-]+)"  maxlength="50" id="" class="form-control" value="<?php echo @$data['Transfer']['orderId'];?>" name="" required="">
									</div>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Số lượng sản phẩm: </label>
										<input type="numbe" disabled="disabled" name="" id="" value="<?php echo @$data['Transfer']['quantity'];?>" class="input_money form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Trạng thái giao dịch: </label>
										<input type="text" disabled="disabled" maxlength="50" id="" class="form-control" value="<?php global $listStatusPay; echo @$listStatusPay[$data['Transfer']['status']]['name']?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Hình thức thanh toán: </label>
										<input type="text" disabled="disabled" maxlength="50" id="" class="form-control" value="<?php echo @$listTypePay[$data['Transfer']['typedateEndPay']]['name']?>" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Doanh thu bán hàng(vnđ): </label>
										<input type="text" disabled="disabled" name="" id="" value="<?php echo number_format(@$data['Transfer']['moneyCalculate'], 0, ',', '.');?>" class="input_money form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Số tiền khách nạp(vnđ): </label>
										<input type="text" disabled="disabled" name="" id="" value="<?php echo number_format(@$data['Transfer']['moneyInput'], 0, ',', '.');?>" class="input_money form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Kênh bán hàng: </label>
										<input type="text" disabled="disabled" name="" id="" value="<?php echo @$listChannelProduct['Option']['value']['allData'][$data['Transfer']['idChannel']]['name'];?>" class="form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Tên điểm đặt: </label>
										<input type="text" disabled="disabled" name="" id="" value="<?php echo @$place['Place']['name'];?>" class="form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>NCC điểm đặt: </label>
										<input type="text" disabled="disabled" name="" id="" value="<?php echo @$patner['Patner']['name'];?>" class="form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label for="">Vùng:</label>
										<input type="text" disabled="disabled" name="" id="" value="<?php global $listArea; echo @$listArea[$data['Transfer']['area']]['name'];?>" class="form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label for="">Tỉnh/Thành phố:</label>
										<input type="text" disabled="disabled" name="" id="" value="<?php echo @$dataCity;?>" class="form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label for="">Quận/Huyện:</label>
										<input type="text" disabled="disabled" name="" id="" value="<?php echo @$dataDistrict;?>" class="form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">

										<label for="">Xã/Phường:</label>
										<input type="text" disabled="disabled" name="" id="" value="<?php echo @$wards['Wards']['name'];?>" class="form-control" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Số nhà, đường:: </label>
										<input type="text" disabled="disabled" maxlength="200" id="" value="<?php echo @$data['Transfer']['numberHouse'];?>" class="form-control" name="" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<span class="btn_ad_back"><a href="javascript:void(0);" onclick="window.history.back();">Quay lại</a></span>
								</div>
							</div>
							

						</form>
					</div>

				</div>
			</div>
		</div>



		<script type="text/javascript">
			jQuery(function ($) {
				$('.input-mask-date').mask('99/99/9999', {value: "dd/mm/yyyy"});
			});
		</script>
		<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>