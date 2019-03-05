<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/header.php'; ?>
<div class="container-fluid main-container">
	<div class="col-md-12 content">
		
		<div class="panel panel-default listDevice1">
			<div class="panel-heading">
				<ul class="list-inline">
					<li class="page_prev"><a href="/dashboard"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
					<li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
					<li class="page_now">Lịch sử thu tiền tại máy</li>
					
				</ul>
			</div>

			<div class="main_list_p ">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive table1">
							<table class="table table-bordered">
								<form method="GET" action="" >
									<tr>
										<td>
											<input type="text" class="form-control" value="<?php echo @arrayMap($_GET['codeMachine']);?>" placeholder="Mã máy" name="codeMachine">
										</td>
										<td>
											<input type="text" placeholder="Mã nhân viên" maxlength="100" name="codeStaff" id="" value="<?php echo @arrayMap($_GET['codeStaff']);?>"  class="form-control">
										</td>
										
										<td>
											<input type="text" value="<?php echo @$_GET['dateStart'];?>" name="dateStart" id="" placeholder="Từ ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control">
										</td>
										<td>
											<input type="text" value="<?php echo @$_GET['dateEnd'];?>" name="dateEnd" id="" placeholder="Đến ngày" data-inputmask="'alias': 'date'" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$"  title="Nhập đúng định dạng ngày tháng dd/mm/yyyy. Ví dụ: 24/12/1989" class="input_date form-control">
										</td>
										
										<td>
											<button class="add_p1">Tìm kiếm</button>
										</td>
									</tr>
									<tr>
										<td>
											<input type="text" name="moneyCalculate" maxlength="50" value="<?php echo @arrayMap($_GET['moneyCalculate']);?>"  class="input_money form-control" placeholder="Doanh thu bán hàng">
										</td>
										<td>
											<input type="text" name="money" value="<?php echo @arrayMap($_GET['money']);?>"  class="input_money form-control" maxlength="50" placeholder="Số tiền nhân viên thu">
										</td>
										<td>
											<select name="idPlace" class="form-control" placeholder="Trạng thái thanh toán">
												<option value="">Chọn điểm đặt</option>
												<?php 
												$modelPlace= new Place;
												$listPlace=$modelPlace->find('all', array('conditions'=>array('lock'=>(int)0),'fields'=>array('name')));
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
										<td></td>
									</form>
									<form action="" method="POST">
										<td colspan="">
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
										<th class="text_table">Mã máy</th>
										<th class="text_table">Lượt thu</th>
										<th class="text_table">Mã nhân viên</th>
										<th class="text_table">Thời gian</th>
										<th class="text_table">Doanh thu bán hàng(vnđ)</th>
										<th class="text_table">Số tiền nhân viên thu(vnđ)</th>
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
											$i=$_GET['page']*500-500;
										} 
										foreach($listData as $data){
											$i++;
											echo '<tr>
											<td class="text_table">'.$i.'</td>
											<td><a href="infoMachine?id='.$data['Collection']['idMachine'].'">'.$data['Collection']['codeMachine'].'</a></td>
											<td>'.@$data['Collection']['saleSessionId'].'</td>
											<td>';
											if (!empty($data['Collection']['idStaff'])) {
											
											echo '<a href="'.$urlHomes.'viewStaff/'.@$data['Collection']['idStaff'].'">'.@$data['Collection']['codeStaff'].'</a>';
										}
											else
												{echo 'Admin';}
											echo '</td>
											<td title="Tại máy: '.date('d/m/Y H:i:s',$data['Collection']['timeClient']).'"  class="text_table">'.date(' d/m/Y H:i:s',$data['Collection']['timeServer']).'</td>
											<td style="text-align: right;">'.number_format(@$data['Collection']['moneyCalculate'], 0, ',', '.').'</td>
											
											<td  style="text-align: right;">'.number_format(@$data['Collection']['money'], 0, ',', '.').'</td>
											<td>
											<ul class="list-inline list_i" style="">
											<li><a href="/infoCollection?id='.$data['Collection']['id'].'" title="Sửa"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
											<li><a href="/viewCollection?id='.$data['Collection']['id'].'" title="Xem"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
											
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
						<?php 
						if(!empty($listData)){
							?>
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
							<?php 
						}
						?>
						
					</div>
				</div>


			</div>

			
		</div>
	</div>


	<?php include $urlLocal['urlLocalPlugin'] . 'kiosk/view/manager/footer.php'; ?>