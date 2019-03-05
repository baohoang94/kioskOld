<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Thông tin tài khoản</li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now"><?php echo $data['Staff']['code'];?></li>
				</ul>
				
			</div>
			<div class="row ">
				<div class="col-sm-12 ">
					<form action="" method="post">
						<input type="hidden" name="typeSubmit" value="changeInfo" />
						<div class="main_add_p">
							<?php
								if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
							?>
							
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Họ tên<span class="color_red">*</span>: </label>
										<input type="text" title="" maxlength="100" id=""  placeholder="Họ tên"  value="<?php echo arrayMap($data['Staff']['fullName']);?>" class="form-control" name="fullName" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Giới tính<span class="color_red">*</span>: </label>
										<select class="form-control" required="" name="sex">
											<option value="">Chọn giới tính</option>
											<option value="nam" <?php if($data['Staff']['sex']=='nam') echo 'selected';?> >Nam</option>
											<option value="nu" <?php if($data['Staff']['sex']=='nu') echo 'selected';?> >Nữ</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Ngày sinh<span class="color_red">*</span>: </label>
										<input type="text" required="" value="<?php echo arrayMap($data['Staff']['birthday']);?>" name="birthday" id="birthday" placeholder="Ngày sinh" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" >
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Email<span class="color_red">*</span>: </label>
										<input type="email" title=""  placeholder="Email" maxlength="100" id="" value="<?php echo arrayMap($data['Staff']['email']);?>" class="form-control" name="email" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_add">
									<div class="form-group">
										<label>Số điện thoại<span class="color_red">*</span>: </label>
										<input type="text" name="phone" placeholder="Số điện thoại"  maxlength="50" value="<?php echo arrayMap($data['Staff']['phone']);?>" class="form-control" required="" >
									</div>
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group">
									<label class="">Địa chỉ<span class="color_red">*</span>: </label>
									<div class="">
										<input type="text" maxlength="500" name="address" placeholder="Địa chỉ"  class="form-control" value="<?php echo arrayMap($data['Staff']['address']);?>" required="">
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label>Mô tả: </label>
									<textarea class="form-control"  placeholder="Mô tả" maxlength="3000" rows="3" name="desc"><?php echo arrayMap($data['Staff']['desc']);?></textarea>

								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group">
									<button class="btn_ad" style="display: inline-block !important;">Lưu</button>
								</div>
							</div>
						</div>
					</form>
					

				</div>
			</div>
			<div class="row m_top">
				<div class="col-sm-12 ">
					<div class="col-sm-12 border_t">
						<h3>Đổi mật khẩu</h3>
					</div>

					<form action="" method="post">
						<input type="hidden" name="typeSubmit" value="changePass" />
						<div class="col-sm-4">
							<div class="form-group">
								<label class="">Mật khẩu cũ:</label>
								<div class="">
									<input type="password" pattern=".{6,50}" placeholder="Mật khẩu cũ" name="passOld" value="" class="form-control" title="Mật khẩu nhập >=6 và <=50 ký tự" required="">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="">Mật khẩu mới:</label>
								<div class="">
									<input type="password" pattern=".{6,50}"  placeholder="Mật khẩu mới" name="passNew" value="" class="form-control" title="Mật khẩu nhập >=6 và <=50 ký tự" required="">
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="">Xác nhận mật khẩu mới:</label>
								<div class="">
									<input type="password" pattern=".{6,50}"  placeholder="Xác nhận mật khẩu mới" name="passAgain" value="" class="form-control" title="Mật khẩu nhập >=6 và <=50 ký tự" required="">
								</div>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<button class="btn_ad" style="display: inline-block !important;">Lưu</button>
							</div>
						</div>
					</form>
					
				</div>
				
			</div>

		</div>
	</div>

	<script type="text/javascript">
		function readURL1(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#img1')
					.attr('src', e.target.result);
				};

				reader.readAsDataURL(input.files[0]);
			}
		}

		function readURL2(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#img2')
					.attr('src', e.target.result);
				};

				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>

	<script type="text/javascript">
		try {
			ace.settings.loadState('main-container')
		} catch (e) {
		}
	</script>



	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>