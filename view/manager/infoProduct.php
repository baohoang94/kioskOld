<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">

		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_prev"><a href="/listProduct"> Quản lý sản phẩm</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Xem chi tiết sản phẩm</li>
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
															<input type="text" title="" maxlength="50" id="" placeholder="Tên sản phẩm" class="form-control"  name="name" value="<?php echo @arrayMap($data['Product']['name']);?>" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Mã sản phẩm<span class="color_red">*</span>: </label>
															<input type="text" pattern="([a-zA-Z0-9-]+)" title="Nhập mã không chứa nội dung khoảng trắng, ký tự có dấu. Chỉ sử dụng chữ cái (a-z. A-Z), số, dấu gạch ngang " maxlength="50" id="" placeholder="Mã sản phẩm" class="form-control" name="code" value="<?php echo @arrayMap($data['Product']['code']);?>" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Giá nhập (vnđ)<span class="color_red">*</span>: </label>
															<input type="text" title="" maxlength="50" id="" placeholder="Giá nhập" class="input_money form-control" name="priceInput" value="<?php echo @arrayMap($data['Product']['priceInput']);?>" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Giá bán (vnđ)<span class="color_red">*</span>: </label>
															<input type="text" title="" maxlength="50" id="" placeholder="Giá bán" class="input_money form-control" name="priceOutput" value="<?php echo @arrayMap($data['Product']['priceOutput']);?>" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Ngành hàng<span class="color_red">*</span>: </label>
															<select name="idCategory" class="form-control" required disabled="">
																<option value="">Chọn ngành hàng</option>
																<?php
																if(!empty($listCategoryProduct['Option']['value']['allData'])){
																	foreach($listCategoryProduct['Option']['value']['allData'] as $components){
																		if(empty($data['Product']['idCategory']) || $data['Product']['idCategory']!=$components['id']){
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
															<input type="text" placeholder="Nhập ngày hết hạn" name="exp" id="" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="input_date form-control" value="<?php echo @arrayMap($data['Product']['exp']['text']);?>" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Quy cách sản phẩm<span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" placeholder="Nhập đặc điểm kỹ thuật" name="specification" id="" class="form-control" value="<?php echo @arrayMap($data['Product']['specification']);?>" required="" disabled>
														</div >
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Quy cách đóng thùng<span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" placeholder="Quy cách đóng thùng" name="packing" id="" class="form-control" value="<?php echo @arrayMap($data['Product']['packing']);?>" required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Kênh bán hàng<span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" placeholder="Kênh bán hàng" name="packing" id="" class="form-control" value="<?php echo  @arrayMap($listChannelProduct['Option']['value']['allData'][$data['Product']['idChannel']]['name']); ?> " required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Lò xo trưng bày<span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" placeholder="Lò so trưng bày" name="packing" id="" class="form-control" value="<?php if($data['Product']['loso']){echo @arrayMap($data['Product']['loso']); echo'cm';} ?> " required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Nhà cung cấp<span class="color_red">*</span>: </label>
															<input type="text" maxlength="50" placeholder="Nhà cung cấp" name="packing" id="" class="form-control" value="<?php echo @arrayMap($supplier['Supplier']['name']);?> " required="" disabled>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form_add">
														<div class="form-group">
															<label>Doanh thu cam kết (vnđ): </label>
															<input type="text" title="" maxlength="50" id="" placeholder="Doanh thu cam kết" class="input_money form-control" value="<?php echo @arrayMap($data['Product']['revenue']);?>" name="revenue" required="" disabled>
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
																			<input type="text" class="input_money form-control" placeholder="BigC" maxlength="50" value="<?php echo @arrayMap($data['Product']['priceReference']['bigc']);?>" name="priceReference[bigc]" disabled>
																		</td>
																		<td>
																			<label for="">Vingroup</label>
																			<input type="text" class="input_money form-control" placeholder="Vingroup" maxlength="50" value="<?php echo @arrayMap($data['Product']['priceReference']['vingroup']);?>" name="priceReference[vingroup]" disabled>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<label for="">Vinmart</label>
																			<input type="text" class="input_money form-control" placeholder="Vinmart" maxlength="50" value="<?php echo @arrayMap($data['Product']['priceReference']['vinmart']);?>" name="priceReference[vinmart]" disabled>
																		</td>
																		<td>
																			<label for="">Coopmark</label>
																			<input type="text" class="input_money form-control" placeholder="Coopmark" maxlength="50" value="<?php echo @arrayMap($data['Product']['priceReference']['coopmark']);?>" name="priceReference[coopmark]" disabled>
																		</td>
																	</tr>
																	<!-- <tr>
																		<td colspan="2">
																			<label for="">Số lượng<span class="color_red">*</span></label>
																			<input type="number" class="input_money form-control" placeholder="Nhập số lượng" maxlength="50" value="<?php echo @arrayMap($data['Product']['quantity']);?>" name="quantity" disabled>
																		</td>
																	</tr> -->
																	<tr>
																		<td colspan="2" class="imageDefault">
																			<label for="">Hình minh họa:</label>
																			<div style="clear:both;"></div>
																			<div class="m_bg_img" style="">
																				<?php 
																				if(!empty($data['Product']['image'])){
																					echo'<img id="img1" src="'.$data['Product']['image'].'" class="img-responsive">';

																				}
																				// else{
																				// 	echo'<img id="img1" src="'.$urlThemeActive.'images/ava.jpg" class="img-responsive">';
																				// }
																				?>
																				
																			</div>
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
														<textarea class="form-control" maxlength="3000" name="evaluate" placeholder="Đánh giá bán hàng" rows="10" disabled><?php echo @arrayMap($data['Product']['evaluate']);?></textarea>

													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label>Ghi chú: </label>
														<textarea class="form-control" maxlength="3000" name="note" placeholder="Ghi chú" rows="10" disabled><?php echo @arrayMap($data['Product']['note']);?></textarea>

													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group">
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


				<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>



