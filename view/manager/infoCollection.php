<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listCollection"> Lịch sử thu tiền tại máy </a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Chỉnh sửa lịch sử thu tiền tại máy</li>
				</ul>

			</div>

			<!-- <div class="main_list_p "> -->
				<div class="main_add_p">
					<form action="" method="post">
						<?php
							if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
						?>
						<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
						<div class="row">
							<div class="col-sm-12">

								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Mã máy: </label>
											<input type="text" title="" maxlength="50" id="" placeholder="Mã máy" class="form-control" name="name" required="" disabled="" value="<?php echo @arrayMap($data['Collection']['codeMachine']);?>">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Mã nhân viên: </label>
											<input type="text" title="" maxlength="50" id="updatecode" placeholder="Mã nhân viên" class="form-control " disabled=""  name="code" required="" value="<?php echo $listStaff[$data['Collection']['idMachine']]['Machine']['codeStaff'];?>" >
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Thời gian tại server: </label>
											<input type="text" title="" maxlength="50" id="updatecode" placeholder="Mã nhân viên" class="form-control "  disabled="" name="code" required="" value="<?php echo date('d/m/Y H:i:s',$data['Collection']['timeServer']);?>" >
										</div>
									</div>
								</div><div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Thời gian tại máy: </label>
											<input type="text" title="" maxlength="50" id="updatecode" placeholder="Mã nhân viên" class="form-control "  disabled="" name="code" required="" value="<?php echo date('d/m/Y H:i:s',$data['Collection']['timeClient']);?>" >
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Doanh thu bán hàng: </label>
											<input type="" title="" maxlength="50" id="" placeholder="Doanh thu bán hàng" class="form-control" class="input_money form-control " name="" disabled=""  required="" value="<?php echo @arrayMap(number_format($data['Collection']['moneyCalculate'], 0, ',', '.'));?>" >
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Sô tiền nhân viên thu<span class="color_red">*</span>:</label>
											<input type="text" title="" maxlength="19" id="" placeholder="Số tiền nhân viên thu" class="input_money form-control " name="money" value="<?php echo @arrayMap(number_format($data['Collection']['money'], 0, ',', '.'));?>">
										</div>
									</div>
								</div>
								<div class="col-sm-12" style="<?php if(empty($data)){ echo 'display: none';  }?>;">
									<div class="form-group">
										<label>Lý do sửa<span class="color_red">*</span>:</label> </label>
										<textarea class="form-control" value="Lý do sửa" rows="3" maxlength="3000" name="reason" <?php if(!empty($data))echo'required=""';?> placeholder="Lý do sửa"></textarea>

									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<button class="btn_ad" style="display: inline-block !important;">Lưu</button>
										<span class="btn_ad_back"><a href="javascript:void(0);" onclick="window.history.back();">Quay lại</a><span>
										<!-- <div class="back_page"></div> -->
									</div>
								</div>
							</div>
						</div>

					</form>
				</div>

			</div>
			<script>
	$(document).ready(function(){
		$("input.input_date").inputmask();
		$("input.input-mask-date").inputmask();

		// $('.input_money').numbertor({
		// 	allowEmpty: true
		// });
		$('.input_money').divide({delimiter: '.',
			divideThousand: true});

		$('.input_money').on('paste', function () {
			var element = this;
			var text = $(element).val();
			if(!isNaN(text)){
				$(element).val("");
				console.log('Phải nhập số');
			}
		});


	});
</script>
			<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>



