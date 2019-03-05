<!--
// * Ngay tao:
// * Ghi chú:
// * Lịch sử sửa:
//  + Lần sửa: v1
//  + Ngay: 22/08/2018
//  + Người sửa: Hưng
//  + Nội dung sửa:
//    - Thêm cột giá trị(dòng 144,202).
  -->
<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Quản lý mã coupon</li>
				</ul>

			</div>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<tr>
									<td>
										<div class="add_p">
											<a href="/addCoupon">Thêm  mã coupon mới</a>
											<br><br>
											<a href="/uploadCoupon">upload coupon</a>
										</div>
									</td>
									<td>
										<form>
											<table class="table table-bordered">
												<tr>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['codeCoupon']);?>" class="form-control" placeholder="Mã coupon" name="codeCoupon">
													</td>
													<td>
														<input type="text" class="form-control" placeholder="Tên coupon" name="name" value="<?php echo @arrayMap($_GET['name']);?>">
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['codeProduct']);?>" class="form-control" placeholder="Mã sản phẩm" name="codeProduct">
													</td>
													<td>
														<input type="text" title="" maxlength="50" id="" placeholder="Số lượng" class="input_money form-control" name="quantity"  value="<?php echo @arrayMap($_GET['quantity']);?>">
													</td>

													<td rowspan="3">
														<button class="add_p1">Tìm kiếm</button>
													</td>
												</tr>
												<tr>

													<td>
														<input type="text" title="" maxlength="50" id="" placeholder="Số lượng thành công" class="input_money form-control" name="quantityActive"  value="<?php echo @arrayMap($_GET['quantityActive']);?>">
													</td>
													<td>
														<input type="text" name="dateStart" id="" value="<?php echo @$_GET['dateStart'];?>" placeholder="Ngày phát hành" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control">
													</td>
													<td>
														<input type="text" name="dateEnd" id="" value="<?php echo @$_GET['dateEnd'];?>" placeholder="Ngày hết hạn" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control" >
														
													</td>
													<td>
														
														
													</td>
												</tr>
												<tr>
													<td>
														<select name="status" class="form-control" placeholder="Trạng thái">
															<option value="">Trạng thái</option>
															<option value="active" <?php if(!empty($_GET['status'])&&$_GET['status']=='active') echo'selected';?>>Kích hoạt</option>
															
															<option value="lock" <?php if(!empty($_GET['status'])&&$_GET['status']=='lock') echo'selected';?>>Khóa</option>

														</select>
													</td>
													<td>
														<input type="text" value="<?php echo @arrayMap($_GET['codeMachine']);?>" class="form-control" placeholder="Mã máy Kiosk" name="codeMachine">
													</td>
													<td>
														<!-- <input type="text" class="col-sm-12 form-control" name="kenh" placeholder="Kênh bán hàng" list="kenh"> -->
														<select id="kenh" class="form-control" name="idChannel">
															<option value="">Kênh bán hàng</option>
															<?php 
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
														<select name="idPlace" class="form-control">
															<option value="">Điểm đặt máy</option>
															<?php 
															$modelPlace = new Place;
															$conditionsPlace['lock']=(int)0;
															$fields=array('name');
															$listPlace=$modelPlace->find('all', array('conditions'=>$conditionsPlace,'fields'=>$fields));
															if(!empty($listPlace)){
																foreach ($listPlace as $key => $value) {
															# code...
																	?>
																	<option value="<?php echo $value['Place']['id'];?>" <?php if(!empty($_GET['idPlace'])&&$_GET['idPlace']==$value['Place']['id']) echo'selected';?>><?php echo $value['Place']['name'];?></option>
																	<?php 
																}
															}
															?>
														</select>
													</td>
												</tr>
												
											</table>
										</form>
									</td>
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
										<th class="text_table">Mã coupon</th>
										<th class="text_table">Tên coupon</th>
										<th class="text_table">Ngày phát hành</th>
										<th class="text_table">Ngày hết hạn</th>
										<th class="text_table">Giá trị</th>
										<th class="text_table">Mã máy Kiosk</th>
										<th class="text_table">Trạng thái</th>
										<th class="text_table">Kênh bán hàng</th>
										<th class="text_table">Điểm đặt máy</th>
										<th class="text_table">Mã sản phẩm</th>
										<th class="text_table">Số lượng</th>
										<th class="text_table">Số lượng thành công</th>
										<th class="text_table" >Hành động</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(!empty($listData)){
										global $listStatusCoupon;
										if (!isset($_GET['page'])) {
											$i=0;
										}
										elseif (isset($_GET['page'])&&$_GET['page']==1) {
											$i=0;
										}elseif (isset($_GET['page'])>=2)
										{
											$i=$_GET['page']*15-15;
										} 
										foreach($listData as $key=> $data){
											if($data['Coupon']['idPlace']){
												$place[$key]=$modelPlace->getPlace($data['Coupon']['idPlace'],array('name'));
											}
											$i++;

											if(!empty($data['Coupon']['idMachine'])){
												$codeMachine= '<a href="/structureMachine?id='.$data['Coupon']['idMachine'].'">'.$data['Coupon']['codeMachine'].'</a>';
											}else{
												$codeMachine= $data['Coupon']['codeMachine'];
											}

											echo '
											<tr>
											<td class="text_table">'.$i.'</td>
											<td>'.@$data['Coupon']['codeCoupon'].'</td>
											<td>'.@$data['Coupon']['name'].'</td>
											<td class="text_table">'.@$data['Coupon']['dateStart']['text'].'</td>
											<td class="text_table">'.@$data['Coupon']['dateEnd']['text'].'</td>
											<td class="text_table">'.@$data['Coupon']['value'].'</td>
											<td class="text_table">'.@$codeMachine.'</td>
											<td>'.@$listStatusCoupon[$data['Coupon']['status']]['name'].'</td>
											<td>'.@$listChannelProduct['Option']['value']['allData'][$data['Coupon']['idChannel']]['name'].'</td>
											<td><a href="infoPlace?id='.@$data['Coupon']['idPlace'].'">'.@$place[$key]['Place']['name'].'</a></td>
											<td><a href="/infoProduct?id='.$data['Coupon']['idProduct'].'">'.$data['Coupon']['codeProduct'].'</a</td>
											<td style="text-align: right;">'.number_format($data['Coupon']['quantity'], 0, ',', '.').'</td>
											<td style="text-align: right;">'.number_format($data['Coupon']['quantityActive'], 0, ',', '.').'</td>
											
											<td>
											<ul class="list-inline list_i" style="">
											<li><a href="/addCoupon?id='.$data['Coupon']['id'].'" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li> 
											<li><a href="/infoCoupon?id='.$data['Coupon']['id'].'" title="Chỉnh sửa"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
											<li><a onclick="return confirm(\'Bạn có chắc chắn muốn xóa không ?\')" href="/deleteCoupon?id='.$data['Coupon']['id'].'" title="Xóa" class="bg_red"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
											</ul>
											</td>
											</tr>';
										}
									}else{
										echo '<tr><td align="center" colspan="13">Chưa có dữ liệu</td></tr>';
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
				</div>


			</div>
		</div>
	</div>

	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>