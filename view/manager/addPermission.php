<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<!-- <li class="back_page"><a href="/groupPermission?idCompany=<?php echo $_GET['idCompany'];?>&idBranch=<?php echo $_GET['idBranch'];?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listCompany"> Danh sách công ty</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listBranch?idCompany=<?php echo $_GET['idCompany'];?>"> Danh sách chi nhánh</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/groupPermission?idCompany=<?php echo $_GET['idCompany'];?>&idBranch=<?php echo $_GET['idBranch'];?>"> Danh sách khối phòng ban</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now"><?php if(!empty($data)){ echo'Chỉnh sửa khối phòng ban: '.@$data['Permission']['name'].'';}else{ echo'Thêm khối phòng ban mới';}?></li>
				</ul>

			</div>

			<!-- <div class="main_list_p "> -->
				<div class="main_add_p">
					<form action="" method="post">
						<?php
						if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
						?>
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Mã khối phòng ban<span class="color_red">*</span>: </label>
											<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="updatecode" value="<?php echo @$data['Permission']['code'];?>" class="form-control checkcode" placeholder="Mã khối phòng ban" name="code" required="" <?php if(!empty($data['Permission']['code']))echo'disabled';?>>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Tên khối phòng ban<span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="" placeholder="Tên khối phòng ban" class="form-control"  name="name" required="" value="<?php echo @arrayMap($data['Permission']['name']);?>">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form_add">
										<div class="form-group">
											<label>Tên trưởng khối phòng ban<span class="color_red">*</span>: </label>
											<input type="text" title="" maxlength="50" id="" value="<?php echo @arrayMap($data['Permission']['leader']);?>" class="form-control" placeholder="Tên trưởng khối phòng ban" name="leader" required="">
										</div>
									</div>
								</div>
								<!-- <div class="col-sm-12">
									<div class="form_add">
										<div class="form-group">
											<label>Tên khối phòng ban (<span class="color_red">*</span>): </label>
											<input type="text" title="" maxlength="" id="" placeholder="" class="form-control"  name="name" required="" value="<?php echo @$data['Permission']['name'];?>">
										</div>
									</div>
								</div> -->
								
								<div class="col-sm-12">
								<div class="form-group">
										<label>Danh sách quyền: </label>
										<script type="text/javascript">
											function addCheck(idCheckbox)
											{
												$('#'+idCheckbox).attr( 'checked', true );
											}
										</script>

										<!-- <div class="row">
											<?php
											global $listPermission;
											foreach($listPermission as $key=>$permissionGroup){
												$checkGroup= false;
												echo '<div class="col-md-4">
												<ul class="list-unstyled list_addPer">
												<li class="has_sub_staff"><span><input type="checkbox" id="check'.$key.'"> <label for="">'.$permissionGroup['name'].' <i class="fa fa-angle-down"></i></label></span>
												<ul class="list-unstyled sub_staff">';
												foreach($permissionGroup['sub'] as $keySub=>$sub){
													if(!empty($data['Permission']['permission']) && in_array($sub['permission'], $data['Permission']['permission'])){
														$check= 'checked';
														$checkGroup= true;
													}else{
														$check= '';
													}
													echo '<li><input name="permission[]" '.$check.' type="checkbox" value="'.$sub['permission'].'" id="check'.$key.'_'.$keySub.'"> <label for="check'.$key.'_'.$keySub.'">'.$sub['name'].'</label></li>';
												}
												echo			'</ul>
												</li>
												</ul>
												</div>';

												if($checkGroup){
													echo '<script type="text/javascript">addCheck("check'.$key.'");</script>';
												}
											}
											?>

										</div>


										<script>
											$(document).ready(function() {
												$('.list_addPer ul').hide();
												$('.has_sub_staff span label').click(function(){
													if($(this).parent().next('.sub_staff').hasClass('show')){
														$(this).parent().next('.sub_staff').slideUp();
														$(this).parent().next('.sub_staff').removeClass('show');

													} else{
														$(this).parent().next('.sub_staff').slideDown();
														$(this).parent().next('.sub_staff').addClass('show');
													}
												});

												$(".has_sub_staff span input").click(function(){
													$(this).parent().parent().find('input').prop('checked', this.checked);    
												});
											});
										</script>
									</div> --> 
									 <div class="row">
										<?php 
										global $listPermission;
										$namg1= array();
										$namg2 = array();
										$namg3 = array();
										// $checkGroup= false;
										foreach($listPermission as $key=>$permissionGroup){
											if($key%2==0){
												array_push($namg2, $permissionGroup);
											}elseif ($key%3==0) {
												array_push($namg3, $permissionGroup);
											}elseif (($key%3!=0)&&($key%2!=0)) {
												array_push($namg1, $permissionGroup);
											}
										}

										?>
										<div class="col-md-4">
											<ul class="list-unstyled list_addPer">
												<?php
												foreach ($namg1 as $key => $value) {
														 	# code...
													echo'<li class="has_sub_staff"><span><input type="checkbox" id="check'.$key.'"> <label for="">'.$value['name'].' <i class="fa fa-angle-down"></i></label></span>
													<ul class="list-unstyled sub_staff">

													';
													if(!empty($value['sub'])){
														foreach ($value['sub'] as $keySub => $sub) {
															if(!empty($data['Permission']['permission']) && in_array($sub['permission'], $data['Permission']['permission'])){
																$check= 'checked';
																$checkGroup= true;
															}else{
																$check= '';
															}
															echo'
															<li><input name="permission[]" '.$check.' type="checkbox" value="'.$sub['permission'].'" id="check'.$key.'_'.$keySub.'"> <label for="check'.$key.'_'.$keySub.'">'.$sub['name'].'</label></li>
															';
														}
													}
													echo'</ul></li>';
													if($checkGroup){
														echo '<script type="text/javascript">addCheck("check'.$key.'");</script>';
													}
												}

												?>
											</ul>
										</div>
										<div class="col-md-4">
											<ul class="list-unstyled list_addPer">
												<?php
												foreach ($namg2 as $key2 => $value2) {
														 	# code...
													echo'<li class="has_sub_staff"><span><input type="checkbox" id="check2'.$key2.'"> <label for="">'.$value2['name'].' <i class="fa fa-angle-down"></i></label></span>
													<ul class="list-unstyled sub_staff">

													';
													if(!empty($value2['sub'])){
														foreach ($value2['sub'] as $keySub2 => $sub2) {
															if(!empty($data['Permission']['permission']) && in_array($sub2['permission'], $data['Permission']['permission'])){
																$check2= 'checked';
																$checkGroup= true;
															}else{
																$check2= '';
															}
															echo'
															<li><input name="permission[]" '.$check2.' type="checkbox" value="'.$sub2['permission'].'" id="check2'.$key2.'_'.$keySub2.'"> <label for="check'.$key2.'_'.$keySub2.'">'.$sub2['name'].'</label></li>
															';
														}
													}
													echo'</ul></li>';
													if(!empty($checkGroup)){
														echo '<script type="text/javascript">addCheck("check2'.$key2.'");</script>';
													}
												}

												?>
											</ul>
										</div>
										<div class="col-md-4">
											<ul class="list-unstyled list_addPer">
												<?php
												foreach ($namg3 as $key3 => $value3) {
														 	# code...
													echo'<li class="has_sub_staff"><span><input type="checkbox" id="check3'.$key3.'"> <label for="">'.$value3['name'].' <i class="fa fa-angle-down"></i></label></span>
													<ul class="list-unstyled sub_staff">

													';
													if(!empty($value3['sub'])){
														foreach ($value3['sub'] as $keySub3 => $sub3) {
															if(!empty($data['Permission']['permission']) && in_array($sub3['permission'], $data['Permission']['permission'])){
																$check3= 'checked';
																$checkGroup= true;
															}else{
																$check3= '';
															}
															echo'
															<li><input name="permission[]" '.$check3.' type="checkbox" value="'.$sub3['permission'].'" id="check3'.$key3.'_'.$keySub3.'"> <label for="check'.$key3.'_'.$keySub3.'">'.$sub3['name'].'</label></li>
															';
														}
													}
													echo'</ul></li>';
													if($checkGroup){
														echo '<script type="text/javascript">addCheck("check3'.$key3.'");</script>';
													}
												}

												?>
											</ul>
										</div>
									</div>

									<script>
										$(document).ready(function() {
											$('.list_addPer ul').hide();
												$('.has_sub_staff span label').click(function(){
													if($(this).parent().next('.sub_staff').hasClass('show')){
														$(this).parent().next('.sub_staff').slideUp();
														$(this).parent().next('.sub_staff').removeClass('show');

													} else{
														$(this).parent().next('.sub_staff').slideDown();
														$(this).parent().next('.sub_staff').addClass('show');
													}
												});

												$(".has_sub_staff span input").click(function(){
													$(this).parent().parent().find('input').prop('checked', this.checked);    
												});
											});
										
										// 	$('.list_addPer ul').hide();
										// 	$('.has_sub_staff span label').click(function(){
										// 		if($(this).parent().next('.sub_staff').hasClass('show')){
										// 			$(this).parent().next('.sub_staff').slideUp();
										// 			$(this).parent().next('.sub_staff').removeClass('show');

										// 		} else{
										// 			$(this).parent().next('.sub_staff').slideDown();
										// 			$(this).parent().next('.sub_staff').addClass('show');
										// 		}
										// 	});

										// 	$(".has_sub_staff span input").click(function(){
										// 		$(this).parent().parent().find('input').prop('checked', this.checked);    
										// 	});
										// 	$('.has_sub_staff span input').each(function() {
										// 		if($(this).is(':checked')){
										// 			$(this).parent().parent().find('input').attr('checked',true);
										// 			console.log('a');
										// 		}
										// 	});
										// });
									</script> 
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<button class="btn_ad" style="display: inline-block !important;">Lưu</button>
										<span class="btn_ad_back"><a href="/groupPermission?idCompany=<?php echo $_GET['idCompany'];?>&idBranch=<?php echo $_GET['idBranch'];?>">Quay lại</a></span>
									</div>
								</div>
							</div>
						</div>

					</form>
				</div>

			</div>

			<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>



