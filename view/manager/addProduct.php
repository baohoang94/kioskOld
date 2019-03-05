<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<script>
	$(document).ready(function(){
		$(".allChannel").click(function(){
			$(".listChannel").slideToggle();
			$(".allChannel .fa").toggleClass('fa-angle-down');
			$(".allChannel .fa").toggleClass('fa-angle-up');
		});
	});
</script>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<!-- <li class="back_page"><a href="/listProduct"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li> -->
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listProduct"> Quản lý sản phẩm</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now"><?php if(empty($data)){ echo'Thêm sản phẩm mới';}else{echo'Chỉnh sửa sản phẩm';}?></li>
				</ul>

			</div>

			<!-- <div class="main_list_p "> -->
				<div class="main_add_p">
					<div class="card">
						<?php
						if(!empty($mess)) echo '<div class="col-sm-12" style="color:red">'.$mess.'</div>';
							?>
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation">
									<a href="/listProduct"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
								</li>
								<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Thông tin</a></li>
							</ul>


							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="home">
									<form action="" method="post">
										<div class="row">
											<div class="col-sm-12">

												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Tên sản phẩm<span class="color_red">*</span>: </label>
															<input type="text" title="" maxlength="50" id="" placeholder="Tên sản phẩm" class="form-control"  name="name" value="<?php echo @arrayMap($data['Product']['name']);?>" required="">
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Mã sản phẩm<span class="color_red">*</span>: </label>
															<span id="eror"></span>
															<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="updatecode" placeholder="Mã sản phẩm" class="form-control " name="code" value="<?php echo @arrayMap($data['Product']['code']);?>" required="">

														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Giá nhập (vnđ)<span class="color_red">*</span>: </label>
															<input type="text" title="" maxlength="19" id="" placeholder="Giá nhập" class="input_money form-control " name="priceInput" value="<?php echo @arrayMap($data['Product']['priceInput']);?>" required="">
															<div class="showNumber">

															</div>
															<div class="returnkq">

															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Giá bán (vnđ)<span class="color_red">*</span>: </label>
															<input type="text" title="" maxlength="19" id="" placeholder="Giá bán" class="input_money form-control" name="priceOutput" value="<?php echo @arrayMap($data['Product']['priceOutput']);?>" required="">
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Ngành hàng<span class="color_red">*</span>: </label>
															<select name="idCategory" class="form-control" required>
																<option value="">Chọn ngành hàng</option>
																<?php
																if(!empty($listCategoryProduct['Option']['value']['allData'])){
																	foreach($listCategoryProduct['Option']['value']['allData'] as $components){
																		if($data['Product']['idCategory']!=$components['id']){
																			echo '<option value="'.$components['id'].'">'.$components['name'].'</option>';
																		}else{
																			echo '<option selected value="'.$components['id'].'">'.$components['name'].'</option>';
																		}
																	}
																}
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Hạn sử dụng<span class="color_red">*</span>: </label>
															<input type="text" placeholder="Nhập ngày hết hạn" name="exp" id="" data-inputmask="'alias': 'date'" class="input_date form-control" value="<?php echo @arrayMap($data['Product']['exp']['text']);?>"  pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" required="">
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Quy cách sản phẩm<span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" placeholder="Quy cách sản phẩm" name="specification" id="" class="form-control" value="<?php echo @arrayMap($data['Product']['specification']);?>" required="">
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Quy cách đóng thùng<span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" placeholder="Quy cách đóng thùng" name="packing" id="" class="form-control" value="<?php echo @arrayMap($data['Product']['packing']);?>" required="">
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Kênh bán hàng<span class="color_red">*</span>:</label>
															<div class="allChannel" style="cursor:pointer"><input type="checkbox" name="allChannel" value="all">Tất cả kênh <i class="fa fa-angle-down" aria-hidden="true"></i></div>
															<br>
															<div class="listChannel" style="display:none">
																<?php
																if(!empty($listChannelProduct['Option']['value']['allData'])){
																	foreach($listChannelProduct['Option']['value']['allData'] as $components){
																		if(empty($data['Product']['idChannel']) || $data['Product']['idChannel']!=$components['id']){
																			echo '<input type="checkbox" name="idChannel['.$components['id'].'][\'id\']" value="'.$components['id'].'">'.$components['name'];
																		}else{
																			echo '<input type="checkbox" checked name="idChannel['.$components['id'].'][\'id\']" value="'.$components['id'].'">'.$components['name'];
																		}
																	}
																}
																?>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Lò xo trưng bày<span class="color_red">*</span>: </label>
															<select name="loso" class="form-control" required>
																<option value="">Chọn loại lò xo</option>
																<option value="60" <?php if(isset($data['Product']['loso']) && $data['Product']['loso']==60) echo 'selected';?> >60 cm</option>
																<option value="80" <?php if(isset($data['Product']['loso']) && $data['Product']['loso']==80) echo 'selected';?> >80 cm</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Nhà cung cấp<span class="color_red">*</span>: </label>
															<select name="idSupplier" class="form-control" required>
																<option value="">Chọn nhà cung cấp</option>
																<?php
																if(!empty($listSupplier)){
																	foreach($listSupplier as $supplier){
																		if(empty($data['Product']['idSupplier']) || $data['Product']['idSupplier']!=$supplier['Supplier']['id']){
																			echo '<option value="'.$supplier['Supplier']['id'].'">'.$supplier['Supplier']['name'].'</option>';
																		}else{
																			echo '<option selected value="'.$supplier['Supplier']['id'].'">'.$supplier['Supplier']['name'].'</option>';
																		}
																	}
																}
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Doanh thu cam kết (vnđ): </label>
															<input type="text" title="" maxlength="19" id="" placeholder="Doanh thu cam kết" class="input_money form-control" value="<?php echo @arrayMap($data['Product']['revenue']);?>" name="revenue" >
														</div>
													</div>
												</div>
												<div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Ngày bắt đầu: </label>
			                        <input type="text" title="Ngày bắt đầu" placeholder="Nhập kiểu ngày tháng" class="form-control checkcode"  name="dateStart" value="">
			                      </div>
			                      <p id="keo">

			                      </p>
			                    </div>
			                  </div>
			 <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label style="color:red">Dung tích/trọng lượng (ml): </label>
			                        <input type="text" name="weight" id="" value="" placeholder=""  title="" class="form-control">
			                      </div>
			                    </div>
			                  </div>
			 <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label style="color:red">Giá nhập/thùng có thuế: </label>
			                        <input type="text" name="priceInputPackingTax" id="" value="" placeholder=""  title="" class="form-control input_money">
			                      </div>
			                    </div>
			                  </div>
			  <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Thuế suất: </label>
			                        <input type="number" name="tax" id="" value="" min="0" max="100" placeholder=""  title="" class="form-control">
			                      </div>
			                    </div>
			                  </div>
			  <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Mức CK trực tiếp: </label>
			                        <input type="text" name="directDiscount" id="" value="" placeholder=""  title="" class="form-control">
			                      </div>
			                    </div>
			                  </div>
			  <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Tổng chiết khấu trả sau: </label>
			                        <input type="text" name="totalPostpayDiscount" id="" value="" placeholder=""  title="" class="form-control">
			                      </div>
			                    </div>
			                  </div>
			                  <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Tổng doanh thu CCDV: </label>
			                        <input type="text" name="totalRevenue" id="" value="" placeholder=""  title="" class="form-control input_money">
			                      </div>
			                    </div>
			                  </div>
			                  <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Tổng thu nhập khác: </label>
			                        <input type="text" name="totalOtherIncome" id="" value="" placeholder=""  title="" class="form-control input_money">
			                      </div>
			                    </div>
			                  </div>
			 <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Phân bổ chi phí: CF-BH </label>
			                        <input type="text" name="insuranceCosts" id="" value="" placeholder=""  title="" class="form-control input_money">
			                      </div>
			                    </div>
			                  </div>
			                  <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Phân bổ chi phí: CF-QL </label>
			                        <input type="text" name="managementCosts" id="" value="" placeholder=""  title="" class="form-control input_money">
			                      </div>
			                    </div>
			                  </div>
			                  <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label>Phân bổ chi phí: Lãi vay </label>
			                        <input type="text" name="borrow" id="" value="" placeholder=""  title="" class="form-control input_money">
			                      </div>
			                    </div>
			                  </div>
			                  <div class="col-sm-4">
			                    <div class="form_add">
			                      <div class="form-group">
			                        <label style="color:red">Tỉnh/thành phố:</label>
			                        <select name="idCity" class="form-control">
			                          <option value="">Lựa chọn tỉnh thành</option>
			                          <?php
			 														global $modelOption;
			 														$listCityKiosk=$modelOption->getOption('cityKiosk');
			 														if (!empty($listCityKiosk['Option']['value']['allData'])) {
			 															foreach ($listCityKiosk['Option']['value']['allData'] as $city) {
			 																if (!isset($_GET['idCity']) || $_GET['idCity'] != $city['id']) {
			 																	echo '<option value="' . $city['id'] . '">' . arrayMap($city['name']) . '</option>';
			 																} else {
			 																	echo '<option value="' . arrayMap($city['id']) . '" selected>' . $city['name'] . '</option>';
			 																}
			 															}
			 														}
			 													?>
			                        </select>
			                      </div>
			                    </div>
			                  </div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Giá bán tham chiếu (vnđ): </label>
															<div class="table-responsive">
																<table>
																	<tr>
																		<td>
																			<label for="">BigC</label>
																			<input type="text" class="input_money form-control" placeholder="BigC" maxlength="19" value="<?php echo @arrayMap($data['Product']['priceReference']['bigc']);?>" name="priceReference[bigc]">
																		</td>
																		<td>
																			<label for="">Vingroup</label>
																			<input type="text" class="input_money form-control" placeholder="Vingroup" maxlength="19" value="<?php echo @arrayMap($data['Product']['priceReference']['vingroup']);?>" name="priceReference[vingroup]">
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<label for="">Vinmart</label>
																			<input type="text" class="input_money form-control" placeholder="Vinmart" maxlength="19" value="<?php echo @arrayMap($data['Product']['priceReference']['vinmart']);?>" name="priceReference[vinmart]">
																		</td>
																		<td>
																			<label for="">Coopmark</label>
																			<input type="text" class="input_money form-control" placeholder="Coopmark" maxlength="19" value="<?php echo @arrayMap($data['Product']['priceReference']['coopmark']);?>" name="priceReference[coopmark]">
																		</td>
																	</tr>
																	<?php if(empty($_GET['id'])){ ?>
																	<!-- <tr>
																		<td colspan="2">
																			<label for="">Số lượng:</label>
																			<input type="text" class="input_money form-control" placeholder="Nhập số lượng" maxlength="19" value="<?php echo @$data['Product']['quantity'];?>" name="quantity">
																		</td>
																	</tr> -->
																	<?php }?>
																	<tr>
																		<td colspan="2" class="imageDefault">
																			<label for="">Hình minh họa:</label>
																			<div style="clear:both;"></div>
																			<div id="keo">
																				<?php
																				showUploadFile('image','image',@arrayMap($data['Product']['image']),0);
																				?>
																				<span class="reset"><i class="fa fa-repeat" aria-hidden="true"></i></span>
																			</div>
																			<style type="text/css">
																			.reset:hover{
																				color: blue;
																			}
																		</style>
																		<script type="text/javascript">
																			$('.reset').click(function(){
																				$("#image").val('');

																			});
																		</script>
																	</td>
																</tr>
															</table>
														</div>

													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>Đánh giá bán hàng: </label>
													<textarea class="form-control" maxlength="3000" name="evaluate" placeholder="Đánh giá bán hàng" rows="8"><?php echo @arrayMap($data['Product']['evaluate']);?></textarea>

												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label> Ghi chú: </label>
													<textarea class="form-control" name="note" maxlength="3000" placeholder=" Ghi chú" rows="8" ><?php echo @arrayMap($data['Product']['note']);?></textarea>

												</div>
											</div>
											<div class="col-sm-12" style="<?php if(empty($data)){ echo'display: none;';}?>">
												<div class="form-group">
													<label> Lý do sửa <span class="color_red">*</span>: </label>
													<textarea class="form-control" maxlength="3000" name="reason" rows="3" <?php if(!empty($data))echo'required=""';?> placeholder="Lý do sửa"></textarea>

												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<button class="btn_ad" style="display: inline-block !important;" type="submit">Lưu</button>
													<span class="btn_ad_back"><a href="/listProduct">Quay lại</a></span>
												</div>
											</div>
										</div>
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>

			</div>

			<!-- <script type="text/javascript">
				$("#updatecode").keyup(function(){
					var value = $( this ).val();
					regex = /^[a-zA-Z0-9-]+$/
					if(value){
						if (regex.test(value)) {
						} else {
							alert('Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang');
							var a;
							if(value.includes(' ')){
								a=value.replace(' ','');
							}
							if(value.includes('`')){
								a=value.replace('`','');
							}
							if(value.includes('~')){
								a=value.replace('~','');
							}
							if(value.includes('!')){
								a=value.replace('!','');
							}
							if(value.includes('@')){
								a=value.replace('@','');
							}
							if(value.includes('#')){
								a=value.replace('#','');
							}
							if(value.includes('$')){
								a=value.replace('$','');
							}
							if(value.includes('%')){
								a=value.replace('%','');
							}
							if(value.includes('~^')){
								a=value.replace('~^','');
							}
							if(value.includes('&')){
								a=value.replace('&','');
							}
							if(value.includes('*')){
								a=value.replace('*','');
							}
							if(value.includes('(')){
								a=value.replace('(','');
							}
							if(value.includes(')')){
								a=value.replace(')','');
							}
							if(value.includes('=')){
								a=value.replace('=','');
							}
							if(value.includes('_')){
								a=value.replace('_','');
							}
							if(value.includes('+')){
								a=value.replace('+','');
							}
							if(value.includes('/')){
								a=value.replace('/','');
							}
							if(value.includes('>')){
								a=value.replace('>','');
							}
							if(value.includes('<')){
								a=value.replace('<','');
							}
							if(value.includes(']')){
								a=value.replace(']','');
							}
							if(value.includes('[')){
								a=value.replace('[','');
							}
							if(value.includes('|')){
								a=value.replace('|','');
							}
							$('#updatecode').val(a);

						}
					}

				});

			</script> -->
			<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>
